<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

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
        $notification = new Notification();
        
        $orderId = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status ?? null;

        $booking = Booking::where('ticket_code', $orderId)
            ->first();

        if (!$booking) {
            return response()->json([
                'message' => 'Booking tidak ditemukan'
            ], 404);
        }

        if (
            $transactionStatus === 'settlement' ||
            (
                $transactionStatus === 'capture' &&
                $fraudStatus === 'accept'
            )
        ) {
            if ($booking->status === 'pending') {
                $booking->update([
                    'status' => 'lunas'
                ]); 
            }
        }

        return response()->json([
            'message' => 'Notification processed'
        ], 200);

    } catch (\Exception $e) {
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

        if ($booking->status !== 'pending') {
            return redirect()->route('ticket.payment', [
                'booking_id' => $booking->ticket_code
            ])->with('error', 'Booking tidak dapat dibayar.');
        }

        if ($booking->created_at->addMinutes(30)->isPast()) {
            return redirect()->route('home')
                ->with('error', 'Batas waktu pembayaran telah habis.');
        }

        $this->configureMidtrans();

        $params = [
            'transaction_details' => [
                'order_id' => $booking->ticket_code,
                'gross_amount' => (int) $booking->total_amount,
            ],
            'customer_details' => [
                'first_name' => $booking->passengers->first()->name ?? 'Customer',
                'phone' => $booking->passengers->first()->phone ?? '',
            ],
        ];

        try {
            $snap = Snap::createTransaction($params);

            return redirect()->away($snap->redirect_url);
        } catch (\Exception $e) {
            report($e);

            return redirect()->route('ticket.payment', [
                'booking_id' => $booking->ticket_code
            ])->with('error', 'Gagal membuat pembayaran Midtrans. Silakan coba lagi.');
        }
    }
}

