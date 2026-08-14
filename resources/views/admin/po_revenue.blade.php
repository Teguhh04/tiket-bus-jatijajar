@extends('layouts.admin')

@section('title', 'Pendapatan PO Bus')

@section('admin_content')
@php
$poColors = [
    'Sinar Jaya' => [
        'bg' => 'bg-blue-600',
        'text' => 'text-white',
        'border' => 'border-blue-700',
        'hover' => 'hover:bg-blue-700 hover:shadow-blue-200/50',
        'shadow' => 'shadow-blue-100',
        'gradient' => 'from-blue-600 to-blue-800',
        'text_card' => 'text-blue-100',
        'accent' => 'text-blue-400',
    ],
    'Agra Mas' => [
        'bg' => 'bg-red-600',
        'text' => 'text-white',
        'border' => 'border-red-700',
        'hover' => 'hover:bg-red-700 hover:shadow-red-200/50',
        'shadow' => 'shadow-red-100',
        'gradient' => 'from-red-600 to-red-800',
        'text_card' => 'text-red-100',
        'accent' => 'text-red-400',
    ],
    'Rosalia Indah' => [
        'bg' => 'bg-orange-500',
        'text' => 'text-white',
        'border' => 'border-orange-600',
        'hover' => 'hover:bg-orange-600 hover:shadow-orange-200/50',
        'shadow' => 'shadow-orange-100',
        'gradient' => 'from-orange-500 to-orange-700',
        'text_card' => 'text-orange-100',
        'accent' => 'text-orange-400',
    ],
    'Putra Mulya' => [
        'bg' => 'bg-cyan-600',
        'text' => 'text-white',
        'border' => 'border-cyan-700',
        'hover' => 'hover:bg-cyan-700 hover:shadow-cyan-200/50',
        'shadow' => 'shadow-cyan-100',
        'gradient' => 'from-cyan-600 to-cyan-800',
        'text_card' => 'text-cyan-100',
        'accent' => 'text-cyan-400',
    ],
    'Harapan Jaya' => [
        'bg' => 'bg-amber-500',
        'text' => 'text-white',
        'border' => 'border-amber-600',
        'hover' => 'hover:bg-amber-600 hover:shadow-amber-200/50',
        'shadow' => 'shadow-amber-100',
        'gradient' => 'from-amber-500 to-amber-700',
        'text_card' => 'text-amber-100',
        'accent' => 'text-amber-400',
    ],
    'Lorena' => [
        'bg' => 'bg-emerald-600',
        'text' => 'text-white',
        'border' => 'border-emerald-700',
        'hover' => 'hover:bg-emerald-700 hover:shadow-emerald-200/50',
        'shadow' => 'shadow-emerald-100',
        'gradient' => 'from-emerald-600 to-emerald-800',
        'text_card' => 'text-emerald-100',
        'accent' => 'text-emerald-400',
    ],
    'Sudiro Tungga Jaya' => [
        'bg' => 'bg-neutral-800',
        'text' => 'text-white',
        'border' => 'border-neutral-900',
        'hover' => 'hover:bg-neutral-900 hover:shadow-neutral-800/50',
        'shadow' => 'shadow-neutral-200',
        'gradient' => 'from-neutral-800 to-neutral-950',
        'text_card' => 'text-neutral-300',
        'accent' => 'text-yellow-500',
    ],
    'Gunung Harta' => [
        'bg' => 'bg-green-600',
        'text' => 'text-white',
        'border' => 'border-green-700',
        'hover' => 'hover:bg-green-700 hover:shadow-green-200/50',
        'shadow' => 'shadow-green-100',
        'gradient' => 'from-green-600 to-green-800',
        'text_card' => 'text-green-100',
        'accent' => 'text-green-400',
    ],
    'Haryanto' => [
        'bg' => 'bg-slate-900',
        'text' => 'text-white',
        'border' => 'border-slate-950',
        'hover' => 'hover:bg-slate-950 hover:shadow-slate-800/50',
        'shadow' => 'shadow-slate-300',
        'gradient' => 'from-slate-900 to-slate-950',
        'text_card' => 'text-slate-300',
        'accent' => 'text-blue-400',
    ],
    'Shantika' => [
        'bg' => 'bg-rose-900',
        'text' => 'text-white',
        'border' => 'border-rose-950',
        'hover' => 'hover:bg-rose-950 hover:shadow-rose-900/50',
        'shadow' => 'shadow-rose-100',
        'gradient' => 'from-rose-800 to-rose-950',
        'text_card' => 'text-rose-200',
        'accent' => 'text-rose-400',
    ],
];

