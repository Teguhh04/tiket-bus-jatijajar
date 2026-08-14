@extends('layouts.app')
@section('content')
@php
$dep = \Carbon\Carbon::parse($trip->departure_time);
$seatsParam = request('seats', '');
$selectedSeats = $seatsParam ? explode(',', $seatsParam) : [];
$passengerCount = count($selectedSeats) ?: request('count', 1);
$adminFee = 0;
$total = ($trip->price * $passengerCount) + $adminFee;
@endphp

<!-- Navbar -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-100 h-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 flex items-center justify-between h-full">
        <div class="flex items-center gap-3 sm:gap-4">
            <a href="{{ route('ticket.detail', $trip->id) }}?count={{ $passengerCount }}" class="p-2 hover:bg-gray-100 rounded-xl transition border border-gray-100 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div class="flex items-center gap-2 sm:gap-3">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-yellow-400 rounded-full flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.22.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                </div>
                <div>
                    <span class="text-base sm:text-lg font-black tracking-tight text-[#1e2a78] block leading-none">Jatijajar</span>
                    <span class="text-[8px] sm:text-[9px] tracking-[0.2em] font-bold text-slate-400 uppercase mt-1 block">TIKET ONLINE</span>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-4 sm:gap-6">
            <div class="flex items-center gap-1.5 sm:gap-2 text-xs sm:text-sm text-gray-500 font-bold cursor-pointer hover:text-[#1e2a78] transition">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="hidden xs:inline">Bantuan</span>
            </div>
            <button class="p-2 hover:bg-gray-100 rounded-xl transition border border-gray-100 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>
</nav>

<!-- Unified Compact Header -->
<div class="pt-16 bg-[#1e2a78] text-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-8 py-5 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
        <div class="flex-1">
            <h1 class="text-base sm:text-lg font-bold">Data Penumpang</h1>
            <p class="text-blue-200 text-[10px] opacity-60">Lengkapi data penumpang untuk melanjutkan pemesanan</p>
        </div>
        
        <!-- Standardized Stepper -->
        <div class="flex items-center justify-center overflow-x-auto py-1">
            <div class="flex flex-col items-center gap-1.5">
                <div class="w-7 h-7 rounded-full bg-white text-[#1e2a78] flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span class="text-[9px] font-bold uppercase tracking-tighter opacity-80">PILIH</span>
            </div>
            <div class="w-6 sm:w-10 h-[1px] bg-white/20 mb-5 flex-shrink-0"></div>
            <div class="flex flex-col items-center gap-1.5">
                <div class="w-7 h-7 rounded-full bg-white text-[#1e2a78] flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span class="text-[9px] font-bold uppercase tracking-tighter opacity-80">DETAIL</span>
            </div>
            <div class="w-6 sm:w-10 h-[1px] bg-white/20 mb-5 flex-shrink-0"></div>
            <div class="flex flex-col items-center gap-1.5">
                <div class="w-7 h-7 rounded-full bg-white text-[#1e2a78] flex items-center justify-center font-bold text-xs shadow-sm ring-2 ring-white/20">
                    3
                </div>
                <span class="text-[9px] font-bold uppercase tracking-tighter">DATA</span>
            </div>
            <div class="w-6 sm:w-10 h-[1px] bg-white/20 mb-5 flex-shrink-0"></div>
            <div class="flex flex-col items-center gap-1.5">
                <div class="w-7 h-7 rounded-full border border-white/20 flex items-center justify-center font-bold text-xs text-white/40">
                    4
                </div>
                <span class="text-[9px] font-bold uppercase tracking-tighter text-white/40">BAYAR</span>
            </div>
        </div>
    </div>
</div>

