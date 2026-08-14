@extends('layouts.admin')

@section('title', 'Edit Jadwal Bus')

@section('admin_content')
<div class="max-w-4xl">
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex items-center justify-between">
            <h3 class="font-bold text-slate-800">Edit Jadwal Keberangkatan</h3>
            <a href="{{ route('admin.trips') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>
        
        <form action="{{ route('admin.trips.update', $trip->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Operator -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Pilih Operator</label>
                    <select name="operator_id" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm appearance-none transition">
                        @foreach($operators as $op)
                        <option value="{{ $op->id }}" {{ $trip->operator_id == $op->id ? 'selected' : '' }}>{{ $op->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Bus Class -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Kelas Bus</label>
                    <select name="bus_class" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm appearance-none transition">
                        <option value="Executive" {{ $trip->bus_class == 'Executive' ? 'selected' : '' }}>Executive</option>
                        <option value="Business" {{ $trip->bus_class == 'Business' ? 'selected' : '' }}>Business</option>
                        <option value="Sleeper" {{ $trip->bus_class == 'Sleeper' ? 'selected' : '' }}>Sleeper</option>
                        <option value="Double Decker" {{ $trip->bus_class == 'Double Decker' ? 'selected' : '' }}>Double Decker</option>
                    </select>
                </div>

                <!-- Origin -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Terminal Asal</label>
                    <select name="origin_id" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm appearance-none transition">
                        @foreach($terminals as $terminal)
                        <option value="{{ $terminal->id }}" {{ $trip->origin_id == $terminal->id ? 'selected' : '' }}>{{ $terminal->name }} ({{ $terminal->city }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Destination -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Terminal Tujuan</label>
                    <select name="destination_id" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm appearance-none transition">
                        @foreach($terminals as $terminal)
                        <option value="{{ $terminal->id }}" {{ $trip->destination_id == $terminal->id ? 'selected' : '' }}>{{ $terminal->name }} ({{ $terminal->city }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Departure Time -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Waktu Keberangkatan</label>
                    <input type="datetime-local" name="departure_time" value="{{ \Carbon\Carbon::parse($trip->departure_time)->format('Y-m-d\TH:i') }}" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm transition">
                </div>

                <!-- Arrival Time -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Estimasi Tiba</label>
                    <input type="datetime-local" name="arrival_time" value="{{ \Carbon\Carbon::parse($trip->arrival_time)->format('Y-m-d\TH:i') }}" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm transition">
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Harga Tiket (Rp)</label>
                    <input type="number" name="price" value="{{ $trip->price }}" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm transition" placeholder="250000">
                </div>

                <!-- Seats -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Kapasitas Kursi</label>
                    <input type="number" name="available_seats" value="{{ $trip->available_seats }}" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm transition" placeholder="32">
                </div>

                <!-- Facilities -->
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Fasilitas (Pisahkan dengan koma)</label>
                    <input type="text" name="facilities" value="{{ is_array($trip->facilities) ? implode(', ', $trip->facilities) : $trip->facilities }}" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm transition" placeholder="AC, WiFi, Toilet, Snack">
                </div>

                <!-- Image -->
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Foto Bus (Optional)</label>
                    <input type="file" name="image" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm transition">
                    @if($trip->image)
                        <div class="mt-2 text-xs text-slate-400">File saat ini: {{ $trip->image }}</div>
                    @endif
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-5 bg-[#1e2a78] text-white rounded-2xl font-bold text-sm shadow-lg shadow-blue-900/20 hover:bg-[#151d54] transition flex items-center justify-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan Jadwal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
