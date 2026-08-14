<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - JATIJAJAR Online Ticket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar-link.active {
            background: #1e2a78 !important;
            color: white !important;
            box-shadow: 0 10px 15px -3px rgba(30, 42, 120, 0.3);
        }
        .sidebar-link.active:hover {
            background: #151d54 !important;
        }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900">

    <div class="flex min-h-screen">
        <!-- Sidebar Backdrop for Mobile -->
        <div id="sidebar-backdrop" class="fixed inset-0 bg-slate-900/40 z-40 hidden lg:hidden transition-opacity duration-300"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-slate-200 flex flex-col h-screen transition-transform duration-300 -translate-x-full lg:translate-x-0 lg:sticky lg:top-0">
            <div class="p-8 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#1e2a78] rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/20">
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.22.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-black tracking-tighter text-[#1e2a78]">Jatijajar</h1>
                        <p class="text-[9px] font-bold text-slate-400 tracking-widest uppercase">Tiket Online Admin</p>
                    </div>
                </div>
                <!-- Close sidebar button on mobile -->
                <button id="close-sidebar" class="lg:hidden p-2 text-slate-400 hover:bg-slate-50 rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-slate-500 font-semibold transition-all hover:bg-slate-50 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.bookings') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-slate-500 font-semibold transition-all hover:bg-slate-50 {{ request()->routeIs('admin.bookings') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    Pesanan Tiket
                </a>
                <a href="{{ route('admin.reports') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-slate-500 font-semibold transition-all hover:bg-slate-50 {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 2v-6m-8 9h10a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Laporan Keuangan
                </a>
                <a href="{{ route('admin.po_revenue') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-slate-500 font-semibold transition-all hover:bg-slate-50 {{ request()->routeIs('admin.po_revenue') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Pendapatan PO Bus
                </a>
                <a href="{{ route('admin.trips') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-slate-500 font-semibold transition-all hover:bg-slate-50 {{ request()->routeIs('admin.trips') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Jadwal Bus
                </a>
                <div class="pt-4 pb-1">
                    <p class="px-4 text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em]">Master Data</p>
                </div>
                <a href="{{ route('admin.operators') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-slate-500 font-semibold transition-all hover:bg-slate-50 {{ request()->routeIs('admin.operators') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Operator Bus
                </a>
                <a href="{{ route('admin.terminals') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-slate-500 font-semibold transition-all hover:bg-slate-50 {{ request()->routeIs('admin.terminals') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Terminal
                </a>
            </nav>

            <div class="p-4 mt-auto">
                <a href="{{ route('home') }}" class="flex items-center justify-center gap-3 px-4 py-3 rounded-xl text-red-500 font-bold bg-red-50 transition-all hover:bg-red-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar Ke Situs
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0">
            <!-- Header -->
            <header class="h-20 bg-white border-b border-slate-200 px-6 lg:px-8 flex items-center justify-between sticky top-0 z-40">
                <div class="flex items-center gap-3">
                    <!-- Hamburger Menu Button -->
                    <button id="hamburger-menu" class="lg:hidden p-2 text-slate-500 hover:bg-slate-50 rounded-xl transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h2 class="text-base lg:text-lg font-bold text-slate-800">@yield('title', 'Dashboard')</h2>
                </div>
                
                <div class="flex items-center gap-4 lg:gap-6">
                    <button class="relative p-2 text-slate-400 hover:bg-slate-50 rounded-xl transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                    <div class="h-8 w-[1px] bg-slate-200"></div>
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-slate-800">Admin Jatijajar</p>
                            <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Super Admin</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name=Admin+Jatijajar&background=f1f5f9&color=1e2a78" alt="Admin">
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-4 lg:p-8">
                @yield('admin_content')
            </div>
        </main>
    </div>

    <!-- Toggle sidebar script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const hamburger = document.getElementById('hamburger-menu');
            const closeBtn = document.getElementById('close-sidebar');

            function toggleSidebar() {
                sidebar.classList.toggle('-translate-x-full');
                backdrop.classList.toggle('hidden');
            }

            if(hamburger) hamburger.addEventListener('click', toggleSidebar);
            if(closeBtn) closeBtn.addEventListener('click', toggleSidebar);
            if(backdrop) backdrop.addEventListener('click', toggleSidebar);
        });
    </script>

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

    @stack('scripts')
</body>
</html>
