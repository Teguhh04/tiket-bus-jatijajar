@extends('layouts.app')

@section('content')
<!-- Hero -->
<section class="hero-section pt-16">
    <!-- Terminal Building Image -->
    <div class="hidden md:block absolute top-0 right-0 bottom-0 w-[55%] overflow-hidden">
        <img src="{{ asset('images/terminal-building.jpg') }}" alt="Terminal Tipe A Jatijajar Kota Depok" class="w-full h-full object-cover opacity-85">
        <div class="absolute inset-0" style="background: linear-gradient(to right, #1e2a78 0%, transparent 50%);"></div>
    </div>
    <div class="max-w-7xl mx-auto px-8 py-20 relative z-10">
        <p class="text-yellow-400 text-xs sm:text-sm font-bold tracking-widest mb-3 sm:mb-4 uppercase">Jatijajar Tiket Online</p>
        <h1 class="text-white text-3xl sm:text-4xl md:text-5xl font-bold leading-tight mb-4 sm:mb-5 max-w-xl">Menghubungkan Perjalanan,<br>Mendekatkan Tujuan</h1>
        <p class="text-blue-200 text-sm sm:text-lg mb-8 sm:mb-10 max-w-md">Pesan tiket perjalanan Anda dengan mudah, cepat, dan aman.</p>
        <div class="flex gap-4 mb-8">
            <div class="hero-badge flex items-center gap-3">
                <svg class="w-8 h-8 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <div><span class="font-bold text-white text-sm">Aman & Terpercaya</span><br><span class="text-blue-300 text-xs">Sistem terjamin</span></div>
            </div>
            <div class="hero-badge flex items-center gap-3">
                <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.381z" clip-rule="evenodd"/></svg>
                <div><span class="font-bold text-white text-sm">Cepat & Mudah</span><br><span class="text-blue-300 text-xs">Pesan dalam hitungan detik</span></div>
            </div>
        </div>
        <div class="flex gap-2"><span class="dot active"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span></div>
    </div>
</section>

