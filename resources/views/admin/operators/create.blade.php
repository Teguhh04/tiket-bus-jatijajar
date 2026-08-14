@extends('layouts.admin')

@section('title', 'Tambah Operator Baru')

@section('admin_content')
<div class="max-w-2xl">
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex items-center justify-between">
            <h3 class="font-bold text-slate-800">Form Operator</h3>
            <a href="{{ route('admin.operators') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>
        
        <form action="{{ route('admin.operators.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Operator</label>
                <input type="text" name="name" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm transition" placeholder="Contoh: Sinar Jaya">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Domain Website</label>
                <input type="text" name="domain" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm transition" placeholder="Contoh: sinarjayagroup.co.id">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">URL Logo (Opsional)</label>
                <input type="url" name="logo_url" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm transition" placeholder="https://link-ke-gambar-logo.png">
                <p class="text-[9px] text-slate-400 mt-2 ml-1 italic">*Jika dikosongkan, sistem akan mencoba mengambil logo dari domain di atas.</p>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-[#1e2a78] text-white rounded-2xl font-bold text-sm shadow-lg shadow-blue-900/20 hover:bg-[#151d54] transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Operator
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