<div class="bg-[#f8fafc] min-h-screen pb-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-8 py-6 sm:py-10 flex flex-col lg:flex-row gap-6 lg:gap-8 items-start">
        
        <!-- LEFT: PASSENGER FORM -->
        <div class="w-full lg:flex-1 space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Card Header -->
                <div class="p-5 border-b border-gray-50 flex items-center gap-3 bg-slate-50/50">
                    <div class="w-8 h-8 bg-blue-600 rounded-xl flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">Data Penumpang</h3>
                        <p class="text-[10px] text-slate-400">Mohon isi data penumpang dengan benar sesuai kartu identitas</p>
                    </div>
                </div>

                <!-- Form Content -->
                <form action="{{ route('ticket.store', $trip->id) }}" method="POST" class="p-4 sm:p-6" x-data="{ showModal: false, message: '', primaryPhone: '{{ old('passengers.1.phone') }}' }" @submit.prevent="
                    let missing = [];
                    $el.querySelectorAll('input[required]').forEach(input => {
                        if (!input.value.trim()) {
                            missing.push(input.getAttribute('name'));
                        }
                    });
                    let invalidNik = false;
                    $el.querySelectorAll('input[name*=\'[nik]\']').forEach(input => {
                        if(input.value.length !== 16) invalidNik = true;
                    });
                    
                    if (missing.length) {
                        this.message = 'Harap isi semua field wajib.';
                        this.showModal = true;
                        alert(this.message); // fallback if modal is not implemented
                    } else if (invalidNik) {
                        this.message = 'Harap pastikan semua NIK berjumlah 16 digit.';
                        this.showModal = true;
                        alert(this.message); // fallback
                    } else {
                        $el.submit();
                    }
                ">
                    @csrf
                    <input type="hidden" name="seats" value="{{ $seatsParam }}">
                                        
                    @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <p class="text-sm font-bold text-red-600">Mohon periksa kembali data Anda:</p>
                        </div>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li class="text-xs text-red-500">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4 flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <p class="text-sm font-bold text-red-600">{{ session('error') }}</p>
                    </div>
                    @endif
                    
                    @for($i = 1; $i <= $passengerCount; $i++)
                    @php
                        $assignedSeat = $selectedSeats[$i - 1] ?? ('A' . $i);
                    @endphp
                    <div class="mb-8 last:mb-0 border-b border-dashed border-slate-100 pb-8 last:border-b-0 last:pb-0">
                        <input type="hidden" name="passengers[{{$i}}][seat_number]" value="{{ $assignedSeat }}">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="font-extrabold text-slate-800 text-sm sm:text-base">Penumpang {{ $i }} <span class="text-xs sm:text-sm font-bold text-[#1e2a78] ml-2 bg-blue-50 px-2.5 py-1 rounded-lg">Kursi #{{ $assignedSeat }}</span></h4>
                            <span class="text-[9px] sm:text-[10px] bg-blue-50 text-blue-600 px-3 py-0.5 rounded-full font-bold uppercase tracking-wider">{{ $passengerCount }} Penumpang</span>
                        </div>

                        <div class="space-y-4" x-data="{ nik: '{{ old('passengers.'.$i.'.nik') }}' }">
                            <!-- Nama Lengkap -->
                            <div class="relative">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Nama Lengkap</label>
                                <input type="text" name="passengers[{{$i}}][name]" value="{{ old('passengers.'.$i.'.name') }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-1 focus:ring-blue-500 focus:border-[#1e2a78] outline-none text-sm placeholder:text-slate-300 transition text-gray-800 font-bold" placeholder="Masukkan nama lengkap sesuai KTP">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($i == 1)
                                <!-- No Telepon -->
                                <div class="relative">
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">No. Telepon (Hanya Pemesan Utama)</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        </div>
                                        <input type="text" name="passengers[{{$i}}][phone]" x-model="primaryPhone" required class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-1 focus:ring-blue-500 focus:border-[#1e2a78] outline-none text-sm placeholder:text-slate-300 transition text-gray-800 font-bold" placeholder="Nomor telepon aktif">
                                    </div>
                                </div>
                                @else
                                <input type="hidden" name="passengers[{{$i}}][phone]" :value="primaryPhone">
                                @endif

                                <!-- NIK -->
                                <div class="relative" @if($i > 1) style="grid-column: span 1 / span 2;" @endif>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">NIK (KTP)</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                                        </div>
                                        <input type="text" name="passengers[{{$i}}][nik]" required x-model="nik" maxlength="16" minlength="16" @input="nik = nik.replace(/[^0-9]/g, '')" :class="(nik.length > 0 && nik.length < 16) ? 'w-full pl-10 pr-4 py-3 bg-red-50 border border-red-500 rounded-xl focus:ring-1 focus:ring-red-500 focus:border-red-500 outline-none text-sm placeholder:text-red-300 transition text-red-800 font-bold' : 'w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-1 focus:ring-blue-500 focus:border-[#1e2a78] outline-none text-sm placeholder:text-slate-300 transition text-gray-800 font-bold'" placeholder="NIK (16 digit)">
                                    </div>
                                    <p x-show="nik.length > 0 && nik.length < 16" class="text-xs text-red-500 font-bold mt-1.5 ml-1" style="display: none;">NIK harus 16 digit angka.</p>
                                </div>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Jenis Kelamin</label>
                                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                                    <label class="flex-1 cursor-pointer group">
                                        <input type="radio" name="passengers[{{$i}}][gender]" value="Laki-laki" class="hidden peer" {{ old('passengers.'.$i.'.gender', 'Laki-laki') == 'Laki-laki' ? 'checked' : '' }}>
                                        <div class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl peer-checked:bg-blue-50 peer-checked:border-[#1e2a78] transition group-hover:border-slate-300">
                                            <div class="w-4 h-4 rounded-full border-2 border-gray-300 peer-checked:border-[#1e2a78] flex items-center justify-center flex-shrink-0">
                                                <div class="w-2.5 h-2.5 rounded-full bg-[#1e2a78] scale-0 peer-checked:scale-100 transition"></div>
                                            </div>
                                            <span class="text-sm font-bold text-slate-700">Laki-laki</span>
                                        </div>
                                    </label>
                                    <label class="flex-1 cursor-pointer group">
                                        <input type="radio" name="passengers[{{$i}}][gender]" value="Perempuan" class="hidden peer" {{ old('passengers.'.$i.'.gender') == 'Perempuan' ? 'checked' : '' }}>
                                        <div class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl peer-checked:bg-blue-50 peer-checked:border-[#1e2a78] transition group-hover:border-slate-300">
                                            <div class="w-4 h-4 rounded-full border-2 border-gray-300 peer-checked:border-[#1e2a78] flex items-center justify-center flex-shrink-0">
                                                <div class="w-2.5 h-2.5 rounded-full bg-[#1e2a78] scale-0 peer-checked:scale-100 transition"></div>
                                            </div>
                                            <span class="text-sm font-bold text-slate-700">Perempuan</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor

                    <!-- Info Box -->
                    <div class="mt-6 bg-blue-50 border border-blue-100 rounded-xl p-4 flex gap-3">
                        <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <p class="text-xs font-bold text-blue-700 mb-0.5">Pastikan data yang Anda masukkan sudah benar.</p>
                            <p class="text-[10px] text-blue-600 leading-normal">E-ticket akan dikirim ke nomor telepon yang Anda daftarkan setelah pembayaran lunas.</p>
                        </div>
                    </div>

                    <!-- Button Disable when NIK invalid -->
                    <button type="submit" class="mt-6 w-full bg-[#f5a623] hover:bg-[#e6991a] text-white font-bold py-4 rounded-xl text-sm transition shadow-lg shadow-orange-200 flex items-center justify-center gap-2">
                        Lanjutkan ke Pembayaran
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- RIGHT: SUMMARY SIDEBAR -->
        <div class="w-full lg:w-[340px] flex-shrink-0">
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 lg:sticky lg:top-24">
                <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-6">Ringkasan Pemesanan</h3>

                <!-- Trip Info Card -->
                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-4 sm:p-5 mb-8">
                    <div class="flex items-center gap-3 font-bold text-gray-800 mb-4 text-sm sm:text-base">
                        <span>{{ $trip->origin->city }}</span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        <span>{{ $trip->destination->city }}</span>
                    </div>
                    <div class="space-y-3 text-xs text-gray-500">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>{{ $dep->translatedFormat('d M Y (l)') }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $dep->format('H:i') }} WIB</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $trip->operator->name }} ({{ $trip->bus_class }})</span>
                        </div>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="space-y-4 mb-8">
                    <div class="flex justify-between text-xs sm:text-sm">
                        <span class="text-gray-500 font-medium">Penumpang</span>
                        <span class="font-bold text-gray-800">{{ $passengerCount }} Orang</span>
                    </div>
                    <div class="flex justify-between text-xs sm:text-sm">
                        <span class="text-gray-500 font-medium">Harga Tiket</span>
                        <span class="font-bold text-gray-800">Rp {{ number_format($trip->price * $passengerCount,0,',','.') }}</span>
                    </div>
                </div>

                <div class="flex justify-between items-center pt-6 border-t border-gray-100">
                    <span class="font-bold text-gray-900 whitespace-nowrap text-xs sm:text-sm">Total Pembayaran</span>
                    <span class="text-lg sm:text-xl font-bold text-blue-700 whitespace-nowrap">Rp {{ number_format($total,0,',','.') }}</span>
                </div>

                <!-- Trust Badge -->
                <div class="mt-8 sm:mt-10 p-4 sm:p-5 bg-blue-50 border border-blue-100 rounded-2xl flex gap-3 sm:gap-4">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <div>
                        <p class="text-xs font-bold text-blue-700 mb-1">Aman & Terpercaya</p>
                        <p class="text-[10px] text-blue-600 leading-relaxed opacity-80">Data Anda kami jaga kerahasiaannya dan tidak akan dibagikan ke pihak lain.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