<!-- Apple-style Search Bar -->
<div class="max-w-5xl mx-auto px-4 sm:px-8 relative z-20 -mt-12" x-data="{ isDepokOrigin: true, selectedCity: '', showError: false }">
    <div class="bg-white/90 backdrop-blur-2xl rounded-[2rem] md:rounded-full shadow-[0_12px_40px_-10px_rgba(30,42,120,0.15)] p-3 md:p-2.5 border border-white/60">
        
        <form action="{{ route('ticket.search') }}" method="GET" class="flex flex-col md:flex-row items-center w-full relative gap-2 md:gap-0" @submit="if(!selectedCity) { showError = true; $event.preventDefault(); }">
            
            <!-- Hidden inputs to submit the correct origin/destination -->
            <input type="hidden" name="origin" :value="isDepokOrigin ? 'Depok' : selectedCity">
            <input type="hidden" name="destination" :value="isDepokOrigin ? selectedCity : 'Depok'">

            <!-- Origin & Destination Container -->
            <div class="flex-1 flex flex-col md:flex-row items-center w-full relative bg-gray-50 md:bg-transparent rounded-2xl md:rounded-none">
                <!-- Origin Container (Left) -->
                <label class="flex-1 w-full flex items-center pl-6 md:pl-8 pr-6 md:pr-10 py-4 md:py-3 hover:bg-gray-100/50 rounded-t-2xl md:rounded-l-full md:rounded-tr-none transition group cursor-pointer relative" :class="{ 'bg-red-50 hover:bg-red-50': showError && !isDepokOrigin && !selectedCity }" onclick="if(!document.getElementById('originSelect').offsetParent) { /* Locked state */ } else { document.getElementById('originSelect').focus(); }">
                    <div class="w-full relative">
                        <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 group-hover:text-[#1e2a78] transition" :class="{ 'text-red-500 group-hover:text-red-600': showError && !isDepokOrigin && !selectedCity }">Berangkat Dari</span>
                        
                        <!-- Shown if Depok is Origin -->
                        <div x-show="isDepokOrigin" class="text-sm md:text-base font-bold text-gray-900 truncate flex items-center justify-between">
                            <span>Terminal Jatijajar, Depok</span>
                            <svg class="w-4 h-4 text-gray-300 md:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>

                        <!-- Shown if Depok is Destination (User selects Origin) -->
                        <select id="originSelect" x-show="!isDepokOrigin" x-model="selectedCity" @change="showError = false" :required="!isDepokOrigin" class="w-full bg-transparent border-0 p-0 text-sm md:text-base font-bold focus:ring-0 outline-none cursor-pointer" :class="showError && !isDepokOrigin && !selectedCity ? 'text-red-600' : 'text-gray-900'" style="display: none;">
                            <option value="" disabled selected>Pilih Kota Asal</option>
                            <option value="Blitar">Blitar</option>
                            <option value="Jepara">Jepara</option>
                            <option value="Karanganyar">Karanganyar</option>
                            <option value="Kediri">Kediri</option>
                            <option value="Klaten">Klaten</option>
                            <option value="Kudus">Kudus</option>
                            <option value="Madiun">Madiun</option>
                            <option value="Madura">Madura</option>
                            <option value="Magetan">Magetan</option>
                            <option value="Malang">Malang</option>
                            <option value="Ngawi">Ngawi</option>
                            <option value="Pati">Pati</option>
                            <option value="Pekalongan">Pekalongan</option>
                            <option value="Ponorogo">Ponorogo</option>
                            <option value="Purwokerto">Purwokerto</option>
                            <option value="Semarang">Semarang</option>
                            <option value="Solo">Solo</option>
                            <option value="Surabaya">Surabaya</option>
                            <option value="Tegal">Tegal</option>
                            <option value="Tulungagung">Tulungagung</option>
                            <option value="Wonogiri">Wonogiri</option>
                            <option value="Yogyakarta">Yogyakarta</option>
                        </select>
                    </div>
                </label>

                <!-- Divider (visible on mobile horizontally, on md vertically) -->
                <div class="block md:hidden w-full h-[1px] bg-gray-200/80 mx-4"></div>
                <div class="hidden md:block absolute left-1/2 top-2 bottom-2 w-[1px] bg-gray-200/80 -translate-x-1/2 z-0"></div>

                <!-- Swap Button -->
                <button type="button" @click="isDepokOrigin = !isDepokOrigin; showError = false;" class="absolute z-20 left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-10 h-10 bg-[#1e2a78] border-2 border-white rounded-full flex items-center justify-center hover:bg-[#151d5a] transition shadow-md hover:scale-110 active:scale-95 text-white cursor-pointer">
                    <svg class="w-5 h-5 md:rotate-0 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4M4 17l4 4m-4-4l4-4"/></svg>
                </button>

                <!-- Destination Container (Right) -->
                <label class="flex-1 w-full flex items-center pl-6 md:pl-10 pr-6 md:pr-4 py-4 md:py-3 hover:bg-gray-100/50 rounded-b-2xl md:rounded-r-full md:rounded-bl-none transition group cursor-pointer relative" :class="{ 'bg-red-50 hover:bg-red-50': showError && isDepokOrigin && !selectedCity }" onclick="if(!document.getElementById('destSelect').offsetParent) { /* Locked state */ } else { document.getElementById('destSelect').focus(); }">
                    <div class="w-full relative">
                        <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 group-hover:text-[#1e2a78] transition" :class="{ 'text-red-500 group-hover:text-red-600': showError && isDepokOrigin && !selectedCity }">Tujuan Ke</span>
                        
                        <!-- Shown if Depok is Destination -->
                        <div x-show="!isDepokOrigin" class="text-sm md:text-base font-bold text-gray-900 truncate flex items-center justify-between" style="display: none;">
                            <span>Terminal Jatijajar, Depok</span>
                            <svg class="w-4 h-4 text-gray-300 md:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>

                        <!-- Shown if Depok is Origin (User selects Destination) -->
                        <select id="destSelect" x-show="isDepokOrigin" x-model="selectedCity" @change="showError = false" :required="isDepokOrigin" class="w-full bg-transparent border-0 p-0 text-sm md:text-base font-bold focus:ring-0 outline-none cursor-pointer" :class="showError && isDepokOrigin && !selectedCity ? 'text-red-600' : 'text-gray-900'">
                            <option value="" disabled selected>Pilih Kota Tujuan</option>
                            <option value="Blitar">Blitar</option>
                            <option value="Jepara">Jepara</option>
                            <option value="Karanganyar">Karanganyar</option>
                            <option value="Kediri">Kediri</option>
                            <option value="Klaten">Klaten</option>
                            <option value="Kudus">Kudus</option>
                            <option value="Madiun">Madiun</option>
                            <option value="Madura">Madura</option>
                            <option value="Magetan">Magetan</option>
                            <option value="Malang">Malang</option>
                            <option value="Ngawi">Ngawi</option>
                            <option value="Pati">Pati</option>
                            <option value="Pekalongan">Pekalongan</option>
                            <option value="Ponorogo">Ponorogo</option>
                            <option value="Purwokerto">Purwokerto</option>
                            <option value="Semarang">Semarang</option>
                            <option value="Solo">Solo</option>
                            <option value="Surabaya">Surabaya</option>
                            <option value="Tegal">Tegal</option>
                            <option value="Tulungagung">Tulungagung</option>
                            <option value="Wonogiri">Wonogiri</option>
                            <option value="Yogyakarta">Yogyakarta</option>
                        </select>
                    </div>
                </label>
            </div>

            <!-- Divider -->
            <div class="hidden md:block w-[1px] h-12 bg-gray-200/80 mx-2"></div>

            <!-- Departure Date -->
            <div class="w-full md:w-56 flex items-center pl-6 md:pl-8 pr-6 md:pr-4 py-4 md:py-3 hover:bg-gray-100/50 rounded-2xl md:rounded-full transition group cursor-pointer bg-gray-50 md:bg-transparent">
                <div class="w-full">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 group-hover:text-[#1e2a78] transition">Tanggal Pergi</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required class="w-full bg-transparent border-0 p-0 text-sm md:text-base font-bold text-gray-900 focus:ring-0 outline-none cursor-pointer">
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full md:w-16 h-14 md:h-16 mt-2 md:mt-0 md:ml-2 bg-[#1e2a78] hover:bg-[#151d5a] rounded-2xl md:rounded-full flex items-center justify-center text-white transition flex-shrink-0 shadow-[0_8px_20px_-6px_rgba(30,42,120,0.5)] hover:scale-105 active:scale-95 gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span class="md:hidden font-bold">Cari Tiket</span>
            </button>
            
        </form>
    </div>
</div>

<!-- Informasi Terminal -->
<section class="max-w-7xl mx-auto px-8 py-20">
    <p class="text-center text-[#1e2a78] text-sm font-bold tracking-widest mb-2 uppercase">Informasi Terkini</p>
    <h2 class="text-center text-3xl font-bold text-gray-800 mb-12">Pengumuman Terminal Jatijajar</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="feature-card overflow-hidden !p-0 group cursor-pointer hover:shadow-lg transition">
            <div class="h-40 w-full overflow-hidden">
                <img src="{{ asset('images/terminal_official_counter.png') }}" alt="Waspada Calo Tiket" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
            </div>
            <div class="p-5">
                <h3 class="font-bold text-gray-800 mb-2">Waspada Calo Tiket</h3>
                <p class="text-sm text-gray-500 line-clamp-3">Demi keamanan, belilah tiket hanya melalui loket resmi atau platform online terpercaya. Jangan menerima tawaran tiket dari calo.</p>
            </div>
        </div>
        <div class="feature-card overflow-hidden !p-0 group cursor-pointer hover:shadow-lg transition">
            <div class="h-40 w-full overflow-hidden">
                <img src="{{ asset('images/terminal_operating_hours.png') }}" alt="Jam Operasional" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
            </div>
            <div class="p-5">
                <h3 class="font-bold text-gray-800 mb-2">Jam Operasional</h3>
                <p class="text-sm text-gray-500 line-clamp-3">Terminal beroperasi 24 jam. Namun, layanan loket administrasi buka setiap hari mulai pukul 05:00 hingga 22:00 WIB.</p>
            </div>
        </div>
        <div class="feature-card overflow-hidden !p-0 group cursor-pointer hover:shadow-lg transition">
            <div class="h-40 w-full overflow-hidden">
                <img src="{{ asset('images/terminal_protocols.png') }}" alt="Patuhi Protokol" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
            </div>
            <div class="p-5">
                <h3 class="font-bold text-gray-800 mb-2">Patuhi Protokol</h3>
                <p class="text-sm text-gray-500 line-clamp-3">Seluruh penumpang diwajibkan menjaga ketertiban, kebersihan, dan mematuhi peraturan yang berlaku di lingkungan terminal.</p>
            </div>
        </div>
        <div class="feature-card overflow-hidden !p-0 group cursor-pointer hover:shadow-lg transition">
            <div class="h-40 w-full overflow-hidden">
                <img src="{{ asset('images/terminal_customer_service.png') }}" alt="Layanan Pengaduan" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
            </div>
            <div class="p-5">
                <h3 class="font-bold text-gray-800 mb-2">Layanan Pengaduan</h3>
                <p class="text-sm text-gray-500 line-clamp-3">Jika mengalami kendala atau melihat hal mencurigakan, segera lapor ke Pos Keamanan terdekat atau hubungi pusat bantuan.</p>
            </div>
        </div>
    </div>
</section>

<!-- Cara Kerja -->
<section class="max-w-7xl mx-auto px-8 pb-20">
    <p class="text-center text-[#1e2a78] text-sm font-bold tracking-widest mb-2">CARA KERJA</p>
    <h2 class="text-center text-3xl font-bold text-gray-800 mb-14">Mudah dalam 3 Langkah</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="step-card pt-8">
            <span class="step-number">1</span>
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 mb-1">Pilih Perjalanan</h3>
                    <p class="text-sm text-gray-500">Pilih tanggal, tujuan, dan waktu perjalanan Anda.</p>
                </div>
            </div>
        </div>
        <div class="step-card pt-8">
            <span class="step-number">2</span>
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 mb-1">Pilih Kursi</h3>
                    <p class="text-sm text-gray-500">Pilih kursi terbaik yang tersedia sesuai keinginan Anda.</p>
                </div>
            </div>
        </div>
        <div class="step-card pt-8">
            <span class="step-number">3</span>
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 mb-1">Pesan & Bayar</h3>
                    <p class="text-sm text-gray-500">Lengkapi data dan lakukan pembayaran dengan aman.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Banner -->
<section class="max-w-7xl mx-auto px-4 sm:px-8 pb-12 sm:pb-20">
    <div class="bg-[#1e2a78] rounded-[2rem] p-6 sm:p-10 flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left relative overflow-hidden shadow-2xl shadow-blue-900/20">
        <div class="absolute inset-0 opacity-10">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="2" cy="2" r="2" fill="currentColor"/></pattern></defs><rect width="100%" height="100%" fill="url(#dots)"/></svg>
        </div>
        <div class="relative z-10">
            <h3 class="text-white text-xl sm:text-2xl font-bold mb-2">Siap untuk perjalanan Anda?</h3>
            <p class="text-blue-200 text-xs sm:text-sm max-w-md mx-auto md:mx-0">Pesan tiket sekarang dan nikmati perjalanan yang nyaman bersama <b>Jatijajar</b> Online Ticket.</p>
        </div>
        <a href="#" class="relative z-10 w-full md:w-auto justify-center bg-white text-[#1e2a78] font-bold px-6 sm:px-8 py-3.5 rounded-xl text-xs sm:text-sm hover:bg-gray-100 transition flex items-center gap-2 flex-shrink-0">
            Mulai Pesan Sekarang
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
</section>

<!-- Footer -->
<footer class="bg-[#151d5a] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 py-8 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
        <div class="flex items-center gap-3">
            <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.22.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
            <div class="text-left"><span class="font-black tracking-wide">Jatijajar</span><br><span class="text-[10px] tracking-widest opacity-60 uppercase font-bold">Tiket Online</span></div>
        </div>
        <p class="text-xs sm:text-sm text-blue-300">&copy; 2026 <b>Jatijajar</b> Online Ticket. All rights reserved.</p>
        <div class="flex gap-4">
            <a href="#" class="w-9 h-9 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            <a href="#" class="w-9 h-9 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
            </a>
            <a href="#" class="w-9 h-9 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
            </a>
            <a href="#" class="w-9 h-9 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
            </a>
        </div>
    </div>
</footer>
@endsection
