@extends('layouts.app')

@section('content')

<div class="bg-[#f0f2f5] min-h-screen pt-20 pb-32">
    <div class="max-w-3xl mx-auto px-4 sm:px-8">
        
        <!-- Header -->
        <h1 class="text-2xl sm:text-3xl font-bold text-[#1e2a78] mb-6 sm:mb-8">Akun Saya</h1>

        <!-- Profile Card -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 flex flex-col sm:flex-row items-center text-center sm:text-left gap-6 mb-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-full -z-10"></div>
            
            <div class="w-20 h-20 bg-gray-200 rounded-full overflow-hidden border-4 border-white shadow-md flex-shrink-0">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1e2a78&color=fff&size=150" alt="Profile" class="w-full h-full object-cover">
            </div>
            <div class="flex-1">
                <h2 class="text-xl font-bold text-gray-900">{{ Auth::user()->name }}</h2>
                <p class="text-gray-500 text-sm mt-1">{{ Auth::user()->email }}</p>
                <p class="text-gray-500 text-sm">Member sejak {{ Auth::user()->created_at->format('M Y') }}</p>
            </div>
            <button class="w-full sm:w-auto px-5 py-2.5 bg-blue-50 text-[#1e2a78] font-bold rounded-xl text-sm hover:bg-blue-100 transition">
                Edit Profil
            </button>
        </div>

        <!-- Menu List -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="p-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-400 text-xs uppercase tracking-widest ml-2 mb-1 mt-2">Aktivitas</h3>
            </div>
            
            <a href="#ticket-history-section" class="flex items-center gap-4 p-5 hover:bg-gray-50 transition border-b border-gray-100">
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-gray-800 text-sm sm:text-base">Riwayat Pesanan</p>
                    <p class="text-xs text-gray-500">Lihat semua tiket yang pernah dibeli</p>
                </div>
                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>

            <a href="#" class="flex items-center gap-4 p-5 hover:bg-gray-50 transition border-b border-gray-100">
                <div class="w-10 h-10 bg-green-50 text-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-gray-800 text-sm sm:text-base">Metode Pembayaran</p>
                    <p class="text-xs text-gray-500">Kelola kartu dan akun E-Wallet tersimpan</p>
                </div>
                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            
            <a href="#" class="flex items-center gap-4 p-5 hover:bg-gray-50 transition border-b border-gray-100">
                <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-gray-800 text-sm sm:text-base">Daftar Penumpang Tersimpan</p>
                    <p class="text-xs text-gray-500">Pesan tiket lebih cepat dengan data tersimpan</p>
                </div>
                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>

            <div class="p-4 border-b border-gray-100 mt-2">
                <h3 class="font-bold text-gray-400 text-xs uppercase tracking-widest ml-2 mb-1">Pengaturan</h3>
            </div>

            <a href="#" class="flex items-center gap-4 p-5 hover:bg-gray-50 transition border-b border-gray-100">
                <div class="w-10 h-10 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-gray-800 text-sm sm:text-base">Keamanan Akun</p>
                </div>
                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>

            <a href="#" class="flex items-center gap-4 p-5 hover:bg-gray-50 transition border-b border-gray-100">
                <div class="w-10 h-10 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-gray-800 text-sm sm:text-base">Pengaturan Aplikasi</p>
                </div>
                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>

            <!-- Logout -->
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center gap-4 p-5 hover:bg-red-50 transition text-left group">
                    <div class="w-10 h-10 bg-red-50 text-red-600 rounded-full flex items-center justify-center group-hover:bg-red-100 transition flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-red-600 text-sm sm:text-base">Keluar</p>
                    </div>
                </button>
            </form>
        </div>

        <!-- Ticket History Section -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-8" id="ticket-history-section">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <h3 class="font-bold text-gray-800 text-base">Riwayat Pemesanan Saya</h3>
                <span class="text-[10px] bg-blue-50 text-blue-600 px-3 py-1 rounded-full font-bold uppercase tracking-wider">{{ $bookings->count() }} Tiket</span>
            </div>

            @if($bookings->isEmpty())
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-blue-50 text-[#1e2a78] rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-[#1e2a78]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h4 class="font-bold text-gray-700 text-sm mb-1">Belum Ada Riwayat Pemesanan</h4>
                <p class="text-xs text-gray-400 mb-6 max-w-sm mx-auto">Anda belum pernah melakukan pemesanan tiket. Mulai cari jadwal bus untuk memesan tiket perjalanan Anda sekarang!</p>
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-3 bg-[#f5a623] hover:bg-[#e6991a] text-white rounded-xl font-bold text-xs shadow-md transition gap-2">
                    Cari Tiket Bus
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
            @else
            <div class="divide-y divide-gray-50">
                @foreach($bookings as $booking)
                <div class="p-4 sm:p-6 hover:bg-slate-50/50 transition">
                    <div class="flex justify-between items-start gap-4 mb-4">
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center shadow-sm border border-gray-100 overflow-hidden bg-white p-1 flex-shrink-0">
                                <img src="{{ asset($booking->trip->operator->logo_url ?? '') }}" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($booking->trip->operator->name) }}&background=random&color=fff&size=128&bold=true&format=svg';" alt="{{ $booking->trip->operator->name }}" class="w-full h-full object-contain">
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-xs sm:text-sm">{{ $booking->trip->operator->name }} ({{ $booking->trip->bus_class }})</h4>
                                <p class="text-[10px] text-slate-400 font-semibold mt-0.5 uppercase tracking-wider">KODE: <span class="text-[#1e2a78] font-extrabold">{{ $booking->ticket_code }}</span></p>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div class="flex-shrink-0">
                            @if($booking->status == 'lunas')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-50 text-green-600 rounded-full text-[9px] font-bold uppercase tracking-wider">
                                    <span class="w-1 h-1 bg-green-500 rounded-full"></span>
                                    LUNAS
                                </span>
                            @elseif($booking->status == 'menunggu_verifikasi')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-50 text-blue-600 rounded-full text-[9px] font-bold uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></span>
                                    VERIFIKASI
                                </span>
                            @elseif($booking->status == 'pending')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-orange-50 text-orange-600 rounded-full text-[9px] font-bold uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 bg-orange-500 rounded-full animate-pulse"></span>
                                    PENDING
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-50 text-red-600 rounded-full text-[9px] font-bold uppercase tracking-wider">
                                    <span class="w-1 h-1 bg-red-500 rounded-full"></span>
                                    BATAL
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Details grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-gray-50 border border-gray-100 rounded-2xl p-4 text-xs">
                        <div>
                            <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest block">Rute</span>
                            <span class="font-bold text-gray-700 mt-1 block truncate">{{ $booking->trip->origin->city }} &rarr; {{ $booking->trip->destination->city }}</span>
                        </div>
                        <div>
                            <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest block">Keberangkatan</span>
                            <span class="font-bold text-gray-700 mt-1 block">{{ \Carbon\Carbon::parse($booking->trip->departure_time)->translatedFormat('d M Y (H:i)') }}</span>
                        </div>
                        <div>
                            <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest block">Kursi</span>
                            <span class="font-bold text-[#1e2a78] mt-1 block font-mono truncate">{{ $booking->passengers->pluck('seat_number')->implode(', ') }}</span>
                        </div>
                        <div>
                            <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest block">Total Bayar</span>
                            <span class="font-extrabold text-[#f5a623] mt-1 block">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div class="flex flex-col sm:flex-row justify-end gap-3 mt-4">
                        @if($booking->status == 'pending')
                            <a href="{{ route('ticket.payment', $booking->ticket_code) }}" class="w-full sm:w-auto text-center px-4 py-2 bg-[#f5a623] hover:bg-[#e6991a] text-white font-bold rounded-lg text-[10px] uppercase tracking-wider transition shadow-sm">
                                Bayar Sekarang
                            </a>
                        @elseif($booking->status == 'menunggu_verifikasi')
                            <a href="{{ route('ticket.success', $booking->ticket_code) }}" class="w-full sm:w-auto text-center px-4 py-2 bg-blue-50 text-blue-600 font-bold rounded-lg text-[10px] uppercase tracking-wider hover:bg-blue-100 transition">
                                Cek Pembayaran
                            </a>
                        @elseif($booking->status == 'lunas')
                            <a href="{{ route('ticket.success', $booking->ticket_code) }}" class="w-full sm:w-auto text-center px-4 py-2 bg-blue-50 text-blue-600 font-bold rounded-lg text-[10px] uppercase tracking-wider hover:bg-blue-100 transition">
                                Lihat Tiket
                            </a>
                            <a href="{{ route('ticket.print', $booking->ticket_code) }}" target="_blank" class="w-full sm:w-auto text-center px-4 py-2 bg-[#1e2a78] hover:bg-[#151d54] text-white font-bold rounded-lg text-[10px] uppercase tracking-wider transition shadow-sm flex items-center justify-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-3a2 2 0 00-2-2H9a2 2 0 00-2 2v3a2 2 0 002 2zm5-12V5a3 3 0 00-3-3H9a3 3 0 00-3 3v4h10z"/></svg>
                                Cetak PDF
                            </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

    </div>
</div>

@endsection
