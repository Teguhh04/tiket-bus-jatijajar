@extends('layouts.app')
@section('content')
@php
$dep = \Carbon\Carbon::parse($trip->departure_time);
$arr = \Carbon\Carbon::parse($trip->arrival_time);
$facilities = is_array($trip->facilities) ? $trip->facilities : json_decode($trip->facilities ?? '[]', true);
$seatsParam = request('seats', '');
$selectedSeats = $seatsParam ? explode(',', $seatsParam) : [];
$passengerCount = count($selectedSeats) ?: request('count', 1);
$adminFee = 0;
$total = ($trip->price * $passengerCount) + $adminFee;
@endphp

<!-- Unified Compact Header -->
<div class="pt-16 bg-[#1e2a78] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 py-5 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
        <div class="flex items-center gap-4 sm:gap-6">
            <a href="{{ route('ticket.select_seat', $trip->id) }}?count={{ $passengerCount }}" class="p-2 hover:bg-white/10 rounded-xl transition border border-white/20 text-white flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="text-base sm:text-lg font-bold">Detail Perjalanan</h2>
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
                <div class="w-7 h-7 rounded-full bg-white text-[#1e2a78] flex items-center justify-center font-bold text-xs shadow-sm ring-2 ring-white/20">
                    2
                </div>
                <span class="text-[9px] font-bold uppercase tracking-tighter">DETAIL</span>
            </div>
            <div class="w-6 sm:w-10 h-[1px] bg-white/20 mb-5 flex-shrink-0"></div>
            <div class="flex flex-col items-center gap-1.5">
                <div class="w-7 h-7 rounded-full border border-white/20 flex items-center justify-center font-bold text-xs text-white/40">
                    3
                </div>
                <span class="text-[9px] font-bold uppercase tracking-tighter text-white/40">DATA</span>
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

