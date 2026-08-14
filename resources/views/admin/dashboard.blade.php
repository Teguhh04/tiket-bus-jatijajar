@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('admin_content')
<div class="space-y-8">
    
    <!-- Unified Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1: Revenue -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-5">
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Pendapatan Bulan Ini</p>
                <h3 class="text-xl font-bold text-slate-800">Rp {{ number_format($stats['revenue_month'], 0, ',', '.') }}</h3>
                <p class="text-[10px] text-slate-400 mt-0.5">Hari ini: Rp {{ number_format($stats['revenue_today'], 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Card 2: Bookings -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-5">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Total Pesanan</p>
                <h3 class="text-xl font-bold text-slate-800">{{ number_format($stats['total_bookings']) }}</h3>
                <p class="text-[10px] text-slate-400 mt-0.5">Minggu ini: {{ $stats['bookings_week'] }} transaksi</p>
            </div>
        </div>

        <!-- Card 3: Passengers -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-5">
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Total Penumpang</p>
                <h3 class="text-xl font-bold text-slate-800">{{ number_format($stats['total_passengers']) }}</h3>
                <p class="text-[10px] text-slate-400 mt-0.5">Seluruh perjalanan</p>
            </div>
        </div>

        <!-- Card 4: Trips -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-5">
            <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Jadwal Bus Aktif</p>
                <h3 class="text-xl font-bold text-slate-800">{{ number_format($stats['active_trips']) }}</h3>
                <p class="text-[10px] text-slate-400 mt-0.5">Jadwal bus saat ini</p>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="font-bold text-slate-800 text-lg">Visualisasi Pendapatan</h3>
                <p class="text-xs text-slate-400 mt-1">Tren pendapatan dalam 7 hari terakhir</p>
            </div>
            <div class="flex gap-2">
                <span class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-bold">LIVE UPDATE</span>
            </div>
        </div>
        <div class="h-64 relative">
            @if(empty($chartData) || array_sum($chartData) == 0)
            <div class="absolute inset-0 flex flex-col items-center justify-center bg-white/80 z-10">
                <svg class="w-12 h-12 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <p class="text-sm text-slate-500 font-bold">Belum ada transaksi</p>
                <p class="text-[10px] text-slate-400">Data pendapatan akan muncul di sini</p>
            </div>
            @endif
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- ===== TREND ANALYTICS SECTION ===== -->
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="font-bold text-slate-800 text-lg">Tren & Analitik</h3>
                <p class="text-xs text-slate-400 mt-1">
                    Tujuan terpopuler & operator dalam 
                    @if($trendPeriod == '1bulan') 1 bulan @elseif($trendPeriod == '6bulan') 6 bulan @else 1 tahun @endif terakhir
                </p>
            </div>
            <!-- Period Filter Tabs -->
            <div class="flex bg-slate-100 rounded-2xl p-1 gap-1">
                <a href="{{ route('admin.dashboard', ['trend_period' => '1bulan']) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $trendPeriod == '1bulan' ? 'bg-[#1e2a78] text-white shadow-lg' : 'text-slate-500 hover:bg-slate-200' }}">
                    1 Bulan
                </a>
                <a href="{{ route('admin.dashboard', ['trend_period' => '6bulan']) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $trendPeriod == '6bulan' ? 'bg-[#1e2a78] text-white shadow-lg' : 'text-slate-500 hover:bg-slate-200' }}">
                    6 Bulan
                </a>
                <a href="{{ route('admin.dashboard', ['trend_period' => '1tahun']) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $trendPeriod == '1tahun' ? 'bg-[#1e2a78] text-white shadow-lg' : 'text-slate-500 hover:bg-slate-200' }}">
                    1 Tahun
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Top Destinations -->
            <div>
                <h4 class="font-bold text-slate-700 text-sm mb-5 flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    Tujuan Terpopuler
                </h4>
                @if($topDestinations->isEmpty())
                    <div class="py-12 text-center bg-slate-50 rounded-2xl">
                        <p class="text-sm text-slate-400 font-medium">Belum ada data di periode ini</p>
                    </div>
                @else
                    <div class="space-y-3 mb-6">
                        @php $maxDest = $topDestinations->max('total_bookings') ?: 1; @endphp
                        @foreach($topDestinations as $i => $dest)
                        <div class="group">
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-lg flex items-center justify-center text-[10px] font-black {{ $i === 0 ? 'bg-yellow-100 text-yellow-700' : ($i === 1 ? 'bg-slate-100 text-slate-500' : 'bg-orange-50 text-orange-400') }}">{{ $i + 1 }}</span>
                                    <span class="text-sm font-bold text-slate-700">{{ $dest->city }}</span>
                                </div>
                                <span class="text-xs font-bold text-slate-500">{{ $dest->total_bookings }} pesanan · {{ $dest->total_pax }} pax</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-700 {{ $i === 0 ? 'bg-gradient-to-r from-blue-500 to-blue-700' : ($i === 1 ? 'bg-gradient-to-r from-purple-400 to-purple-600' : 'bg-gradient-to-r from-slate-300 to-slate-400') }}" 
                                     style="width: {{ round(($dest->total_bookings / $maxDest) * 100) }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                @endif
            </div>

            <!-- Top Operators -->
            <div>
                <h4 class="font-bold text-slate-700 text-sm mb-5 flex items-center gap-2">
                    <div class="w-8 h-8 bg-green-50 text-green-600 rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    Operator Terpopuler (PO Bus)
                </h4>
                @if($topOperators->isEmpty())
                    <div class="py-12 text-center bg-slate-50 rounded-2xl">
                        <p class="text-sm text-slate-400 font-medium">Belum ada data di periode ini</p>
                    </div>
                @else
                    <div class="space-y-3 mb-6">
                        @php $maxOp = $topOperators->max('total_bookings') ?: 1; @endphp
                        @foreach($topOperators as $i => $op)
                        <div class="group">
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-lg flex items-center justify-center text-[10px] font-black {{ $i === 0 ? 'bg-yellow-100 text-yellow-700' : ($i === 1 ? 'bg-slate-100 text-slate-500' : 'bg-orange-50 text-orange-400') }}">{{ $i + 1 }}</span>
                                    <span class="text-sm font-bold text-slate-700">{{ $op->name }}</span>
                                </div>
                                <span class="text-xs font-bold text-slate-500">{{ $op->total_bookings }} trip · Rp {{ number_format($op->total_revenue, 0, ',', '.') }}</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-700 {{ $i === 0 ? 'bg-gradient-to-r from-green-500 to-emerald-600' : ($i === 1 ? 'bg-gradient-to-r from-teal-400 to-teal-600' : 'bg-gradient-to-r from-slate-300 to-slate-400') }}" 
                                     style="width: {{ round(($op->total_bookings / $maxOp) * 100) }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Bookings Table -->
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800">Pesanan Terbaru</h3>
                <a href="{{ route('admin.bookings') }}" class="text-xs font-bold text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Customer</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Bus</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recentBookings as $booking)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                                        {{ substr($booking->passengers->first()->name ?? 'G', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">{{ $booking->passengers->first()->name ?? 'Guest' }}</p>
                                        <p class="text-[10px] text-slate-400">{{ $booking->ticket_code }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-sm font-semibold text-slate-700">{{ $booking->trip->operator->name }}</p>
                                <p class="text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($booking->trip->departure_time)->translatedFormat('d M Y') }}</p>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-sm font-bold text-slate-800">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-6 py-5">
                                @if($booking->status == 'lunas')
                                    <span class="px-3 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-bold uppercase tracking-wider">Lunas</span>
                                @elseif($booking->status == 'menunggu_verifikasi')
                                    <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-bold uppercase tracking-wider">Pending Verif</span>
                                @elseif($booking->status == 'pending')
                                    <span class="px-3 py-1 bg-orange-50 text-orange-600 rounded-full text-[10px] font-bold uppercase tracking-wider">Pending</span>
                                @else
                                    <span class="px-3 py-1 bg-red-50 text-red-600 rounded-full text-[10px] font-bold uppercase tracking-wider">Batal</span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    @if(in_array($booking->status, ['pending', 'menunggu_verifikasi']))
                                    <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="lunas">
                                        <button type="submit" class="p-2 text-green-500 hover:bg-green-50 rounded-lg transition" title="Verifikasi/Setujui">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="batal">
                                        <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" title="Batalkan">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </form>
                                    @endif
                                    <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="p-2 text-slate-400 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition inline-flex" title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-10 text-center text-slate-400 text-sm">Belum ada pesanan masuk</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- System Status or Quick Actions -->
        <div class="bg-[#1e2a78] rounded-[2.5rem] shadow-xl p-8 text-white">
            <h3 class="font-bold text-lg mb-6">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.trips.create') }}" class="w-full flex items-center justify-between p-5 bg-white/10 rounded-2xl hover:bg-white/20 transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <span class="font-bold text-sm">Tambah Jadwal Baru</span>
                    </div>
                    <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition transform translate-x-2 group-hover:translate-x-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('admin.trips') }}" class="w-full flex items-center justify-between p-5 bg-white/10 rounded-2xl hover:bg-white/20 transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-purple-500 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="font-bold text-sm">Jadwal Bus</span>
                    </div>
                    <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition transform translate-x-2 group-hover:translate-x-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('admin.reports') }}" class="w-full flex items-center justify-between p-5 bg-white/10 rounded-2xl hover:bg-white/20 transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 2v-6m-8 9h10a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="font-bold text-sm">Laporan Pendapatan</span>
                    </div>
                    <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition transform translate-x-2 group-hover:translate-x-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('admin.bookings') }}" class="w-full flex items-center justify-between p-5 bg-white/10 rounded-2xl hover:bg-white/20 transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-orange-400 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <span class="font-bold text-sm">Kelola Pesanan</span>
                    </div>
                    <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition transform translate-x-2 group-hover:translate-x-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <form action="{{ route('admin.trips.generate') }}" method="POST" onsubmit="return confirm('Generate jadwal 30 hari ke depan sekarang?')">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-between p-5 bg-yellow-400/20 rounded-2xl hover:bg-yellow-400/30 transition group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-yellow-400 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            </div>
                            <span class="font-bold text-sm">Update Jadwal Otomatis</span>
                        </div>
                        <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition transform translate-x-2 group-hover:translate-x-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </form>
            </div>

            <div class="mt-8 p-6 bg-white/5 rounded-3xl border border-white/10">
                <p class="text-xs font-bold text-blue-200 uppercase tracking-widest mb-4">System Health</p>
                <div class="flex items-center gap-3">
                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-sm font-semibold">Database Connected</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    // Data real dari database (7 hari terakhir)
    const chartLabels = @json($chartLabels);
    const chartData   = @json($chartData);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: chartData,
                borderColor: '#1e2a78',
                backgroundColor: 'rgba(30, 42, 120, 0.05)',
                borderWidth: 4,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#1e2a78',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.02)' },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });


</script>
@endpush