// Default fallback colors
$fallbackColor = [
    'bg' => 'bg-[#1e2a78]',
    'text' => 'text-white',
    'border' => 'border-blue-900',
    'hover' => 'hover:bg-blue-800 hover:shadow-blue-200/50',
    'shadow' => 'shadow-blue-100',
    'gradient' => 'from-blue-700 to-blue-900',
    'text_card' => 'text-blue-100',
    'accent' => 'text-blue-400',
];
@endphp

<div class="space-y-8">
    <!-- Header Summary Card -->
    <div class="bg-gradient-to-r from-blue-700 to-indigo-900 p-8 rounded-[2.5rem] shadow-xl text-white relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute right-20 bottom-0 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-blue-200 mb-1">DASHBOARD KEUANGAN</p>
                <h2 class="text-3xl font-black tracking-tight">Pendapatan Per PO Bus</h2>
                <p class="text-xs text-blue-200 mt-1.5 max-w-xl leading-relaxed">
                    Sistem pemisahan uang otomatis berdasarkan PO Konsumen. Semua pembayaran dilakukan melalui satu rekening utama (VA/QRIS) Jatijajar, dan dialokasikan ke masing-masing PO secara transparan.
                </p>
            </div>
            @if($poFilter)
            <div>
                <a href="{{ route('admin.po_revenue') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-white/10 hover:bg-white/20 border border-white/20 rounded-2xl text-xs font-bold transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    Tampilkan Semua PO
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- PO Bus Grid List (Large & Beautiful Custom Styled Buttons) -->
    <div>
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 ml-1">Pilih PO Bus (Operator)</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($allOperators as $op)
                @php
                    $colors = $poColors[$op->name] ?? $fallbackColor;
                    $isActive = ($poFilter == $op->id);
                @endphp
                <a href="{{ route('admin.po_revenue', ['po_filter' => $op->id]) }}"
                   class="flex flex-col items-center justify-center p-6 rounded-[2rem] border transition-all duration-300 group text-center relative overflow-hidden h-40
                   {{ $isActive 
                      ? $colors['bg'] . ' ' . $colors['text'] . ' ' . $colors['border'] . ' shadow-xl ' . $colors['shadow'] . ' scale-105 ring-4 ring-offset-2 ring-indigo-500'
                      : 'bg-white text-slate-700 border-slate-100 hover:border-slate-300 hover:shadow-lg shadow-sm hover:scale-[1.02]' }}">
                    
                    @if($isActive)
                        <div class="absolute -right-4 -top-4 w-16 h-16 bg-white/10 rounded-full blur-xl"></div>
                    @endif

                    <!-- Operator Logo -->
                    <div class="w-16 h-16 rounded-2xl bg-slate-50 border border-slate-100 p-2 flex items-center justify-center mb-4 transition-transform group-hover:scale-110 shadow-sm relative z-10">
                        <img src="https://logo.clearbit.com/{{ $op->domain }}"
                             onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($op->name) }}&background=random&color=fff&size=64&bold=true&format=svg';"
                             class="w-full h-full object-contain" alt="{{ $op->name }}">
                    </div>

                    <!-- Operator Name -->
                    <span class="text-sm font-extrabold tracking-tight relative z-10">{{ $op->name }}</span>
                    
                    <!-- Rating Badge -->
                    <span class="text-[9px] font-bold px-2 py-0.5 rounded-full mt-1.5 flex items-center gap-1 {{ $isActive ? 'bg-white/20 text-white' : 'bg-amber-50 text-amber-700 border border-amber-100' }}">
                        <svg class="w-2.5 h-2.5 fill-current text-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        {{ number_format($op->rating ?: 4.5, 1) }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Revenue Breakdown details or Blank State -->
    @if($selectedOperator)
        @php
            $colors = $poColors[$selectedOperator->name] ?? $fallbackColor;
        @endphp
        <div class="space-y-6">
            <!-- Dynamic Color Header for Selected Operator -->
            <div class="flex items-center gap-4 pb-2">
                <div class="w-12 h-12 rounded-2xl bg-white border border-slate-100 p-2 shadow-sm flex items-center justify-center">
                    <img src="https://logo.clearbit.com/{{ $selectedOperator->domain }}"
                         onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($selectedOperator->name) }}&background=random&color=fff&size=64&bold=true&format=svg';"
                         class="w-full h-full object-contain" alt="{{ $selectedOperator->name }}">
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-800 tracking-tight">Rincian Keuangan: {{ $selectedOperator->name }}</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Statistik pendapatan berdasarkan daerah tujuan pembeli</p>
                </div>
            </div>

            <!-- Dynamic Colored Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="bg-gradient-to-br {{ $colors['gradient'] }} p-6 rounded-[2rem] shadow-lg text-white relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
                    <p class="text-[10px] font-bold {{ $colors['text_card'] }} uppercase tracking-widest mb-1">Total Pendapatan</p>
                    <h3 class="text-2xl font-bold mb-4">Rp {{ number_format($poTotalRevenue, 0, ',', '.') }}</h3>
                    <div class="flex items-center justify-between text-[11px] font-bold bg-white/10 rounded-xl px-3 py-1.5">
                        <span class="opacity-80">Alokasi VA / QRIS</span>
                        <span class="px-2 py-0.5 rounded-full bg-white/20 text-white font-extrabold uppercase">SUKSES</span>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-5">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Pesanan</p>
                        <h3 class="text-2xl font-bold text-slate-800">{{ $poTotalBookings }} Transaksi</h3>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-5">
                    <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Penumpang</p>
                        <h3 class="text-2xl font-bold text-slate-800">{{ $poTotalPassengers }} Orang</h3>
                    </div>
                </div>
            </div>

            <!-- Breakdown Table -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-50">
                    <h4 class="font-bold text-slate-800">Alokasi Pendapatan Per Tujuan</h4>
                    <p class="text-xs text-slate-400 mt-1">Uang yang terkumpul untuk {{ $selectedOperator->name }} dikelompokkan berdasarkan destinasi</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">No</th>
                                <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Daerah Tujuan (Terminal)</th>
                                <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jumlah Transaksi</th>
                                <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jumlah Penumpang (Pax)</th>
                                <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Alokasi Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($poRevenueData as $idx => $row)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-8 py-5 text-sm font-bold text-slate-400">{{ $idx + 1 }}</td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800">{{ $row->destination_city }}</p>
                                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Terminal {{ $row->destination_city }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-sm font-semibold text-slate-600">{{ $row->total_bookings }} Pesanan</td>
                                <td class="px-8 py-5 text-sm font-semibold text-slate-600">{{ $row->total_passengers }} Orang</td>
                                <td class="px-8 py-5 text-sm font-extrabold text-emerald-600 text-right">Rp {{ number_format($row->total_revenue, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-12 text-center text-slate-400 text-sm">Belum ada transaksi lunas untuk operator ini</td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if($poRevenueData->isNotEmpty())
                        <tfoot class="bg-slate-50/50 border-t border-slate-100">
                            <tr>
                                <td colspan="2" class="px-8 py-5 text-xs font-bold text-slate-800 uppercase tracking-widest">Total Alokasi {{ $selectedOperator->name }}</td>
                                <td class="px-8 py-5 text-sm font-bold text-slate-800">{{ $poTotalBookings }} Transaksi</td>
                                <td class="px-8 py-5 text-sm font-bold text-slate-800">{{ $poTotalPassengers }} Orang</td>
                                <td class="px-8 py-5 text-base font-black text-emerald-700 text-right">Rp {{ number_format($poTotalRevenue, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    @else
        <!-- Blank/Initial State -->
        <div class="py-20 text-center bg-white rounded-[2.5rem] border border-slate-100 shadow-sm max-w-xl mx-auto">
            <div class="w-20 h-20 bg-slate-50 text-slate-400 rounded-3xl flex items-center justify-center mx-auto mb-6 border border-slate-100 shadow-sm">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 2v-6m-8 9h10a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <h4 class="text-lg font-black text-slate-800 tracking-tight">Pilih PO Bus</h4>
            <p class="text-sm text-slate-400 mt-2 max-w-xs mx-auto leading-relaxed">
                Pilih salah satu PO Bus di atas untuk melihat rincian alokasi pendapatan secara mendalam berdasarkan data transaksi tiket online.
            </p>
        </div>
    @endif
</div>
@endsection
