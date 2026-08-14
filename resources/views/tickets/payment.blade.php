@extends('layouts.app')

@section('content')

<!-- Navbar -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-100 h-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 flex items-center justify-between h-full">
        <div class="flex items-center gap-3 sm:gap-4">
            <button onclick="window.history.back()" class="p-2 hover:bg-gray-100 rounded-xl transition border border-gray-100 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <div class="flex items-center gap-2 sm:gap-3">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-yellow-400 rounded-full flex items-center justify-center">
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

<!-- Payment Info Header -->
<section class="pt-16">
    <div class="bg-[#1e2a78] text-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-8 py-5 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
            <div>
                <h1 class="text-lg sm:text-xl font-bold">Pembayaran Tiket</h1>
                <p class="text-blue-200 text-[10px] sm:text-xs mt-0.5 opacity-80">Selesaikan pembayaran untuk menerbitkan E-Ticket</p>
            </div>

            <!-- Standardized Stepper -->
            <div class="flex items-center justify-center overflow-x-auto py-1">
                <div class="flex flex-col items-center gap-1.5">
                    <div class="w-7 h-7 rounded-full bg-green-500 text-white flex items-center justify-center font-bold text-xs shadow-sm ring-2 ring-white/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-[9px] font-semibold text-green-400 uppercase tracking-tighter">Pilih</span>
                </div>
                <div class="w-6 sm:w-10 h-[1px] bg-green-500 mb-5 flex-shrink-0"></div>
                <div class="flex flex-col items-center gap-1.5">
                    <div class="w-7 h-7 rounded-full bg-green-500 text-white flex items-center justify-center font-bold text-xs shadow-sm ring-2 ring-white/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-[9px] font-semibold text-green-400 uppercase tracking-tighter">Kursi</span>
                </div>
                <div class="w-6 sm:w-10 h-[1px] bg-green-500 mb-5 flex-shrink-0"></div>
                <div class="flex flex-col items-center gap-1.5">
                    <div class="w-7 h-7 rounded-full bg-green-500 text-white flex items-center justify-center font-bold text-xs shadow-sm ring-2 ring-white/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-[9px] font-semibold text-green-400 uppercase tracking-tighter">Data</span>
                </div>
                <div class="w-6 sm:w-10 h-[1px] bg-white/20 mb-5 flex-shrink-0"></div>
                <div class="flex flex-col items-center gap-1.5">
                    <div class="w-7 h-7 rounded-full bg-white text-[#1e2a78] flex items-center justify-center font-bold text-xs shadow-sm ring-2 ring-white/20">
                        4
                    </div>
                    <span class="text-[9px] font-semibold text-white uppercase tracking-tighter">Bayar</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MAIN CONTENT -->
