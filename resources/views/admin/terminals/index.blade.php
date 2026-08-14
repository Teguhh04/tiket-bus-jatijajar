@extends('layouts.admin')

@section('title', 'Master Data Terminal')

@section('admin_content')
<div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-8 border-b border-slate-50 flex justify-between items-center">
        <div>
            <h3 class="font-bold text-slate-800">Daftar Terminal</h3>
            <p class="text-xs text-slate-400 mt-1">Total {{ $terminals->total() }} terminal yang terdaftar</p>
        </div>
        <a href="{{ route('admin.terminals.create') }}" class="px-5 py-3 bg-[#1e2a78] text-white rounded-2xl text-sm font-bold hover:bg-[#151d54] transition shadow-lg shadow-blue-900/20 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Terminal
        </a>
    </div>

    @if($terminals->isEmpty())
    <div class="py-24 text-center">
        <svg class="w-16 h-16 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        <p class="text-slate-400 font-bold text-lg">Belum ada terminal terdaftar</p>
        <p class="text-slate-300 text-sm mt-1">Silakan tambahkan data terminal baru.</p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50/50">
                <tr>
                    <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama Terminal</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kota / Wilayah</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Alamat Lengkap</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($terminals as $terminal)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <p class="text-sm font-bold text-slate-800">{{ $terminal->name }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-6">
                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-[10px] font-bold uppercase tracking-wider">{{ $terminal->city }}</span>
                    </td>
                    <td class="px-6 py-6 text-sm text-slate-500">{{ $terminal->address ?: 'Alamat belum diatur' }}</td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.terminals.edit', $terminal->id) }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.terminals.destroy', $terminal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus terminal ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:bg-red-50 hover:text-red-600 transition" title="Hapus Terminal">
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
    <div class="p-8 bg-slate-50/50 border-t border-slate-100">
        {{ $terminals->links() }}
    </div>
</div>
@endsection
