@extends('layouts.admin')

@section('title', 'Manajemen Jadwal Keberangkatan')

@section('admin_content')
<div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
    {{-- Header --}}
    <div class="p-5 md:p-8 border-b border-slate-50 flex items-center justify-between gap-4">
        <div>
            <h3 class="font-bold text-slate-800">Daftar Jadwal Bus</h3>
            <p class="text-xs text-slate-400 mt-1">Kelola rute, harga, dan jam keberangkatan</p>
        </div>
        <div class="flex items-center gap-2">
            <form action="{{ route('admin.trips.generate') }}" method="POST" class="inline-block" onsubmit="return confirm('Proses ini akan menduplikasi jadwal keberangkatan hari ini untuk 30 hari ke depan secara otomatis. Lanjutkan?');">
                @csrf
                <button type="submit" class="px-4 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-50 transition flex items-center gap-2 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span class="hidden sm:inline">Auto 30 Hari</span>
                </button>
            </form>
            <a href="{{ route('admin.trips.create') }}" class="px-4 py-2.5 bg-[#1e2a78] text-white rounded-xl text-sm font-bold hover:bg-[#151d54] transition shadow-lg shadow-blue-900/20 flex items-center gap-2 flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span class="hidden sm:inline">Tambah Jadwal</span>
                <span class="sm:hidden">Tambah</span>
            </a>
        </div>
    </div>


    @if($trips->isEmpty())
    <div class="py-20 text-center">
        <svg class="w-14 h-14 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        <p class="text-slate-400 font-bold text-lg">Belum ada jadwal bus</p>
        <p class="text-slate-300 text-sm mt-1">Silakan tambah jadwal baru untuk memulai penjualan tiket.</p>
    </div>
    @else

    {{-- ===== MOBILE CARD VIEW ===== --}}
    <div class="md:hidden divide-y divide-slate-100">
        @foreach($trips as $trip)
        <div class="p-4 space-y-3">
            {{-- Operator + Rute --}}
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center p-1.5 shadow-sm flex-shrink-0">
                    <img src="{{ asset($trip->operator->logo_url ?? '') }}" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($trip->operator->name) }}&background=random&color=fff&size=128&bold=true&format=svg';" alt="{{ $trip->operator->name }}" class="w-full h-full object-contain">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-800 truncate">{{ $trip->operator->name }}</p>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="text-xs font-bold text-slate-600">{{ $trip->origin->city }}</span>
                        <svg class="w-3 h-3 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        <span class="text-xs font-bold text-slate-600">{{ $trip->destination->city }}</span>
                    </div>
                </div>
                <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-bold uppercase flex-shrink-0">{{ $trip->bus_class }}</span>
            </div>

            {{-- Jadwal + Harga --}}
            <div class="flex items-center justify-between bg-slate-50 rounded-xl px-4 py-3">
                <div>
                    <p class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($trip->departure_time)->format('H:i') }} WIB</p>
                    <p class="text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($trip->departure_time)->translatedFormat('d M Y') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-[#f5a623]">Rp {{ number_format($trip->price, 0, ',', '.') }}</p>
                    <p class="text-[10px] text-slate-400">{{ $trip->available_seats }} kursi tersisa</p>
                </div>
            </div>

            {{-- Aksi --}}
            <div class="flex gap-2 justify-end">
                <a href="{{ route('admin.trips.edit', $trip->id) }}" class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-100 text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition text-xs font-bold">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit
                </a>
                <form action="{{ route('admin.trips.destroy', $trip->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-100 text-slate-500 hover:bg-red-50 hover:text-red-600 transition text-xs font-bold">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ===== DESKTOP TABLE VIEW ===== --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50/50">
                <tr>
                    <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Operator</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Rute</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Waktu</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kelas & Kursi</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Harga</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($trips as $trip)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center p-1.5 shadow-sm">
                                <img src="{{ asset($trip->operator->logo_url ?? '') }}" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($trip->operator->name) }}&background=random&color=fff&size=128&bold=true&format=svg';" alt="{{ $trip->operator->name }}" class="w-full h-full object-contain">
                            </div>
                            <p class="text-sm font-bold text-slate-800">{{ $trip->operator->name }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-6">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-bold text-slate-800">{{ $trip->origin->city }}</span>
                            <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            <span class="text-xs font-bold text-slate-800">{{ $trip->destination->city }}</span>
                        </div>
                        <p class="text-[10px] text-slate-400">{{ $trip->origin->name }} → {{ $trip->destination->name }}</p>
                    </td>
                    <td class="px-6 py-6">
                        <p class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($trip->departure_time)->format('H:i') }} WIB</p>
                        <p class="text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($trip->departure_time)->translatedFormat('d M Y') }}</p>
                    </td>
                    <td class="px-6 py-6">
                        <span class="px-2.5 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-bold uppercase tracking-wider">{{ $trip->bus_class }}</span>
                        <p class="text-[10px] text-slate-400 mt-1.5 font-semibold">{{ $trip->available_seats }} Kursi Tersisa</p>
                    </td>
                    <td class="px-6 py-6">
                        <p class="text-sm font-bold text-[#f5a623]">Rp {{ number_format($trip->price, 0, ',', '.') }}</p>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.trips.edit', $trip->id) }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.trips.destroy', $trip->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:bg-red-50 hover:text-red-600 transition">
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
        {{ $trips->links() }}
    </div>
</div>
@endsection
