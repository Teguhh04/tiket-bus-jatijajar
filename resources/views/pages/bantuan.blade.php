@extends('layouts.app')

@section('content')

<div class="bg-[#f0f2f5] min-h-screen pt-20 sm:pt-24 pb-20 sm:pb-32">
    <div class="max-w-4xl mx-auto px-4 sm:px-8">
        
        <!-- Header -->
        <div class="text-center mb-8 sm:mb-10 mt-8 sm:mt-0">
            <h1 class="text-2xl sm:text-3xl font-bold text-[#1e2a78] mb-2 sm:mb-3">Pusat Bantuan</h1>
            <p class="text-sm sm:text-base text-gray-500 px-4">Temukan jawaban atas pertanyaan Anda atau hubungi tim kami.</p>
        </div>

        <!-- Search Bantuan -->
        <div class="relative max-w-xl mx-auto mb-10 sm:mb-12">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" class="w-full bg-white border border-gray-200 rounded-2xl py-3.5 sm:py-4 pl-12 pr-4 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm" placeholder="Ketik topik bantuan...">
        </div>

        <!-- Kategori Bantuan -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 mb-10 sm:mb-12">
            <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-md cursor-pointer transition group">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-2.5 sm:mb-3 group-hover:scale-110 transition">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                </div>
                <h3 class="font-bold text-gray-800 text-xs sm:text-sm">Pesanan Tiket</h3>
            </div>
            <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-md cursor-pointer transition group">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-50 text-green-600 rounded-full flex items-center justify-center mx-auto mb-2.5 sm:mb-3 group-hover:scale-110 transition">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <h3 class="font-bold text-gray-800 text-xs sm:text-sm">Pembayaran</h3>
            </div>
            <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-md cursor-pointer transition group">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center mx-auto mb-2.5 sm:mb-3 group-hover:scale-110 transition">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
                <h3 class="font-bold text-gray-800 text-xs sm:text-sm">Refund & Reschedule</h3>
            </div>
            <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-md cursor-pointer transition group">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-2.5 sm:mb-3 group-hover:scale-110 transition">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h3 class="font-bold text-gray-800 text-xs sm:text-sm">Akun Saya</h3>
            </div>
        </div>

        <!-- FAQ Section -->
        <h2 class="text-xl font-bold text-gray-900 mb-6">Pertanyaan Populer</h2>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-12">
            <!-- Item 1 -->
            <div class="border-b border-gray-100 p-6 hover:bg-gray-50 transition cursor-pointer">
                <h4 class="font-bold text-gray-800 mb-2 flex items-center justify-between">
                    Bagaimana cara cetak E-Tiket?
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </h4>
                <p class="text-sm text-gray-500">Anda tidak perlu mencetak E-Tiket. Cukup tunjukkan E-Tiket beserta QR Code yang ada di aplikasi atau website kepada petugas saat boarding.</p>
            </div>
            <!-- Item 2 -->
            <div class="border-b border-gray-100 p-6 hover:bg-gray-50 transition cursor-pointer">
                <h4 class="font-bold text-gray-800 mb-2 flex items-center justify-between">
                    Apakah saya bisa membatalkan tiket?
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </h4>
            </div>
            <!-- Item 3 -->
            <div class="p-6 hover:bg-gray-50 transition cursor-pointer">
                <h4 class="font-bold text-gray-800 mb-2 flex items-center justify-between">
                    Di mana titik naik untuk Terminal <b>JATIJAJAR</b>?
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </h4>
            </div>
        </div>

        <!-- Contact Support -->
        <div class="bg-[#1e2a78] rounded-3xl p-6 sm:p-8 text-center text-white relative overflow-hidden shadow-2xl shadow-blue-900/20">
            <div class="absolute inset-0 opacity-10">
                <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="2" cy="2" r="2" fill="currentColor"/></pattern></defs><rect width="100%" height="100%" fill="url(#dots)"/></svg>
            </div>
            <div class="relative z-10">
                <h2 class="text-xl sm:text-2xl font-bold mb-2 sm:mb-3">Masih Butuh Bantuan?</h2>
                <p class="text-xs sm:text-sm text-blue-200 mb-6 max-w-md mx-auto px-2">Tim layanan pelanggan kami siap membantu Anda 24/7 melalui Live Chat atau WhatsApp.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-3 sm:gap-4">
                    <button class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white font-bold py-3.5 sm:py-3 px-6 rounded-xl flex items-center justify-center gap-2 transition text-sm sm:text-base">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.573-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.618-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824z"/></svg>
                        Hubungi via WhatsApp
                    </button>
                    <button class="w-full sm:w-auto bg-white hover:bg-gray-50 text-[#1e2a78] font-bold py-3.5 sm:py-3 px-6 rounded-xl flex items-center justify-center gap-2 transition text-sm sm:text-base">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        Live Chat
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
