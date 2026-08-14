@extends('layouts.admin')

@section('title', 'Update Status Pesanan')

@section('admin_content')
<div class="max-w-2xl mx-auto lg:mx-0">
    <div class="bg-white rounded-2xl sm:rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-slate-50 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 text-sm sm:text-base">Edit Transaksi #{{ $booking->ticket_code }}</h3>
            <a href="{{ route('admin.bookings') }}" class="text-[10px] sm:text-xs font-bold text-slate-400 hover:text-slate-600 transition flex items-center gap-1 sm:gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>
        
        <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf
            
            @if($booking->payment_proof)
            <div class="mb-6">
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Bukti Transfer Pengguna</label>
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 flex flex-col items-center">
                    <a href="{{ asset($booking->payment_proof) }}" target="_blank" class="group relative block w-full max-h-64 overflow-hidden rounded-xl border border-gray-200 shadow-sm bg-white cursor-zoom-in">
                        <img src="{{ asset($booking->payment_proof) }}" alt="Bukti Transfer" class="w-full max-h-64 object-contain mx-auto group-hover:scale-[1.02] transition duration-300">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs font-bold gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                            Perbesar Gambar
                        </div>
                    </a>
                    <span class="text-[10px] text-slate-400 font-semibold mt-2.5 text-center">Klik gambar untuk membuka di tab baru</span>
                </div>
            </div>
            @else
            <div class="mb-6 p-4 bg-slate-50 border border-dashed border-slate-200 rounded-2xl flex items-center gap-3">
                <svg class="w-5 h-5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span class="text-[10px] sm:text-xs text-slate-500 font-bold">Pengguna belum mengunggah bukti transfer.</span>
            </div>
            @endif

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Status Pembayaran</label>
                <select name="status" required class="w-full px-4 sm:px-5 py-3 sm:py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm appearance-none transition">
                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending (Menunggu Pembayaran)</option>
                    <option value="menunggu_verifikasi" {{ $booking->status == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="lunas" {{ $booking->status == 'lunas' ? 'selected' : '' }}>Lunas (Telah Dibayar)</option>
                    <option value="batal" {{ $booking->status == 'batal' ? 'selected' : '' }}>Batal (Dibatalkan)</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Metode Pembayaran</label>
                <select name="payment_method" required class="w-full px-4 sm:px-5 py-3 sm:py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm appearance-none transition">
                    <option value="Transfer Bank" {{ $booking->payment_method == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                    <option value="QRIS" {{ $booking->payment_method == 'QRIS' ? 'selected' : '' }}>QRIS (QRIS)</option>
                </select>
            </div>

            <div class="p-4 bg-blue-50 rounded-2xl">
                <p class="text-[10px] sm:text-xs text-blue-600 font-medium leading-relaxed">
                    <strong class="block mb-1">Catatan Admin:</strong>
                    Mengubah status menjadi <strong>Lunas</strong> akan membuat tiket ini muncul sebagai tiket aktif di akun pengguna (jika ada).
                </p>
            </div>

            <div class="pt-2 sm:pt-4">
                <button type="submit" class="w-full py-3 sm:py-4 bg-[#1e2a78] text-white rounded-2xl font-bold text-sm shadow-lg shadow-blue-900/20 hover:bg-[#151d54] transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Update Transaksi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
