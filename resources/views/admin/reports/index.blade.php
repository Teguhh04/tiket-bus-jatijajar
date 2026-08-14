@extends('layouts.admin')

@section('title', 'Laporan Keuangan')

@section('admin_content')
<div class="space-y-8">

    {{-- ===== FILTER SECTION ===== --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-bold text-slate-800 text-lg">Filter Laporan</h3>
                <p class="text-xs text-slate-400 mt-1">Tampilkan transaksi berdasarkan rentang tanggal dan status</p>
            </div>
            {{-- Action Buttons --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.reports.export', ['start_date' => $startDate, 'end_date' => $endDate, 'status' => $status]) }}" class="flex items-center gap-2 px-5 py-3 bg-green-600 text-white rounded-2xl font-bold text-sm hover:bg-green-700 transition shadow-lg shadow-green-900/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Download Excel/CSV
                </a>
                <button onclick="window.print()" class="flex items-center gap-2 px-5 py-3 bg-[#1e2a78] text-white rounded-2xl font-bold text-sm hover:bg-[#151d54] transition shadow-lg shadow-blue-900/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak Laporan
                </button>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.reports') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ $endDate }}"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Status Pembayaran</label>
                <select name="status" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition appearance-none">
                    <option value="all"                  {{ $status == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="lunas"                {{ $status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="menunggu_verifikasi"  {{ $status == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="pending"              {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="batal"                {{ $status == 'batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>
            <button type="submit" class="px-8 py-3 bg-[#f5a623] text-white rounded-2xl font-bold text-sm hover:bg-[#e6991a] transition shadow-lg shadow-orange-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Tampilkan
            </button>
        </form>
    </div>

    {{-- ===== SUMMARY CARDS ===== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Total Revenue --}}
        <div class="bg-gradient-to-br from-green-500 to-emerald-700 p-6 rounded-[2rem] shadow-lg shadow-green-200 text-white relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition"></div>
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] opacity-70 mb-2">Total Pendapatan</p>
            <h3 class="text-3xl font-bold mb-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <p class="text-xs opacity-60">Hanya transaksi berstatus Lunas</p>
            <div class="flex items-center gap-2 mt-4 bg-black/10 rounded-xl px-4 py-2 text-xs font-bold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }} – {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}
            </div>
        </div>

        {{-- Total Tickets --}}
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 p-6 rounded-[2rem] shadow-lg shadow-blue-200 text-white relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition"></div>
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] opacity-70 mb-2">Tiket Terjual</p>
            <h3 class="text-3xl font-bold mb-1">{{ number_format($totalTicketsSold) }}</h3>
            <p class="text-xs opacity-60">Penumpang dari transaksi Lunas</p>
            <div class="flex items-center gap-2 mt-4 bg-black/10 rounded-xl px-4 py-2 text-xs font-bold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                Total Penumpang
            </div>
        </div>

        {{-- Total Bookings --}}
        <div class="bg-gradient-to-br from-slate-700 to-slate-900 p-6 rounded-[2rem] shadow-lg shadow-slate-200 text-white relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition"></div>
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] opacity-70 mb-2">Total Transaksi</p>
            <h3 class="text-3xl font-bold mb-1">{{ number_format($totalBookingsCount) }}</h3>
            <p class="text-xs opacity-60">Semua status di periode ini</p>
            <div class="flex items-center gap-2 mt-4 bg-black/10 rounded-xl px-4 py-2 text-xs font-bold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Semua Pemesanan
            </div>
        </div>
    </div>

    {{-- ===== DETAIL TABLE ===== --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-800">Rincian Transaksi</h3>
                <p class="text-xs text-slate-400 mt-1">Ditemukan <strong class="text-slate-600">{{ $bookings->count() }}</strong> transaksi di periode yang dipilih</p>
            </div>
            <span class="text-[10px] font-bold text-slate-400 bg-slate-50 px-4 py-2 rounded-xl">
                {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }} – {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}
            </span>
        </div>

        @if($bookings->isEmpty())
        <div class="py-24 text-center">
            <svg class="w-16 h-16 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 2v-6m-8 9h10a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            <p class="text-slate-400 font-bold text-lg">Tidak ada transaksi</p>
            <p class="text-slate-300 text-sm mt-1">Coba ubah filter tanggal atau status</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/70">
                    <tr>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">No</th>
                        <th class="px-4 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kode Tiket</th>
                        <th class="px-4 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tanggal Pesan</th>
                        <th class="px-4 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Penumpang</th>
                        <th class="px-4 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Rute</th>
                        <th class="px-4 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Metode</th>
                        <th class="px-4 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($bookings as $i => $booking)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-8 py-5 text-sm font-bold text-slate-300">{{ $i + 1 }}</td>
                        <td class="px-4 py-5">
                            <p class="text-sm font-bold text-[#1e2a78]">{{ $booking->ticket_code }}</p>
                        </td>
                        <td class="px-4 py-5">
                            <p class="text-sm text-slate-600">{{ $booking->created_at->translatedFormat('d M Y') }}</p>
                            <p class="text-[10px] text-slate-400">{{ $booking->created_at->format('H:i') }} WIB</p>
                        </td>
                        <td class="px-4 py-5">
                            <p class="text-sm font-semibold text-slate-700">{{ $booking->passengers->first()->name ?? '-' }}</p>
                            <p class="text-[10px] text-slate-400">{{ $booking->total_passengers }} penumpang</p>
                        </td>
                        <td class="px-4 py-5">
                            <div class="flex items-center gap-1.5">
                                <span class="text-sm font-semibold text-slate-700">{{ $booking->trip->origin->city ?? '-' }}</span>
                                <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                <span class="text-sm font-semibold text-slate-700">{{ $booking->trip->destination->city ?? '-' }}</span>
                            </div>
                            <p class="text-[10px] text-slate-400">{{ $booking->trip->operator->name ?? '-' }}</p>
                        </td>
                        <td class="px-4 py-5">
                            <span class="text-xs text-slate-500 font-semibold">{{ $booking->payment_method ?? '-' }}</span>
                        </td>
                        <td class="px-4 py-5">
                            <p class="text-sm font-bold text-slate-800">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-8 py-5">
                            @if($booking->status == 'lunas')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Lunas
                                </span>
                            @elseif($booking->status == 'menunggu_verifikasi')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></span> Verifikasi
                                </span>
                            @elseif($booking->status == 'pending')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-orange-50 text-orange-600 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 bg-orange-500 rounded-full animate-pulse"></span> Pending
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-50 text-red-600 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Batal
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                {{-- Footer: Total Row --}}
                <tfoot class="bg-slate-50/70 border-t-2 border-slate-200">
                    <tr>
                        <td colspan="6" class="px-8 py-5 text-sm font-bold text-slate-600 text-right">
                            Total Pendapatan (Lunas):
                        </td>
                        <td class="px-4 py-5">
                            <p class="text-base font-black text-green-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-8 py-5"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @endif
    </div>

</div>

<style>
    @media print {
        aside, header, form, .no-print { display: none !important; }
        main { padding: 0 !important; }
        .bg-white { box-shadow: none !important; border: 1px solid #e2e8f0 !important; }
    }
</style>
@endsection
