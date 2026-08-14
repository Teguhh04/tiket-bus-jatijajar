@extends('layouts.app')

@section('content')

<!-- Navbar -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-100 h-16">
    <div class="max-w-7xl mx-auto px-8 flex items-center justify-between h-full">
        <div class="flex items-center gap-4">
            <button onclick="window.history.back()" class="p-2.5 hover:bg-gray-100 rounded-xl transition border border-gray-100 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.22.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                </div>
                <div>
                    <span class="text-lg font-black tracking-tight text-[#1e2a78] block leading-none">Jatijajar</span>
                    <span class="text-[9px] tracking-[0.2em] font-bold text-slate-400 uppercase mt-1 block">TIKET ONLINE</span>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="bg-[#f0f2f5] min-h-screen pt-24 pb-32">
    <div class="max-w-2xl mx-auto px-8">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-[#1e2a78]">Instruksi Pembayaran</h1>
            <p class="text-gray-500 mt-2">Selesaikan pembayaran Anda sebelum batas waktu habis.</p>
        </div>

        <!-- Instruction Card -->
        <div class="bg-white rounded-3xl shadow-xl shadow-blue-900/5 overflow-hidden border border-gray-100">
            <div class="p-5 sm:p-8 text-center border-b border-gray-50">
                <p class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 sm:mb-4">Total Pembayaran</p>
                <p class="text-2xl sm:text-4xl font-black text-[#f5a623]">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</p>
                
                <!-- Real-time Countdown Banner -->
                <div class="mt-5 sm:mt-6 inline-flex flex-col items-center gap-1.5 sm:gap-2 p-3 sm:p-4 bg-red-50 border border-red-100 rounded-2xl w-full max-w-sm mx-auto">
                    <p class="text-[9px] sm:text-[10px] font-bold text-red-500 uppercase tracking-wider">Selesaikan Pembayaran Dalam</p>
                    <div class="flex items-center gap-1.5 sm:gap-2 text-red-600">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-xl sm:text-2xl font-black font-mono tracking-widest" id="countdown-timer">30:00</span>
                    </div>
                    <p class="text-[8px] sm:text-[9px] text-red-400 mt-1 font-semibold">Batas Waktu: {{ $booking->created_at->addMinutes(30)->format('H:i') }} WIB</p>
                </div>
            </div>

            <div class="p-8 space-y-8">
                <!-- Payment Code Section -->
                <div class="bg-gray-50 rounded-2xl p-6 border border-dashed border-gray-200">
                    <div class="flex justify-between items-center mb-6 border-b border-gray-200 pb-4">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Metode: BCA (VA & QRIS)</span>
                        <div class="flex gap-2 items-center">
                            <div class="text-[#1e2a78] font-bold text-sm italic">BCA</div>
                            <div class="text-[#ed3237] font-bold text-sm italic border-l border-gray-300 pl-2">QRIS</div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col md:flex-row gap-6 items-center justify-between">
                        <!-- Virtual Account -->
                        <div class="flex-1 w-full text-center md:text-left">
                            <p class="text-[10px] text-gray-400 uppercase font-bold mb-2">Nomor Virtual Account BCA</p>
                            <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-3 sm:gap-4">
                                <span class="text-lg sm:text-2xl font-black text-[#1e2a78] tracking-wider break-all px-2" id="payment-code">{{ $paymentCode }}</span>
                                <button type="button" onclick="copyToClipboard()" class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 rounded-lg text-xs font-bold text-blue-600 transition flex items-center gap-1 border border-blue-100 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                    Salin
                                </button>
                            </div>
                            <p class="text-[10px] text-gray-500 mt-2">Bisa dibayar dari BCA Mobile, KlikBCA, atau ATM BCA.</p>
                        </div>

                        <!-- OR separator -->
                        <div class="hidden md:flex flex-col items-center justify-center">
                            <div class="h-8 w-px bg-gray-300"></div>
                            <span class="text-[10px] font-bold text-gray-400 uppercase my-2">ATAU</span>
                            <div class="h-8 w-px bg-gray-300"></div>
                        </div>

                        <!-- QRIS -->
                        <div class="flex-shrink-0 text-center">
                            <p class="text-[10px] text-gray-400 uppercase font-bold mb-2">Scan QRIS (OVO, GoPay, DANA, dll)</p>
                            <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 inline-block">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $paymentCode }}&margin=10" alt="QRIS Code" class="w-[120px] h-[120px]">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Steps -->
                <div class="space-y-4 text-sm text-gray-600">
                    <h4 class="font-bold text-gray-800 mb-2">Cara Pembayaran:</h4>
                    <div class="flex gap-4">
                        <div class="w-6 h-6 rounded-full bg-[#1e2a78] text-white flex-shrink-0 flex items-center justify-center text-[10px] font-bold">1</div>
                        <p>Buka aplikasi Mobile Banking / E-Wallet Anda (BCA Mobile, OVO, GoPay, DANA, dll).</p>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-6 h-6 rounded-full bg-[#1e2a78] text-white flex-shrink-0 flex items-center justify-center text-[10px] font-bold">2</div>
                        <p>Untuk VA: Pilih menu Transfer > Virtual Account dan masukkan kode <span class="font-bold text-gray-800">{{ $paymentCode }}</span>.</p>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-6 h-6 rounded-full bg-[#1e2a78] text-white flex-shrink-0 flex items-center justify-center text-[10px] font-bold">3</div>
                        <p>Untuk QRIS: Pilih menu Scan QR / Bayar dan arahkan kamera ke gambar QRIS di atas.</p>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-6 h-6 rounded-full bg-[#1e2a78] text-white flex-shrink-0 flex items-center justify-center text-[10px] font-bold">4</div>
                        <p>Pastikan nominal sesuai dengan tagihan: <span class="font-bold text-gray-800">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>.</p>
                    </div>
                </div>
            </div>

            <!-- Footer Action -->
            <div class="p-8 bg-gray-50 border-t border-gray-100">
                <form action="{{ route('ticket.process_payment', $booking->ticket_code) }}" method="POST" enctype="multipart/form-data" id="payment-confirm-form">
                    @csrf
                    
                    <!-- Upload Bukti Pembayaran (Opsional) -->
                    <div class="mb-6 text-left">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2.5 ml-1">
                            Unggah Bukti Transfer 
                            <span class="text-gray-300 normal-case font-normal tracking-normal">(Opsional, untuk catatan)</span>
                        </label>
                        <div class="relative border-2 border-dashed border-gray-200 hover:border-[#1e2a78] rounded-2xl p-6 transition bg-white group cursor-pointer text-center" id="upload-container">
                            <input type="file" name="payment_proof" id="payment_proof_input" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            
                            <!-- Placeholder -->
                            <div class="space-y-2" id="upload-placeholder">
                                <div class="w-12 h-12 bg-blue-50 text-[#1e2a78] rounded-xl flex items-center justify-center mx-auto shadow-sm group-hover:scale-105 transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <p class="text-xs font-bold text-slate-700">Pilih Foto atau Seret ke Sini</p>
                                <p class="text-[9px] text-slate-400 font-semibold uppercase tracking-wider">Maks 2MB (PNG, JPG)</p>
                            </div>
                            
                            <!-- Preview Container -->
                            <div class="hidden space-y-3" id="upload-preview-container">
                                <img id="upload-preview" class="max-h-48 mx-auto rounded-xl shadow-md border border-gray-200 object-contain">
                                <p class="text-[11px] font-bold text-green-600 flex items-center justify-center gap-1.5 bg-green-50 px-3 py-1.5 rounded-full w-fit mx-auto border border-green-100">
                                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    Foto terpilih: <span id="file-name" class="font-normal text-gray-600"></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" id="submit-btn" class="w-full py-5 bg-[#1e2a78] text-white rounded-2xl font-bold text-sm shadow-xl shadow-blue-900/20 hover:bg-[#151d54] transition flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Konfirmasi & Terbitkan E-Tiket
                    </button>
                </form>
                <p class="text-center text-[10px] text-gray-400 mt-4 leading-relaxed">
                    Tiket Anda akan langsung terbit setelah konfirmasi. Tidak perlu menunggu verifikasi admin.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard() {
        const code = document.getElementById('payment-code').innerText;
        navigator.clipboard.writeText(code).then(() => {
            const btn = event.target.closest('button');
            btn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Disalin!`;
            setTimeout(() => { btn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg> Salin`; }, 2000);
        }).catch(() => {
            prompt('Salin kode ini:', code);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Preview upload
        const proofInput = document.getElementById('payment_proof_input');
        if (proofInput) {
            proofInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran file terlalu besar! Maksimal 2MB.');
                        this.value = '';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        document.getElementById('upload-placeholder').classList.add('hidden');
                        document.getElementById('upload-preview').src = event.target.result;
                        document.getElementById('file-name').innerText = file.name;
                        document.getElementById('upload-preview-container').classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        // Submit with loading state
        const form = document.getElementById('payment-confirm-form');
        const submitBtn = document.getElementById('submit-btn');
        if (form && submitBtn) {
            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg> Memproses...`;
            });
        }

        // Countdown timer (60 menit dari created_at)
        const expiryTime = {{ $booking->created_at->addMinutes(60)->timestamp * 1000 }};
        const timerEl = document.getElementById('countdown-timer');

        function updateTimer() {
            const now = Date.now();
            const diff = expiryTime - now;

            if (diff <= 0) {
                timerEl.innerText = "00:00";
                clearInterval(interval);
                timerEl.closest('.bg-red-50').innerHTML = '<p class="text-xs font-bold text-red-500 text-center">⚠️ Waktu habis — hubungi admin jika sudah bayar</p>';
                return;
            }

            const minutes = Math.floor(diff / 60000);
            const seconds = Math.floor((diff % 60000) / 1000);
            timerEl.innerText = `${String(minutes).padStart(2,'0')}:${String(seconds).padStart(2,'0')}`;
        }

        updateTimer();
        const interval = setInterval(updateTimer, 1000);
    });
</script>

@endsection
