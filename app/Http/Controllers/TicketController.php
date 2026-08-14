<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Booking;
use App\Models\Passenger;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {
        return view('layouts.home');
    }

    public function search(Request $request)
    {
        $origin = $request->query('origin', 'Depok');
        $destination = $request->query('destination');
        $date = $request->query('date', date('Y-m-d'));

        $query = Trip::with(['operator', 'origin', 'destination'])
                     ->where('available_seats', '>', 0)
                     ->where('departure_time', '>', now());

        // Filter by destination
        if ($destination) {
            $query->whereHas('destination', function ($q) use ($destination) {
                $q->where('name', 'like', "%{$destination}%")
                  ->orWhere('city', 'like', "%{$destination}%");
            });
        }

        // Filter by departure date
        if ($date) {
            $query->whereDate('departure_time', $date);
        }

        $trips = $query->get();

        return view('tickets.search', compact('trips', 'origin', 'destination', 'date'));
    }

    public function selectSeat($id)
    {
        $trip = Trip::with(['operator', 'origin', 'destination'])->findOrFail($id);

        return view('tickets.select_seat', compact('trip'));
    }

    public function show($id)
    {
        $trip = Trip::with(['operator', 'origin', 'destination'])->findOrFail($id);

        return view('tickets.detail', compact('trip'));
    }

    public function book($id)
    {
        $trip = Trip::with(['operator', 'origin', 'destination'])->findOrFail($id);

        return view('tickets.booking_form', compact('trip'));
    }

    public function storeBooking(Request $request, $id)
    {
        // Validasi server-side
        $request->validate([
            'passengers'          => 'required|array|min:1',
            'passengers.*.name'   => 'required|string|max:255',
            'passengers.*.phone'  => 'required|string|min:9|max:15',
            'passengers.*.nik'    => 'required|digits:16',
            'passengers.*.gender' => 'required|in:Laki-laki,Perempuan',
        ], [
            'passengers.*.name.required'   => 'Nama penumpang wajib diisi.',
            'passengers.*.phone.required'  => 'Nomor telepon wajib diisi.',
            'passengers.*.phone.min'       => 'Nomor telepon minimal 9 digit.',
            'passengers.*.nik.required'    => 'NIK wajib diisi.',
            'passengers.*.nik.digits'      => 'NIK harus 16 digit angka.',
            'passengers.*.gender.required' => 'Jenis kelamin wajib dipilih.',
        ]);

        $trip = Trip::findOrFail($id);
        $passengerData = $request->input('passengers');
        $count = count($passengerData);

        // Pastikan kursi masih tersedia
        if ($trip->available_seats < $count) {
            return redirect()->back()->with('error', 'Maaf, kursi yang tersedia tidak mencukupi. Silakan pilih kursi lain.');
        }

        $booking = Booking::create([
            'ticket_code'       => 'BK-' . strtoupper(Str::random(8)),
            'trip_id'           => $id,
            'user_id'           => Auth::id(),
            'total_passengers'  => $count,
            'ticket_price'      => $trip->price,
            'admin_fee'         => 0,
            'total_amount'      => ($trip->price * $count),
            'status'            => 'pending',
        ]);

        foreach ($passengerData as $index => $data) {
            Passenger::create([
                'booking_id'  => $booking->id,
                'name'        => $data['name'],
                'phone'       => $data['phone'],
                'nik'         => $data['nik'],
                'gender'      => $data['gender'],
                'seat_number' => $data['seat_number'] ?? ('Kursi ' . $index),
            ]);
        }

        // Kurangi jumlah kursi tersedia
        $trip->decrement('available_seats', $count);

        return redirect()->route('ticket.payment', ['booking_id' => $booking->ticket_code]);
    }

    private function checkBookingStatusAndExpiration(Booking $booking)
    {
        // 1. Jika status lunas atau menunggu verifikasi, langsung arahkan ke e-ticket / sukses
        if (in_array($booking->status, ['lunas', 'menunggu_verifikasi'])) {
            return redirect()->route('ticket.success', ['ticket_code' => $booking->ticket_code]);
        }

        // 2. Jika status batal, atau jika pending tapi sudah lewat 30 menit
        if ($booking->status === 'batal' || ($booking->status === 'pending' && $booking->created_at->addMinutes(30)->isPast())) {
            if ($booking->status === 'pending') {
                $booking->update(['status' => 'batal']);
                if ($booking->trip) {
                    $booking->trip->increment('available_seats', $booking->total_passengers);
                }
            }
            return redirect()->route('home')->with('error', 'Pemesanan ini telah dibatalkan karena batas waktu pembayaran habis.');
        }

        return null;
    }

    public function payment(Request $request, $booking_id)
    {
        $booking = Booking::with(['trip.operator', 'trip.origin', 'trip.destination', 'passengers'])
                          ->where('ticket_code', $booking_id)
                          ->firstOrFail();

        $redirect = $this->checkBookingStatusAndExpiration($booking);
        if ($redirect) {
            return $redirect;
        }

        return view('tickets.payment', [
            'booking' => $booking,
            'trip' => $booking->trip,
            'totalPrice' => $booking->total_amount
        ]);
    }

    public function confirmPayment(Request $request, $booking_id)
    {
        $booking = Booking::where('ticket_code', $booking_id)->firstOrFail();
        
        $redirect = $this->checkBookingStatusAndExpiration($booking);
        if ($redirect) {
            return $redirect;
        }

        $booking->update([
            'payment_method' => $request->input('payment_method', 'Transfer Bank')
        ]);

        return redirect()->route('ticket.instructions', ['booking_id' => $booking_id]);
    }

    public function instructions($booking_id)
    {
        $booking = Booking::with(['trip.operator', 'trip.origin', 'trip.destination', 'passengers'])
                          ->where('ticket_code', $booking_id)
                          ->firstOrFail();

        $redirect = $this->checkBookingStatusAndExpiration($booking);
        if ($redirect) {
            return $redirect;
        }

        // Ambil kode bayar dari session, atau generate baru jika belum ada
        $sessionKey = 'payment_code_' . $booking->ticket_code;
        $paymentCode = session($sessionKey);

        if (!$paymentCode) {
            $method = strtoupper($booking->payment_method);
            if (in_array($method, ['GOPAY', 'OVO', 'DANA'])) {
                $paymentCode = '08' . rand(100000000, 999999999);
            } elseif (in_array($method, ['BCA', 'BNI', 'BRI', 'MANDIRI'])) {
                $paymentCode = rand(1000, 9999) . rand(1000, 9999) . rand(1000, 9999);
            } else {
                $paymentCode = 'PAY-' . strtoupper(Str::random(10));
            }
            session([$sessionKey => $paymentCode]);
        }

        return view('tickets.instructions', [
            'booking'     => $booking,
            'paymentCode' => $paymentCode
        ]);
    }

    public function processPayment(Request $request, $booking_id)
    {
        $booking = Booking::where('ticket_code', $booking_id)->firstOrFail();
        
        $redirect = $this->checkBookingStatusAndExpiration($booking);
        if ($redirect) {
            return $redirect;
        }

        $request->validate([
            'payment_proof' => 'required|image|max:2048'
        ]);

        $updateData = [
            'status' => 'menunggu_verifikasi' // Kembali ke admin verifikasi
        ];

        // Store payment proof image
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = 'proof_' . $booking_id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('proofs', $filename, 'public');
            $updateData['payment_proof'] = 'storage/' . $path;
        }

        $booking->update($updateData);

        return redirect()->route('ticket.success', ['ticket_code' => $booking_id])
                         ->with('success_payment', true);
    }

    public function success($ticket_code)
    {
        $booking = Booking::with(['trip.operator', 'trip.origin', 'trip.destination', 'passengers'])
                          ->where('ticket_code', $ticket_code)
                          ->firstOrFail();

        // Menyusun data URL untuk QR Code agar saat discan langsung membuka E-Tiket Riil
        $qrDataUrl = route('ticket.print', ['ticket_code' => $booking->ticket_code]);

        // Mengirim data ke view success dengan format yang diharapkan
        $displayBooking = (object)[
            'code' => $booking->ticket_code,
            'passenger_name' => $booking->passengers->first()->name,
            'date' => \Carbon\Carbon::parse($booking->trip->departure_time)->translatedFormat('d F Y'),
            'seat' => $booking->passengers->pluck('seat_number')->implode(', '),
            'qr_data' => $qrDataUrl
        ];

        return view('tickets.success', ['booking' => $displayBooking, 'realBooking' => $booking]);
    }

    public function printTicket($ticket_code)
    {
        $booking = Booking::with(['trip.operator', 'trip.origin', 'trip.destination', 'passengers'])
                          ->where('ticket_code', $ticket_code)
                          ->firstOrFail();

        if ($booking->status !== 'lunas') {
            return redirect()->route('ticket.success', ['ticket_code' => $ticket_code])
                             ->with('error', 'E-Tiket hanya dapat dicetak setelah status pembayaran Lunas.');
        }

        return view('tickets.print', ['booking' => $booking]);
    }

    public function showCheckStatusForm()
    {
        return view('tickets.check_status');
    }

    public function checkStatus(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string'
        ]);

        $identifier = trim(strtoupper($request->input('identifier')));
        $cleanPhone = str_replace([' ', '-', '+62', '^08'], '', trim($request->input('identifier')));

        $booking = Booking::with('passengers')
                          ->where('ticket_code', $identifier)
                          ->orWhereHas('passengers', function($q) use ($cleanPhone) {
                              // Pencarian berdasarkan nomor HP yang cocok walau tidak persis
                              $q->where('phone', 'like', "%{$cleanPhone}%");
                          })
                          ->latest()
                          ->first();

        if (!$booking) {
            return redirect()->back()->with('error', 'Kode tiket atau nomor handphone tidak ditemukan.');
        }

        // Redirect sesuai status booking
        if ($booking->status === 'pending') {
            // Jika pending tapi sudah kadaluarsa 30 menit
            if ($booking->created_at->addMinutes(30)->isPast()) {
                $booking->update(['status' => 'batal']);
                if ($booking->trip) {
                    $booking->trip->increment('available_seats', $booking->total_passengers);
                }
                return redirect()->back()->with('error', 'Pemesanan dengan kode tersebut telah dibatalkan karena batas waktu pembayaran habis.');
            }
            return redirect()->route('ticket.payment', ['booking_id' => $booking->ticket_code]);
        } elseif ($booking->status === 'batal') {
            return redirect()->back()->with('error', 'Pemesanan dengan kode tersebut telah dibatalkan.');
        } else {
            // Menunggu verifikasi atau lunas
            return redirect()->route('ticket.success', ['ticket_code' => $booking->ticket_code]);
        }
    }

    public function bantuan()
    {
        return view('pages.bantuan');
    }

    public function akun()
    {
        $bookings = Booking::with(['trip.operator', 'trip.origin', 'trip.destination', 'passengers'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pages.akun', compact('bookings'));
    }

}
