<!-- Navbar -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-100 h-16 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-8 flex items-center justify-between h-full">
        <!-- Left Section: Logo & Nav Links -->
        <div class="flex items-center gap-4">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-yellow-400 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform">
                    <svg width="24" height="24" class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.22.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-lg font-black tracking-tight text-[#1e2a78] block leading-none">Jatijajar</span>
                    <span class="text-[9px] tracking-[0.2em] font-bold text-slate-400 uppercase mt-1 block">TIKET ONLINE</span>
                </div>
            </a>
            
        </div>

        <!-- Right Section: Actions -->
        <div class="flex items-center gap-6">
            <!-- Cek Tiket -->
            <a href="{{ route('ticket.check_status_form') }}" class="flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-[#1e2a78] transition group">
                <div class="p-2 hover:bg-gray-50 rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <span class="hidden md:inline">Cek Tiket</span>
            </a>

            <!-- Bantuan -->
            <a href="{{ route('page.bantuan') }}" class="flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-[#1e2a78] transition group">
                <div class="p-2 hover:bg-gray-50 rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="hidden md:inline">Bantuan</span>
            </a>

            <!-- Menu Button -->
            <button class="p-2.5 hover:bg-gray-100 rounded-xl transition border border-gray-100 text-gray-400 hover:text-[#1e2a78] group">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>
</nav>
