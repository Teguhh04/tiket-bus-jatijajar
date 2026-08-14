@extends('layouts.app')

@section('content')
<!-- Navbar -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-100 h-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 flex items-center justify-between h-full">
        <div class="flex items-center gap-3 sm:gap-4">
            <a href="{{ route('home') }}" class="p-2 hover:bg-gray-100 rounded-xl transition border border-gray-100 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div class="flex items-center gap-2 sm:gap-3">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-yellow-400 rounded-full flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.22.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                </div>
                <div>
                    <span class="text-base sm:text-lg font-black tracking-tight text-[#1e2a78] block leading-none">Jatijajar</span>
                    <span class="text-[8px] sm:text-[9px] tracking-[0.2em] font-bold text-slate-400 uppercase mt-1 block">TIKET ONLINE</span>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-4 sm:gap-6">
            <div class="flex items-center gap-1.5 sm:gap-2 text-xs sm:text-sm text-gray-500 font-bold cursor-pointer hover:text-[#1e2a78] transition">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="hidden xs:inline">Bantuan</span>
            </div>
            <button class="p-2 hover:bg-gray-100 rounded-xl transition border border-gray-100 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>
</nav>

<div class="bg-[#f0f2f5] min-h-screen pt-24 pb-32 flex flex-col items-center justify-center relative overflow-hidden">
    <!-- Confetti Background (Optional subtle decoration) -->
    <div class="absolute inset-0 pointer-events-none opacity-40 mix-blend-multiply flex justify-center items-center">
        <div class="w-[500px] h-[500px] bg-blue-300 rounded-full blur-3xl opacity-20 -mt-20"></div>
        <div class="w-[300px] h-[300px] bg-green-300 rounded-full blur-3xl opacity-20 absolute top-10 right-20"></div>
    </div>

    <!-- Success/Pending Message -->
    <div class="text-center mb-8 relative z-10 px-4">
        @if($realBooking->status == 'menunggu_verifikasi')
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-blue-500 rounded-full mx-auto flex items-center justify-center text-white mb-4 shadow-xl shadow-blue-500/30 ring-8 ring-blue-100">
                <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-[#1e2a78]">Menunggu Verifikasi</h1>
            <p class="text-sm text-gray-500 mt-2">Admin sedang memverifikasi pembayaran Anda. Mohon tunggu sebentar.</p>
        @elseif($realBooking->status == 'pending')
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-orange-500 rounded-full mx-auto flex items-center justify-center text-white mb-4 shadow-xl shadow-orange-500/30 ring-8 ring-orange-100">
                <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-[#1e2a78]">Menunggu Pembayaran</h1>
            <p class="text-sm text-gray-500 mt-2">Selesaikan pembayaran Anda untuk menerbitkan E-Tiket.</p>
        @elseif($realBooking->status == 'batal')
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-red-500 rounded-full mx-auto flex items-center justify-center text-white mb-4 shadow-xl shadow-red-500/30 ring-8 ring-red-100">
                <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-[#1e2a78]">Pesanan Dibatalkan</h1>
            <p class="text-sm text-gray-500 mt-2">Waktu pembayaran telah habis atau pesanan dibatalkan oleh sistem.</p>
        @else
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-green-500 rounded-full mx-auto flex items-center justify-center text-white mb-4 shadow-xl shadow-green-500/30 ring-8 ring-green-100">
                <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-[#1e2a78]">Pembayaran Berhasil!</h1>
            <p class="text-sm text-gray-500 mt-2">E-Tiket Anda telah diterbitkan dan siap digunakan.</p>
        @endif
    </div>

    <!-- E-Ticket Card -->
    <div class="flex flex-wrap justify-center gap-6 w-full max-w-6xl relative z-10 px-4 sm:px-8">
        @foreach($realBooking->passengers as $passenger)
        <div class="w-full max-w-sm relative">
            <!-- Top Ticket -->
            <div class="bg-white rounded-t-3xl p-6 sm:p-8 shadow-xl relative pb-10">
                <div class="flex justify-between items-start border-b border-gray-100 pb-4 mb-4">
                    <div>
                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Kode Booking</p>
                        <p class="text-lg sm:text-xl font-bold text-[#1e2a78] tracking-widest mt-0.5">{{ $booking->code }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Keberangkatan</p>
                        <p class="text-xs sm:text-sm font-bold text-gray-800 mt-0.5">{{ $booking->date }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Nama Penumpang</p>
                        <p class="text-sm sm:text-base font-bold text-gray-800">{{ $passenger->name }}</p>
                    </div>
                    <div class="flex justify-between">
                        <div>
                            <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Nomor Kursi</p>
                            <p class="text-xl sm:text-2xl font-bold text-[#f5a623]">{{ $passenger->seat_number }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Status</p>
                            @if($realBooking->status == 'menunggu_verifikasi')
                                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 text-[10px] sm:text-xs font-bold rounded-full mt-1">PENDING</span>
                            @elseif($realBooking->status == 'lunas')
                                <span class="inline-block px-3 py-1 bg-green-100 text-green-700 text-[10px] sm:text-xs font-bold rounded-full mt-1">LUNAS</span>
                            @else
                                <span class="inline-block px-3 py-1 bg-gray-100 text-gray-700 text-[10px] sm:text-xs font-bold rounded-full mt-1">{{ strtoupper($realBooking->status) }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Cutout holes for ticket effect -->
                <div class="absolute -bottom-4 -left-4 w-8 h-8 bg-[#f0f2f5] rounded-full shadow-inner"></div>
                <div class="absolute -bottom-4 -right-4 w-8 h-8 bg-[#f0f2f5] rounded-full shadow-inner"></div>
            </div>

            <!-- Dashed Line Divider -->
            <div class="h-0 border-t-2 border-dashed border-gray-200 relative z-20 mx-4"></div>

            <!-- Bottom Ticket: QR Code -->
            <div class="bg-white rounded-b-3xl p-6 sm:p-8 shadow-xl relative pt-10 text-center">
                <p class="text-xs text-gray-500 font-medium mb-4">Tunjukkan QR Code ini ke petugas saat naik bus.</p>
                
                <div class="inline-block p-4 bg-white border-2 border-gray-100 rounded-2xl shadow-sm">
                    <!-- Using an external QR Code API -->
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($booking->code . '-SEAT-' . $passenger->seat_number) }}" alt="QR Code E-Tiket" class="w-32 h-32 sm:w-40 sm:h-40 object-contain mx-auto mix-blend-multiply">
                </div>

                <p class="text-[10px] text-gray-400 mt-4 tracking-widest uppercase">{{ $booking->code }}</p>
            </div>
        </div>
        @endforeach
    </div>

    @php
        // Persiapkan pesan untuk dikirim via WA
        $waMessage = "*E-TIKET JATIJAJAR*\n\n";
        $waMessage .= "Kode Booking: *" . $booking->code . "*\n";
        $waMessage .= "Nama: " . $booking->passenger_name . "\n";
        $waMessage .= "Keberangkatan: " . $booking->date . "\n";
        $waMessage .= "Rute: " . $realBooking->trip->origin->city . " - " . $realBooking->trip->destination->city . "\n";
        $waMessage .= "PO Bus: " . $realBooking->trip->operator->name . "\n";
        $waMessage .= "Kursi: " . $booking->seat . "\n\n";
        $waMessage .= "Status: *" . ($realBooking->status == 'lunas' ? 'LUNAS (VALID)' : 'PENDING VERIFIKASI') . "*\n\n";
        
        if($realBooking->status == 'lunas') {
            $waMessage .= "📄 *Download E-Tiket (PDF):*\n" . route('ticket.print', $realBooking->ticket_code) . "\n\n";
        }
        
        $waMessage .= "Terima kasih telah memesan tiket di Jatijajar!";
        
        // Dapatkan nomor HP penumpang (format 62...)
        $phone = $realBooking->passengers->first()->phone;
        // Ubah 08 jadi 628
        if (substr($phone, 0, 1) == '0') {
            $phone = '62' . substr($phone, 1);
        }
        
        $waLink = "https://wa.me/" . $phone . "?text=" . urlencode($waMessage);
    @endphp

    <!-- Action Buttons -->
    <div class="mt-10 flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-3 sm:gap-4 w-full px-4 sm:px-0 max-w-sm sm:max-w-none">
        <a href="{{ route('home') }}" class="px-8 py-3 bg-white text-[#1e2a78] font-bold rounded-xl shadow-sm hover:bg-gray-50 border border-gray-200 transition text-center">Ke Beranda</a>
        
        <!-- Tombol Kirim ke WA (Fitur Riil) -->
        <a href="{{ $waLink }}" target="_blank" class="px-8 py-3 bg-[#25D366] text-white font-bold rounded-xl shadow-lg shadow-green-500/30 hover:bg-[#1ebd5a] transition flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.717-1.458L0 24zm6.09-3.931l.317.188c1.603.951 3.565 1.454 5.591 1.455 5.767 0 10.457-4.687 10.46-10.461.002-2.8-.1-5.419-2.062-7.382C18.462 2.288 15.845.986 12.008.986c-5.772 0-10.462 4.69-10.465 10.468-.001 2.07.509 4.093 1.478 5.712l.206.347-1.08 3.945 4.01-1.053zm11.393-7.794c-.303-.151-1.793-.884-2.071-.985-.278-.101-.48-.151-.68.151-.2.302-.774.985-.949 1.186-.176.201-.351.226-.654.076-.303-.151-1.278-.47-2.434-1.502-.899-.802-1.507-1.793-1.684-2.094-.176-.302-.019-.465.132-.615.136-.135.303-.352.454-.528.151-.176.201-.302.303-.503.101-.201.05-.377-.025-.528-.076-.151-.68-1.637-.932-2.24-.247-.591-.497-.512-.68-.521-.176-.009-.377-.01-.579-.01-.201 0-.528.076-.804.377-.277.302-1.056 1.03-1.056 2.512 0 1.48 1.08 2.915 1.23 3.116.151.2 2.126 3.245 5.15 4.554.719.311 1.28.497 1.718.637.722.23 1.38.197 1.902.12.58-.087 1.794-.73 2.046-1.433.253-.703.253-1.306.177-1.433-.075-.125-.277-.176-.58-.327z"/></svg>
            Kirim ke WA Saya
        </a>

        @if($realBooking->status === 'lunas')
            <a href="{{ route('ticket.print', $realBooking->ticket_code) }}" target="_blank" class="px-8 py-3 bg-[#1e2a78] text-white font-bold rounded-xl shadow-lg shadow-blue-900/30 hover:bg-[#151d54] transition flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Cetak PDF
            </a>
        @else
            <button disabled class="px-8 py-3 bg-gray-200 text-gray-400 font-bold rounded-xl cursor-not-allowed flex items-center justify-center gap-2 border border-gray-300" title="E-Tiket dapat dicetak setelah pembayaran Lunas">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Cetak PDF (Kunci)
            </button>
        @endif
    </div>
</div>

@if(session('success_payment'))
<!-- SIMULATED NOTIFICATION TOAST OVERLAYS -->
<div class="fixed bottom-6 right-6 z-50 flex flex-col gap-4 max-w-sm w-full pointer-events-none" id="notification-container">
    <!-- WhatsApp Notification Toast -->
    <div class="bg-white rounded-2xl shadow-2xl border border-emerald-100 p-4 transform translate-y-20 opacity-0 transition duration-500 ease-out flex items-start gap-3 pointer-events-auto" id="whatsapp-toast">
        <div class="w-10 h-10 bg-emerald-500 text-white rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.717-1.458L0 24zm6.09-3.931l.317.188c1.603.951 3.565 1.454 5.591 1.455 5.767 0 10.457-4.687 10.46-10.461.002-2.8-.1-5.419-2.062-7.382C18.462 2.288 15.845.986 12.008.986c-5.772 0-10.462 4.69-10.465 10.468-.001 2.07.509 4.093 1.478 5.712l.206.347-1.08 3.945 4.01-1.053zm11.393-7.794c-.303-.151-1.793-.884-2.071-.985-.278-.101-.48-.151-.68.151-.2.302-.774.985-.949 1.186-.176.201-.351.226-.654.076-.303-.151-1.278-.47-2.434-1.502-.899-.802-1.507-1.793-1.684-2.094-.176-.302-.019-.465.132-.615.136-.135.303-.352.454-.528.151-.176.201-.302.303-.503.101-.201.05-.377-.025-.528-.076-.151-.68-1.637-.932-2.24-.247-.591-.497-.512-.68-.521-.176-.009-.377-.01-.579-.01-.201 0-.528.076-.804.377-.277.302-1.056 1.03-1.056 2.512 0 1.48 1.08 2.915 1.23 3.116.151.2 2.126 3.245 5.15 4.554.719.311 1.28.497 1.718.637.722.23 1.38.197 1.902.12.58-.087 1.794-.73 2.046-1.433.253-.703.253-1.306.177-1.433-.075-.125-.277-.176-.58-.327z"/></svg>
        </div>
        <div class="flex-1">
            <div class="flex justify-between items-center mb-1">
                <span class="text-xs font-black text-slate-800">WhatsApp Notification</span>
                <span class="text-[9px] font-bold text-emerald-600">Baru Saja</span>
            </div>
            <p class="text-xs font-bold text-slate-700 leading-tight">Halo {{ $booking->passenger_name }},</p>
            <p class="text-[11px] text-slate-500 leading-normal mt-0.5">Tagihan pemesanan tiket Anda **{{ $booking->code }}** telah dibuat. Mohon tunggu verifikasi pembayaran oleh admin.</p>
        </div>
    </div>

    <!-- Email Notification Toast -->
    <div class="bg-white rounded-2xl shadow-2xl border border-blue-100 p-4 transform translate-y-20 opacity-0 transition duration-500 ease-out flex items-start gap-3 pointer-events-auto" id="email-toast">
        <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <div class="flex-1">
            <div class="flex justify-between items-center mb-1">
                <span class="text-xs font-black text-slate-800">Email Notification</span>
                <span class="text-[9px] font-bold text-blue-600">Baru Saja</span>
            </div>
            <p class="text-xs font-bold text-slate-700 leading-tight">Subjek: Detail Instruksi & E-Ticket PENDING</p>
            <p class="text-[11px] text-slate-500 leading-normal mt-0.5">Instruksi pembayaran tiket dengan kode booking **{{ $booking->code }}** telah terkirim ke email Anda. Cek berkas lampiran Anda.</p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const waToast = document.getElementById('whatsapp-toast');
        const emailToast = document.getElementById('email-toast');

        // Slide in WhatsApp Toast after 800ms
        setTimeout(() => {
            waToast.classList.remove('translate-y-20', 'opacity-0');
            waToast.classList.add('translate-y-0', 'opacity-100');
            playNotificationSound();
        }, 800);

        // Slide in Email Toast after 2500ms
        setTimeout(() => {
            emailToast.classList.remove('translate-y-20', 'opacity-0');
            emailToast.classList.add('translate-y-0', 'opacity-100');
            playNotificationSound();
        }, 2500);

        // Auto dismiss WhatsApp toast after 8000ms
        setTimeout(() => {
            waToast.classList.add('opacity-0', 'translate-x-20');
        }, 8000);

        // Auto dismiss Email toast after 10000ms
        setTimeout(() => {
            emailToast.classList.add('opacity-0', 'translate-x-20');
        }, 10000);
    });

    function playNotificationSound() {
        try {
            const context = new (window.AudioContext || window.webkitAudioContext)();
            const osc = context.createOscillator();
            const gain = context.createGain();
            
            osc.connect(gain);
            gain.connect(context.destination);
            
            osc.type = 'sine';
            osc.frequency.setValueAtTime(587.33, context.currentTime); // D5
            osc.frequency.setValueAtTime(880, context.currentTime + 0.08); // A5
            
            gain.gain.setValueAtTime(0.04, context.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.0001, context.currentTime + 0.25);
            
            osc.start(context.currentTime);
            osc.stop(context.currentTime + 0.25);
        } catch(e) {
            // Audio context not supported
        }
    }
</script>
@endif

@endsection
