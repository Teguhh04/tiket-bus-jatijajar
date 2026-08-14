@extends('layouts.admin')

@section('title', 'Master Data Operator Bus')

@section('admin_content')
<div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-5 md:p-8 border-b border-slate-50 flex items-center justify-between gap-4">
        <div>
            <h3 class="font-bold text-slate-800">Daftar Operator Bus</h3>
            <p class="text-xs text-slate-400 mt-1">Total {{ $operators->total() }} mitra operator bus</p>
        </div>
        <a href="{{ route('admin.operators.create') }}" class="px-4 py-2.5 bg-[#1e2a78] text-white rounded-xl text-sm font-bold hover:bg-[#151d54] transition shadow-lg shadow-blue-900/20 flex items-center gap-2 flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span class="hidden sm:inline">Tambah Operator</span>
            <span class="sm:hidden">Tambah</span>
        </a>
    </div>


    @if($operators->isEmpty())
    <div class="py-20 text-center">
        <svg class="w-14 h-14 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        <p class="text-slate-400 font-bold text-lg">Belum ada operator terdaftar</p>
        <p class="text-slate-300 text-sm mt-1">Silakan tambahkan data operator bus baru.</p>
    </div>
    @else

    {{-- MOBILE CARD VIEW --}}
    <div class="md:hidden divide-y divide-slate-100">
        @foreach($operators as $op)
        <div class="p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-white border border-slate-100 flex items-center justify-center p-1.5 shadow-sm flex-shrink-0">
                <img src="{{ asset($op->logo_url ?? '') }}" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($op->name) }}&background=random&color=fff&size=128&bold=true&format=svg';" alt="{{ $op->name }}" class="w-full h-full object-contain">
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-slate-800 truncate">{{ $op->name }}</p>
                <p class="text-xs text-blue-500 truncate">{{ $op->domain }}</p>
                <span class="inline-block mt-1 px-2 py-0.5 bg-blue-50 text-blue-600 rounded-full text-[10px] font-bold">{{ $op->trips_count }} Jadwal</span>
            </div>
            <div class="flex gap-2 flex-shrink-0">
                <a href="{{ route('admin.operators.edit', $op->id) }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </a>
                <form action="{{ route('admin.operators.destroy', $op->id) }}" method="POST" onsubmit="return confirm('Hapus operator ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:bg-red-50 hover:text-red-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    {{-- DESKTOP TABLE VIEW --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50/50">
                <tr>
                    <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Logo & Nama</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Website/Domain</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Jumlah Jadwal</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Terdaftar Sejak</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($operators as $op)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center p-1.5 shadow-sm">
                                <img src="{{ asset($op->logo_url ?? '') }}" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($op->name) }}&background=random&color=fff&size=128&bold=true&format=svg';" alt="{{ $op->name }}" class="w-full h-full object-contain">
                            </div>
                            <p class="text-sm font-bold text-slate-800">{{ $op->name }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-6 text-sm text-blue-500 font-medium">{{ $op->domain }}</td>
                    <td class="px-6 py-6 text-center">
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-bold">{{ $op->trips_count }} Jadwal</span>
                    </td>
                    <td class="px-6 py-6 text-sm text-slate-400">{{ $op->created_at->translatedFormat('d M Y') }}</td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.operators.edit', $op->id) }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.operators.destroy', $op->id) }}" method="POST" onsubmit="return confirm('Hapus operator ini?')">
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
        {{ $operators->links() }}
    </div>
</div>
@endsection
