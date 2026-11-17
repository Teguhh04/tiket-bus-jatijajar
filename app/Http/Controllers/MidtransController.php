<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Illuminate\Support\Facades\DB;
use Midtrans\Transaction;

class MidtransController extends Controller
{
    private function configureMidtrans()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

   
public function notification()
{
    $this->configureMidtrans();

    try {
        $notification = json_decode(request()->getContent());

        if (!is_object($notification)) {
            return response()->json([
                'message' => 'Invalid notification payload'
            ], 400);
        }

        $orderId = $notification->order_id ?? null;
        $transactionStatus = $notification->transaction_status ?? null;
        $fraudStatus = $notification->fraud_status ?? null;
        $statusCode = $notification->status_code ?? null;
        $grossAmount = $notification->gross_amount ?? null;
        $signatureKey = $notification->signature_key ?? null;
        $transactionId = $notification->transaction_id ?? null;

        $serverKey = config('services.midtrans.server_key');

        if (
            !$orderId ||
            !$statusCode ||
            !$grossAmount ||
            !$signatureKey ||
            !$serverKey
        ) {
            return response()->json([
                'message' => 'Invalid notification data'
            ], 400);
        }

        // Verifikasi signature Midtrans
        $expectedSignature = hash(
            'sha512',
            $orderId . $statusCode . $grossAmount . $serverKey
        );

        if (
            !is_string($signatureKey) ||
            !hash_equals($expectedSignature, $signatureKey)
        ) {
            return response()->json([
                'message' => 'Invalid signature'
            ], 403);
        }

        // Hanya transaksi berhasil yang boleh melunasi booking
        $isPaid =
            (string) $statusCode === '200' &&
            (
                $transactionStatus === 'settlement' ||
                (
                    $transactionStatus === 'capture' &&
                    $fraudStatus === 'accept'
                )
            );

        if (!$isPaid) {
            return response()->json([
                'message' => 'Transaction not paid'
            ], 200);
        }

       
$result = DB::transaction(function () use (
    $orderId,
    $grossAmount,
    $transactionId
) {
    $booking = Booking::where('ticket_code', $orderId)
        ->lockForUpdate()
        ->first();

    if (!$booking) {
        return 'not_found';
    }

    // Verifikasi nominal
    $midtransAmount = $this->amountToMinorUnits($grossAmount);
    $bookingAmount = $this->amountToMinorUnits(
        $booking->total_amount
    );

    if (
        $midtransAmount === null ||
        $bookingAmount === null ||
        $midtransAmount !== $bookingAmount
    ) {
        return 'amount_mismatch';
    }

    // Booking yang sudah lunas: lengkapi data pembayaran jika perlu
    if ($booking->status === 'lunas') {
        $booking->update([
            'payment_status' => 'paid',
            'paid_at' => $booking->paid_at ?? now(),
            'midtrans_transaction_id' =>
                $booking->midtrans_transaction_id ?? $transactionId,
        ]);

        return 'already_paid';
    }

    // Booking dibatalkan: catat pembayaran tanpa mengaktifkan tiket kembali
    if ($booking->status === 'dibatalkan') {
        $booking->update([
            'payment_status' => 'paid',
            'paid_at' => $booking->paid_at ?? now(),
            'midtrans_transaction_id' =>
                $booking->midtrans_transaction_id ?? $transactionId,
    ]);

            return 'paid_booking_cancelled';
    }

    // Status selain pending tidak boleh diproses
    if ($booking->status !== 'pending') {
        return 'status_not_pending';
    }
   

    // Simpan status booking dan informasi pembayaran
    $booking->update([
        'status' => 'lunas',
        'payment_status' => 'paid',
        'paid_at' => now(),
        'midtrans_transaction_id' => $transactionId,
    ]);

    return 'processed';
});


        if ($result === 'not_found') {
            return response()->json([
                'message' => 'Booking not found'
            ], 404);
        }

        if ($result === 'amount_mismatch') {
            error_log('MIDTRANS AMOUNT MISMATCH: ' . $orderId);

            return response()->json([
                'message' => 'Amount mismatch'
            ], 200);
        }

        return response()->json([
            'message' => $result
        ], 200);

    } catch (\Throwable $e) {
        error_log('MIDTRANS NOTIFICATION ERROR: ' . json_encode([
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]));

        report($e);

        return response()->json([
            'message' => 'Notification failed'
        ], 500);
    }
}


    
public function checkout($booking_id)
{
    $booking = Booking::with('passengers')
        ->where('ticket_code', $booking_id)
        ->firstOrFail();

    if ($booking->status === 'lunas' ||
        $booking->status === 'menunggu_verifikasi') {
        return redirect()->route('ticket.success', [
            'ticket_code' => $booking->ticket_code
        ]);
    }

    if ($booking->status === 'dibatalkan') {
        return redirect()->route('home')
            ->with('error', 'Booking sudah dibatalkan.');
    }

    if ($booking->status !== 'pending') {
        return redirect()->route('home')
            ->with('error', 'Status booking tidak valid.');
    }

    // Periksa status Midtrans jika booking melewati 30 menit
    if ($booking->created_at->addMinutes(30)->isPast()) {
        try {
            $this->configureMidtrans();

            $transaction = Transaction::status($booking->ticket_code);

            if (
                ($transaction->order_id ?? null) !== $booking->ticket_code ||
                empty($transaction->gross_amount) ||
                empty($transaction->transaction_status)
            ) {
                throw new \RuntimeException(
                    'Respons status transaksi Midtrans tidak valid.'
                );
            }

            $midtransAmount = $this->amountToMinorUnits(
                $transaction->gross_amount
            );

            $bookingAmount = $this->amountToMinorUnits(
                $booking->total_amount
            );

            if (
                $midtransAmount === null ||
                $bookingAmount === null ||
                $midtransAmount !== $bookingAmount
            ) {
                throw new \RuntimeException(
                    'Nominal transaksi Midtrans tidak cocok.'
                );
            }

            $status = $transaction->transaction_status;
            $fraudStatus = $transaction->fraud_status ?? null;

            
        // Transaksi sudah dibayar
        if (
             $status === 'settlement' ||
            ($status === 'capture' && $fraudStatus === 'accept')
) {
        $transactionId = $transaction->transaction_id ?? null;

        DB::transaction(function () use ($booking, $transactionId) {
         $lockedBooking = Booking::where('id', $booking->id)
            ->lockForUpdate()
            ->first();

        if (
            $lockedBooking &&
            $lockedBooking->status === 'pending'
        ) {
            $lockedBooking->update([
                'status' => 'lunas',
                'payment_status' => 'paid',
                'paid_at' => $lockedBooking->paid_at ?? now(),
                'midtrans_transaction_id' => $transactionId,
            ]);
        }
    });

    return redirect()->route('ticket.success', [
        'ticket_code' => $booking->ticket_code
    ]);
}

            // Transaksi masih menunggu pembayaran
            if ($status === 'pending') {
                return redirect()->route('ticket.payment', [
                    'booking_id' => $booking->ticket_code
                ])->with(
                    'error',
                    'Transaksi masih menunggu pembayaran. Silakan selesaikan pembayaran.'
                );
            }

            // Hanya status terminal yang boleh membatalkan booking
            if (in_array($status, [
                'expire',
                'cancel',
                'deny',
                'failure'
            ], true)) {
                DB::transaction(function () use ($booking) {
                    $lockedBooking = Booking::where('id', $booking->id)
                        ->lockForUpdate()
                        ->first();

                    if ($lockedBooking &&
                        $lockedBooking->status === 'pending') {
                        $lockedBooking->update([
                            'status' => 'dibatalkan'
                        ]);

                        $trip = $lockedBooking->trip;

                        if ($trip) {
                            $trip->increment(
                                'available_seats',
                                $lockedBooking->total_passengers
                            );
                        }
                    }
                });

                return redirect()->route('home')
                    ->with(
                        'error',
                        'Transaksi telah berakhir dan booking dibatalkan.'
                    );
            }

            throw new \RuntimeException(
                'Status transaksi Midtrans belum dikenali.'
            );

        } catch (\Throwable $e) {
            error_log('MIDTRANS CHECKOUT STATUS ERROR: ' . json_encode([
                'message' => $e->getMessage(),
                'order_id' => $booking->ticket_code,
            ]));

            report($e);

            return redirect()->route('ticket.payment', [
                'booking_id' => $booking->ticket_code
            ])->with(
                'error',
                'Status pembayaran belum dapat diverifikasi. Silakan coba kembali.'
            );
        }
    }

    // Booking masih dalam batas waktu: buat transaksi Snap
    $this->configureMidtrans();

    $passenger = $booking->passengers->first();

    $params = [
        'transaction_details' => [
            'order_id' => $booking->ticket_code,
            'gross_amount' => (int) $booking->total_amount,
        ],
        'customer_details' => [
            'first_name' => $passenger?->name ?? 'Customer',
            'phone' => $passenger?->phone ?? '',
        ],
    ];

    try {
        $snap = Snap::createTransaction($params);

        return redirect()->away($snap->redirect_url);

    } catch (\Throwable $e) {
        error_log('MIDTRANS CHECKOUT ERROR: ' . json_encode([
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]));

        report($e);

        return redirect()->route('ticket.payment', [
            'booking_id' => $booking->ticket_code
        ])->with(
            'error',
            'Gagal membuat pembayaran Midtrans. Silakan coba lagi.'
        );
    }
}


private function amountToMinorUnits($amount): ?int
{
    if (!is_string($amount) && !is_numeric($amount)) {
        return null;
    }

    $amount = (string) $amount;

    if (!preg_match('/^\d+(?:\.\d{1,2})?$/', $amount)) {
        return null;
    }

    $parts = explode('.', $amount, 2);

    $whole = (int) $parts[0];
    $decimal = (int) str_pad(
        $parts[1] ?? '',
        2,
        '0'
    );

    return ($whole * 100) + $decimal;
}

}
