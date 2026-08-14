@extends('layouts.admin')

@section('title', 'Edit Terminal')

@section('admin_content')
<div class="max-w-2xl">
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex items-center justify-between">
            <h3 class="font-bold text-slate-800">Edit Data Terminal</h3>
            <a href="{{ route('admin.terminals') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>
        
        <form action="{{ route('admin.terminals.update', $terminal->id) }}" method="POST" class="p-8 space-y-6">
            @csrf
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Terminal</label>
                <input type="text" name="name" value="{{ $terminal->name }}" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm transition" placeholder="Contoh: Terminal JATIJAJAR">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Kota / Wilayah</label>
                <input type="text" name="city" value="{{ $terminal->city }}" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm transition" placeholder="Contoh: Depok">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Alamat Lengkap</label>
                <textarea name="address" required rows="3" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm transition" placeholder="Contoh: Jl. Raya Bogor, Jatijajar...">{{ $terminal->address }}</textarea>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-[#1e2a78] text-white rounded-2xl font-bold text-sm shadow-lg shadow-blue-900/20 hover:bg-[#151d54] transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
