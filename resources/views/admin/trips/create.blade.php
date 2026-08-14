@extends('layouts.admin')

@section('title', 'Tambah Jadwal Bus Baru')

@section('admin_content')
<div class="max-w-4xl">
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex items-center justify-between">
            <h3 class="font-bold text-slate-800">Form Jadwal Keberangkatan</h3>
            <a href="{{ route('admin.trips') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>
        
        <form action="{{ route('admin.trips.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Operator -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Pilih Operator</label>
                    <select name="operator_id" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm appearance-none transition">
                        @foreach($operators as $op)
                        <option value="{{ $op->id }}">{{ $op->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Bus Class -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Kelas Bus</label>
                    <select name="bus_class" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm appearance-none transition">
                        <option value="Executive">Executive</option>
                        <option value="Business">Business</option>
                        <option value="Sleeper">Sleeper</option>
                        <option value="Double Decker">Double Decker</option>
                    </select>
                </div>

                <!-- Origin -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Terminal Asal</label>
                    <select name="origin_id" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm appearance-none transition">
                        @foreach($terminals as $terminal)
                        <option value="{{ $terminal->id }}">{{ $terminal->name }} ({{ $terminal->city }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Destination -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Terminal Tujuan</label>
                    <select name="destination_id" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm appearance-none transition">
                        @foreach($terminals as $terminal)
                        <option value="{{ $terminal->id }}">{{ $terminal->name }} ({{ $terminal->city }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Departure Time -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Waktu Keberangkatan</label>
                    <input type="datetime-local" name="departure_time" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm transition">
                </div>

                <!-- Arrival Time -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Estimasi Tiba</label>
                    <input type="datetime-local" name="arrival_time" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm transition">
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Harga Tiket (Rp)</label>
                    <input type="number" name="price" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm transition" placeholder="250000">
                </div>

                <!-- Seats -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Kapasitas Kursi</label>
                    <input type="number" name="available_seats" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm transition" placeholder="32">
                </div>

                <!-- Facilities -->
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Fasilitas (Pisahkan dengan koma)</label>
                    <input type="text" name="facilities" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm transition" placeholder="AC, WiFi, Toilet, Snack">
                </div>

                <!-- Image -->
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Foto Bus (Optional)</label>
                    <input type="file" name="image" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm transition">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-5 bg-[#1e2a78] text-white rounded-2xl font-bold text-sm shadow-lg shadow-blue-900/20 hover:bg-[#151d54] transition flex items-center justify-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                    Publish Jadwal Bus
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