<div class="bg-[#f0f2f5] min-h-screen pb-32">
    <div class="max-w-6xl mx-auto px-4 sm:px-8 py-6 sm:py-8 flex flex-col lg:flex-row gap-6 lg:gap-8 items-stretch lg:items-start">
        
        <!-- LEFT COLUMN: Payment Methods -->
        <div class="w-full lg:flex-1 min-w-0">
            <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-4 sm:mb-6">Pilih Metode Pembayaran</h2>

            <!-- Payment Options Form -->
            <form action="{{ route('ticket.confirm_payment', $booking->ticket_code) }}" method="POST" id="payment-form">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->ticket_code }}">
                
                <div class="space-y-4">
                    <!-- Metode Pembayaran: BCA (VA) -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-5 py-4 bg-gray-50/50 border-b border-gray-100 flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            <h3 class="font-bold text-gray-800 text-sm sm:text-base">Transfer Bank (Virtual Account)</h3>
                        </div>
                        <div class="p-4 grid grid-cols-1 gap-3">
                            <label class="flex items-start gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-blue-50/50 transition payment-option">
                                <input type="radio" name="payment_method" value="bca_va" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 mt-0.5" required checked>
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-800 text-sm">BCA Virtual Account</span>
                                    <span class="text-xs text-gray-500 mt-0.5">Pembayaran otomatis terverifikasi dengan VA BCA</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Metode Pembayaran: QRIS -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-5 py-4 bg-gray-50/50 border-b border-gray-100 flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <h3 class="font-bold text-gray-800 text-sm sm:text-base">E-Wallet & QRIS</h3>
                        </div>
                        <div class="p-4 grid grid-cols-1 gap-3">
                            <label class="flex items-start gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-green-50/50 transition payment-option">
                                <input type="radio" name="payment_method" value="qris" class="w-5 h-5 text-green-600 focus:ring-green-500 border-gray-300 mt-0.5" required>
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-800 text-sm">QRIS (Semua E-Wallet)</span>
                                    <span class="text-xs text-gray-500 mt-0.5">Scan kode QRIS menggunakan Gopay, OVO, Dana, dll</span>
                                </div>
                            </label>
                        </div>
                    </div>

                </div>
            </form>
        </div>

        <!-- RIGHT COLUMN: Booking Summary -->
        <div class="w-full lg:w-[340px] flex-shrink-0">
            <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-xl shadow-blue-900/5 lg:sticky lg:top-24 border border-gray-100">
                <h3 class="font-bold text-gray-900 text-base mb-6 pb-4 border-b border-gray-100">Ringkasan Pesanan</h3>
                
                <!-- Countdown Timer -->
                <div class="mb-6 bg-red-50 border border-red-100 rounded-2xl p-4 text-center">
                    <p class="text-[10px] font-bold text-red-500 uppercase tracking-wider mb-1">Sisa Waktu Pembayaran</p>
                    <div class="flex items-center justify-center gap-2 text-red-600">
                        <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-xl font-black font-mono tracking-widest" id="countdown-timer">30:00</span>
                    </div>
                </div>

                <div class="mb-5">
                    <p class="text-xs text-gray-400 mb-1">ID Pesanan</p>
                    <p class="font-bold text-[#1e2a78] text-sm">{{ $booking->ticket_code }}</p>
                </div>

                <!-- Trip Info -->
                <div class="flex items-start gap-4 mb-6">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center shadow-sm border border-gray-100 overflow-hidden bg-white p-1 flex-shrink-0">
                        <img src="{{ asset($trip->operator->logo_url ?? '') }}" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($trip->operator->name) }}&background=random&color=fff&size=128&bold=true&format=svg';" alt="{{ $trip->operator->name }}" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 text-sm">{{ $trip->operator->name }} ({{ $trip->bus_class }})</p>
                        <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($trip->departure_time)->translatedFormat('d M Y') }}</p>
                        <p class="text-xs font-semibold text-gray-700 mt-0.5">{{ $trip->origin->name }} &rarr; {{ $trip->destination->name }}</p>
                    </div>
                </div>

                <div class="border-t border-dashed border-gray-200 py-4 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Harga Tiket (x{{ $booking->total_passengers }})</span>
                        <span class="font-bold text-gray-800">Rp {{ number_format($trip->price * $booking->total_passengers, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-5 mt-2">
                    <div class="flex justify-between items-end mb-6">
                        <div>
                            <span class="block text-xs text-gray-500">Total Pembayaran</span>
                            <span class="block text-2xl font-bold text-[#f5a623] mt-1">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <button type="button" id="pay-btn" onclick="handlePayNow()" class="w-full py-4 bg-[#f5a623] hover:bg-[#e6991a] text-white rounded-xl font-bold text-sm shadow-lg shadow-orange-200 transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Bayar Sekarang
                    </button>
                    <p class="text-center text-[10px] text-gray-400 mt-4 flex items-center justify-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Transaksi Aman & Terenkripsi
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Radio button active states */
    input[type="radio"]:checked + span, 
    input[type="radio"]:checked ~ div span {
        color: #1e2a78;
    }
    input[type="radio"]:checked {
        accent-color: #1e2a78;
    }
    .payment-option:has(input[type="radio"]:checked) {
        border-color: #1e2a78;
        background-color: #f8fafc;
        box-shadow: 0 0 0 1px #1e2a78;
    }
</style>

<script>
    function handlePayNow() {
        const btn = document.getElementById('pay-btn');
        btn.disabled = true;
        btn.innerHTML = `<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg> Memproses...`;
        document.getElementById('payment-form').submit();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const expiryTime = {{ $booking->created_at->addMinutes(60)->timestamp * 1000 }};
        const timerEl = document.getElementById('countdown-timer');

        function updateTimer() {
            const now = Date.now();
            const diff = expiryTime - now;

            if (diff <= 0) {
                timerEl.innerText = "00:00";
                clearInterval(interval);
                timerEl.closest('.bg-red-50').innerHTML = '<p class="text-xs font-bold text-red-500 text-center">⚠️ Waktu habis</p>';
                return;
            }

            const minutes = Math.floor(diff / 60000);
            const seconds = Math.floor((diff % 60000) / 1000);
            
            const minStr = String(minutes).padStart(2, '0');
            const secStr = String(seconds).padStart(2, '0');

            timerEl.innerText = `${minStr}:${secStr}`;
        }

        updateTimer();
        const interval = setInterval(updateTimer, 1000);
    });
</script>

@endsection