<!-- Main Content -->
<div class="bg-[#f0f2f5] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 py-6 sm:py-8 flex flex-col lg:flex-row gap-6 items-start">

        <!-- LEFT COLUMN -->
        <div class="flex-1 min-w-0">
            <!-- Trip Header -->
            <div class="bg-white rounded-2xl p-5 sm:p-8 mb-6 shadow-sm">
                <div class="flex flex-col sm:flex-row items-start justify-between mb-1 gap-4">
                    <div>
                        <p class="text-gray-500 text-xs sm:text-sm mb-3">{{ $dep->translatedFormat('d F Y (l)') }} &bull; {{ $dep->format('H:i') }}</p>
                        <div class="flex flex-wrap items-center gap-2 sm:gap-3 mb-3">
                            <span class="text-xl sm:text-3xl font-bold text-gray-900">{{ $trip->origin->city }}</span>
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            <span class="text-xl sm:text-3xl font-bold text-gray-900">{{ $trip->destination->city }}</span>
                        </div>
                        <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                            <span class="text-sm sm:text-base text-gray-700 font-medium">{{ $trip->operator->name }} ({{ $trip->bus_class }})</span>
                            <span class="bg-green-100 text-green-700 text-[10px] sm:text-xs font-bold px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full">Tersedia</span>
                        </div>
                    </div>
                    <div class="text-left sm:text-right flex-shrink-0 sm:ml-8 w-full sm:w-auto flex sm:block items-center justify-between sm:justify-start border-t sm:border-0 border-gray-100 pt-3 sm:pt-0 mt-3 sm:mt-0">
                        <div class="flex items-center gap-3 sm:block">
                            <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-sm border border-gray-100 overflow-hidden bg-white sm:ml-auto p-1.5">
                                <img src="https://logo.clearbit.com/{{ $trip->operator->domain }}" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($trip->operator->name) }}&background=random&color=fff&size=128&bold=true&format=svg';" alt="{{ $trip->operator->name }}" class="w-full h-full object-contain">
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="flex gap-0.5 justify-end mt-1">
                                @for($i=0;$i<5;$i++)<svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor
                            </div>
                            <p class="text-[10px] sm:text-xs text-gray-400 mt-1">4.8 (350+ ulasan)</p>
                        </div>
                    </div>
                </div>

                <!-- Route Timeline -->
                <div class="border-t border-gray-100 mt-6 pt-6">
                    <div class="relative ml-3">
                        {{-- Vertical line --}}
                        <div class="absolute left-[7px] top-6 h-[60px] w-[2px] border-l-2 border-dashed border-gray-300"></div>

                        {{-- Origin --}}
                        <div class="flex items-start gap-4 mb-5">
                            <div class="w-4 h-4 rounded-full bg-blue-500 mt-1 flex-shrink-0 ring-4 ring-blue-100"></div>
                            <div>
                                <p class="text-base font-bold text-gray-900">{{ $dep->format('H:i') }}</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $trip->origin->name }}, {{ $trip->origin->city }}</p>
                                <p class="text-xs text-gray-400">{{ $trip->origin->address ?? 'Jl. Terminal ' . $trip->origin->city . ' KM 1, ' . $trip->origin->city }}</p>
                            </div>
                        </div>

                        {{-- Destination --}}
                        <div class="flex items-start gap-4 mb-5">
                            <div class="w-4 h-4 rounded-full bg-red-500 mt-1 flex-shrink-0 ring-4 ring-red-100"></div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ $trip->destination->name }}</p>
                                <p class="text-xs text-gray-400">{{ $trip->destination->address ?? 'Jl. Terminal ' . $trip->destination->city . ' KM 1, ' . $trip->destination->city }}</p>
                            </div>
                        </div>

                        {{-- Arrival estimate --}}
                        <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Estimasi tiba {{ $arr->translatedFormat('d M Y') }} &bull; {{ $arr->format('H:i') }}
                        </div>
                    </div>
                </div>

                <!-- Facilities -->
                <div class="border-t border-gray-100 mt-6 pt-6">
                    <div class="flex flex-wrap gap-4 sm:gap-8">
                        @foreach($facilities as $f)
                        <div class="flex flex-col items-center text-center w-[60px] sm:w-auto">
                            <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center mb-1.5 sm:mb-2">
                                @if(str_contains($f,'Executive'))
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                @elseif(str_contains($f,'AC'))
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                                @elseif(str_contains($f,'Reclining'))
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                @elseif(str_contains($f,'Bagasi'))
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                @elseif(str_contains($f,'USB'))
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                @else
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                @endif
                            </div>
                            <span class="text-[10px] sm:text-[11px] text-gray-500 leading-tight">{{ $f }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Detail Perjalanan -->
            <div class="bg-white rounded-2xl p-5 sm:p-8 shadow-sm">
                <h3 class="font-bold text-gray-900 text-sm sm:text-base pb-3 mb-4 sm:mb-5 border-b border-gray-100" style="text-decoration:underline; text-underline-offset:4px;">Detail Perjalanan</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 sm:gap-x-16 sm:gap-y-5">
                    <div><p class="text-[10px] sm:text-xs text-gray-400 mb-0.5 sm:mb-1">Operator</p><p class="text-xs sm:text-sm font-semibold text-gray-800">{{ $trip->operator->name }}</p></div>
                    <div><p class="text-[10px] sm:text-xs text-gray-400 mb-0.5 sm:mb-1">Rute</p><p class="text-xs sm:text-sm font-semibold text-gray-800">{{ $trip->origin->name }} - {{ $trip->destination->name }}</p></div>
                    <div><p class="text-[10px] sm:text-xs text-gray-400 mb-0.5 sm:mb-1">Jenis Bus</p><p class="text-xs sm:text-sm font-semibold text-gray-800">{{ $trip->bus_class }}</p></div>
                    <div><p class="text-[10px] sm:text-xs text-gray-400 mb-0.5 sm:mb-1">Fasilitas</p><p class="text-xs sm:text-sm font-semibold text-gray-800">{{ implode(', ', is_array($trip->facilities) ? $trip->facilities : json_decode($trip->facilities ?? '[]', true)) }}</p></div>
                    <div><p class="text-[10px] sm:text-xs text-gray-400 mb-0.5 sm:mb-1">Durasi</p><p class="text-xs sm:text-sm font-semibold text-gray-800">{{ $trip->duration }}</p></div>
                    <div><p class="text-[10px] sm:text-xs text-gray-400 mb-0.5 sm:mb-1">Catatan</p><p class="text-xs sm:text-sm font-semibold text-gray-800">Tiba di tujuan sesuai kondisi lalu lintas</p></div>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDEBAR -->
        <div class="w-full lg:w-[360px] flex-shrink-0">
            <div class="bg-white rounded-2xl p-6 shadow-sm sticky top-24">
                <h3 class="text-lg font-bold text-gray-900 mb-5">Ringkasan Pemesanan</h3>

                <div class="space-y-3.5 text-sm pb-5 border-b border-gray-100">
                    <div class="flex justify-between"><span class="text-gray-500">Rute</span><span class="font-semibold text-gray-800">{{ $trip->origin->city }} → {{ $trip->destination->city }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Tanggal</span><span class="font-semibold text-gray-800">{{ $dep->translatedFormat('d M Y (l)') }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Jam</span><span class="font-semibold text-gray-800">{{ $dep->format('H:i') }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Operator</span><span class="font-semibold text-gray-800">{{ $trip->operator->name }} ({{ $trip->bus_class }})</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Penumpang</span><span class="font-semibold text-gray-800">{{ $passengerCount }} Orang</span></div>
                    @if(!empty($selectedSeats))
                    <div class="flex justify-between"><span class="text-gray-500">Nomor Kursi</span><span class="font-bold text-blue-600">Kursi {{ implode(', ', $selectedSeats) }}</span></div>
                    @endif
                </div>

                <div class="space-y-3 text-sm py-5 border-b border-gray-100">
                    <div class="flex justify-between"><span class="text-gray-500">Harga Tiket ({{ $passengerCount }}x)</span><span class="font-semibold text-gray-800">Rp {{ number_format($trip->price * $passengerCount,0,',','.') }}</span></div>
                </div>

                <div class="flex justify-between items-center py-5">
                    <span class="font-bold text-gray-800">Total Pembayaran</span>
                    <span class="text-xl font-bold text-[#1e2a78]">Rp {{ number_format($total,0,',','.') }}</span>
                </div>

                <!-- Info Penting -->
                <div class="bg-blue-50 rounded-xl p-4 mb-5">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <p class="text-sm font-bold text-blue-700 mb-0.5">Informasi Penting</p>
                            <p class="text-xs text-blue-600 leading-relaxed">Tiket yang sudah dipesan tidak dapat dibatalkan atau diubah jadwal.</p>
                        </div>
                    </div>
                </div>

                <a href="{{ route('ticket.book', $trip->id) }}?{{ !empty($seatsParam) ? 'seats='.$seatsParam : 'count='.$passengerCount }}" class="flex items-center justify-center gap-2 w-full bg-[#f5a623] hover:bg-[#e6991a] text-white font-bold py-4 rounded-xl text-sm transition hover:shadow-lg">
                    Lanjutkan ke Data Penumpang
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
