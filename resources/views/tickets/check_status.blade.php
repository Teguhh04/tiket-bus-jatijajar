@extends('layouts.app')

@section('content')

<!-- Navbar -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-100 h-16">
    <div class="max-w-7xl mx-auto px-8 flex items-center justify-between h-full">
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}" class="p-2.5 hover:bg-gray-100 rounded-xl transition border border-gray-100 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
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

<div class="bg-[#f0f2f5] min-h-screen pt-24 pb-32 flex items-center justify-center">
    <div class="max-w-md w-full px-6">
        
        <!-- Branding Icon & Title -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-[#1e2a78] rounded-3xl mx-auto flex items-center justify-center shadow-lg shadow-blue-900/20 mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <h1 class="text-2xl font-bold text-[#1e2a78]">Cek Status Pemesanan</h1>
            <p class="text-xs text-gray-500 mt-2">Masukkan kode tiket & nomor WhatsApp untuk memantau status pembayaran atau mengunduh E-Tiket.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-3xl shadow-xl shadow-blue-900/5 p-8 border border-gray-100">
            <form id="ticketForm" action="{{ route('ticket.check_status') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Identifier (Kode Tiket / Nomor Handphone) -->
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Kode Tiket / Nomor HP</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" id="identifier" name="identifier" required placeholder="Masukkan Kode Booking atau No HP..." class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-[#1e2a78] outline-none text-sm transition text-gray-800 font-bold" value="{{ request('identifier', old('identifier')) }}">
                    </div>
                </div>
                
                <button type="submit" class="w-full py-4 bg-[#1e2a78] hover:bg-[#151d54] text-white rounded-2xl font-bold text-sm shadow-xl shadow-blue-900/20 transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Cek Status Tiket
                </button>
            </form>
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const identifier = document.getElementById('identifier');
                    if(identifier && identifier.value) {
                        // We do not auto-submit if it's just filled from old input, let user click submit.
                    }
                });
            </script>
        </div>

        <!-- Help Info -->
        <p class="text-center text-[10px] text-gray-400 mt-6">
            Lupa kode tiket? Periksa mutasi rekening, pesan WhatsApp masuk, atau hubungi <a href="{{ route('page.bantuan') }}" class="font-bold text-blue-600 hover:underline">Bantuan Customer Service</a>.
        </p>

    </div>
</div>

@endsection
