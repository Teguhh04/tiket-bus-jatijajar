<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Jatijajar Online Ticket - Pesan tiket bus perjalanan Anda dengan mudah, cepat, dan aman.">
    <title>@yield('title', config('app.name', 'JATIJAJAR')) | JATIJAJAR</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 pb-20 md:pb-0" style="font-family: 'Inter', sans-serif;">
    @include('layouts.navbar')

    @if(session('success') || session('error'))
    <div x-data="{ show: true }" 
         x-show="show" 
         class="fixed inset-0 z-[9999] flex items-center justify-center px-4"
         style="display: none;">
        
        <!-- Backdrop -->
        <div x-show="show" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm"
             @click="show = false"></div>

        <!-- Modal -->
        <div x-show="show" 
             x-init="setTimeout(() => show = false, 4000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative bg-white rounded-3xl shadow-2xl p-6 sm:p-8 max-w-sm w-full text-center flex flex-col items-center gap-4 z-10 border {{ session('success') ? 'border-green-100' : 'border-red-100' }}">
             
             @if(session('success'))
                 <div class="w-16 h-16 rounded-full bg-green-50 text-green-500 flex items-center justify-center shadow-inner">
                     <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                 </div>
                 <div>
                     <h4 class="font-bold text-slate-800 text-lg mb-1">Berhasil!</h4>
                     <p class="text-sm text-slate-500 leading-relaxed">{{ session('success') }}</p>
                 </div>
             @else
                 <div class="w-16 h-16 rounded-full bg-red-50 text-red-500 flex items-center justify-center shadow-inner">
                     <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                 </div>
                 <div>
                     <h4 class="font-bold text-slate-800 text-lg mb-1">Perhatian!</h4>
                     <p class="text-sm text-slate-500 leading-relaxed">{{ session('error') }}</p>
                 </div>
             @endif

             <button @click="show = false" class="mt-2 w-full py-2.5 px-4 bg-slate-50 hover:bg-slate-100 text-slate-600 font-bold rounded-xl transition text-sm">
                 Tutup
             </button>
        </div>
    </div>
    @endif

    @yield('content')

    <!-- Bottom Navigation Bar (Global Mobile Only) -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 h-16 z-50">
        <div class="max-w-7xl mx-auto px-8 h-full flex items-center justify-around">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-1 {{ Route::is('home') ? 'text-[#1e2a78]' : 'text-gray-400 hover:text-[#1e2a78]' }} transition">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                <span class="text-[10px] font-bold">Beranda</span>
            </a>
            <a href="{{ route('ticket.check_status_form') }}" class="flex flex-col items-center gap-1 {{ Route::is('ticket.check_status_form') ? 'text-[#1e2a78]' : 'text-gray-400 hover:text-[#1e2a78]' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                <span class="text-[10px] font-bold">Tiket Saya</span>
            </a>
            <a href="{{ route('page.bantuan') }}" class="flex flex-col items-center gap-1 {{ Route::is('page.bantuan') ? 'text-[#1e2a78]' : 'text-gray-400 hover:text-[#1e2a78]' }} transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-[10px] font-bold">Bantuan</span>
            </a>
            <a href="{{ route('page.akun') }}" class="flex flex-col items-center gap-1 {{ Route::is('page.akun') ? 'text-[#1e2a78]' : 'text-gray-400 hover:text-[#1e2a78]' }} transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span class="text-[10px] font-bold">Akun</span>
            </a>
        </div>
    </div>
</body>
</html>
