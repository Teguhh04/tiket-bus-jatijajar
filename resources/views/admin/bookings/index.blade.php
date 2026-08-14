@extends('layouts.admin')

@section('title', 'Manajemen Pesanan Tiket')

@section('admin_content')
<div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">

    {{-- Header --}}
    <div class="p-5 md:p-8 border-b border-slate-50">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="font-bold text-slate-800">Daftar Semua Pesanan</h3>
                <p class="text-xs text-slate-400 mt-1">Total {{ $bookings->total() }} pesanan terdaftar di sistem</p>
            </div>
            <form method="GET" action="{{ route('admin.bookings') }}" class="flex gap-2 w-full sm:w-auto">
                <div class="relative flex-1 sm:flex-none">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kode atau nama..." class="pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition w-full sm:w-64">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <button type="submit" class="px-4 py-2.5 bg-[#1e2a78] text-white rounded-xl text-sm font-bold hover:bg-[#151d54] transition flex-shrink-0">Cari</button>
                @if(request('q'))
                <a href="{{ route('admin.bookings') }}" class="px-4 py-2.5 bg-slate-100 text-slate-500 rounded-xl text-sm font-bold hover:bg-slate-200 transition flex-shrink-0">Reset</a>
                @endif
            </form>
        </div>
    </div>


    @if($bookings->isEmpty())
    <div class="py-20 text-center">
        <svg class="w-14 h-14 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        <p class="text-slate-400 font-bold text-lg">Tidak ada pesanan ditemukan</p>
        <p class="text-slate-300 text-sm mt-1">Coba kata kunci lain atau belum ada pesanan baru.</p>
    </div>
    @else

    {{-- ===== MOBILE CARD VIEW (hidden on md+) ===== --}}
    <div class="md:hidden divide-y divide-slate-100">
        @foreach($bookings as $booking)
        <div class="p-4 space-y-3">
            {{-- Top row: code + status --}}
            <div class="flex items-start justify-between gap-2">
                <div>
                    <p class="text-sm font-bold text-[#1e2a78]">{{ $booking->ticket_code }}</p>
                    <p class="text-[10px] text-slate-400 mt-0.5">{{ $booking->created_at->translatedFormat('d M Y, H:i') }}</p>
                </div>
                @if($booking->status == 'lunas')
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-bold uppercase flex-shrink-0"><span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>Lunas</span>
                @elseif($booking->status == 'menunggu_verifikasi')
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-bold uppercase flex-shrink-0"><span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></span>Verifikasi</span>
                @elseif($booking->status == 'pending')
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-orange-50 text-orange-600 rounded-full text-[10px] font-bold uppercase flex-shrink-0"><span class="w-1.5 h-1.5 bg-orange-500 rounded-full animate-pulse"></span>Pending</span>
                @else
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-50 text-red-600 rounded-full text-[10px] font-bold uppercase flex-shrink-0"><span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>Batal</span>
                @endif
            </div>

            {{-- Penumpang + Rute --}}
            <div class="bg-slate-50 rounded-xl p-3 space-y-2">
                <div>
                    @foreach($booking->passengers as $pax)
                    <p class="text-sm font-bold text-slate-800">{{ $pax->name }}</p>
                    @endforeach
                    <p class="text-[10px] text-blue-500 font-semibold">{{ $booking->passengers->first()->phone ?? '-' }}</p>
                </div>
                <div class="flex items-center gap-2 text-xs font-bold text-slate-700">
                    <span>{{ $booking->trip->origin->city }}</span>
                    <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    <span>{{ $booking->trip->destination->city }}</span>
                </div>
                <p class="text-[10px] text-slate-400">{{ $booking->trip->operator->name }} · {{ $booking->trip->bus_class }}</p>
            </div>

            {{-- Total + Aksi --}}
            <div class="flex items-center justify-between">
                <p class="text-base font-bold text-slate-800">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</p>
                <div class="flex gap-2">

                    <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition" title="Detail">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ===== DESKTOP TABLE VIEW (hidden on mobile) ===== --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50/50">
                <tr>
                    <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kode & Tanggal</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Detail Penumpang</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Rute & Operator</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pembayaran</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($bookings as $booking)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-6">
                        <p class="text-sm font-bold text-[#1e2a78]">{{ $booking->ticket_code }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">{{ $booking->created_at->translatedFormat('d M Y, H:i') }}</p>
                    </td>
                    <td class="px-6 py-6">
                        <div class="space-y-1">
                            @foreach($booking->passengers as $pax)
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-blue-400 rounded-full"></span>
                                <p class="text-sm font-bold text-slate-700">{{ $pax->name }}</p>
                            </div>
                            @endforeach
                            <p class="text-[10px] text-blue-500 font-semibold mt-1">HP: {{ $booking->passengers->first()->phone ?? '-' }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-6">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-sm font-bold text-slate-800">{{ $booking->trip->origin->city }}</span>
                            <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            <span class="text-sm font-bold text-slate-800">{{ $booking->trip->destination->city }}</span>
                        </div>
                        <p class="text-[10px] text-slate-400 font-medium">{{ $booking->trip->operator->name }} ({{ $booking->trip->bus_class }})</p>
                    </td>
                    <td class="px-6 py-6">
                        <p class="text-sm font-bold text-slate-800">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</p>
                        <span class="text-[10px] text-slate-400 font-semibold">{{ $booking->payment_method ?? 'Belum Pilih' }}</span>
                    </td>
                    <td class="px-6 py-6">
                        @if($booking->status == 'lunas')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-bold uppercase tracking-wider"><span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>Lunas</span>
                        @elseif($booking->status == 'menunggu_verifikasi')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-bold uppercase tracking-wider"><span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></span>Verifikasi</span>
                        @elseif($booking->status == 'pending')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-orange-50 text-orange-600 rounded-full text-[10px] font-bold uppercase tracking-wider"><span class="w-1.5 h-1.5 bg-orange-500 rounded-full animate-pulse"></span>Pending</span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-50 text-red-600 rounded-full text-[10px] font-bold uppercase tracking-wider"><span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>Batal</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex justify-end gap-2">

                            @if(in_array($booking->status, ['pending', 'menunggu_verifikasi']))
                                <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="lunas">
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:bg-green-50 hover:text-green-600 transition" title="Setujui/Lunas">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                </form>
                                <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" onsubmit="return confirm('Batalkan pesanan ini?')">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="batal">
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:bg-red-50 hover:text-red-600 transition" title="Batalkan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition" title="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Hapus permanen?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:bg-red-50 hover:text-red-600 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="p-5 md:p-8 bg-slate-50/50 border-t border-slate-100">
        {{ $bookings->links() }}
    </div>
</div>
@endsection
