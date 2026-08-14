@extends('layouts.app')

@section('content')
<!-- Unified Compact Header -->
<section class="pt-16">
    <div class="bg-[#1e2a78] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 py-5 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
            <div class="flex items-center gap-4 sm:gap-5">
                <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4M4 17l4 4m-4-4l4-4"/></svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 sm:gap-3 text-base sm:text-lg font-bold">
                        <span>{{ $origin ?? 'Depok' }}</span>
                        <svg class="w-4 h-4 opacity-60 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        <span>{{ $destination ?: 'Semua Tujuan' }}</span>
                    </div>
                    <p class="text-blue-200 text-[10px] mt-0.5 opacity-60">{{ \Carbon\Carbon::parse($date)->translatedFormat('d M Y') }}</p>
                </div>
            </div>

            <!-- Standardized Stepper -->
            <div class="flex items-center justify-center overflow-x-auto py-1">
                <div class="flex flex-col items-center gap-1.5">
                    <div class="w-7 h-7 rounded-full bg-white text-[#1e2a78] flex items-center justify-center font-bold text-xs shadow-sm ring-2 ring-white/20">
                        1
                    </div>
                    <span class="text-[9px] font-bold uppercase tracking-tighter">PILIH</span>
                </div>
                <div class="w-6 sm:w-10 h-[1px] bg-white/20 mb-5 flex-shrink-0"></div>
                <div class="flex flex-col items-center gap-1.5">
                    <div class="w-7 h-7 rounded-full border border-white/20 flex items-center justify-center font-bold text-xs text-white/40">
                        2
                    </div>
                    <span class="text-[9px] font-bold uppercase tracking-tighter text-white/40">DETAIL</span>
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

            <a href="{{ route('home') }}" class="text-center border border-white/20 rounded-xl px-4 py-2 text-xs font-semibold hover:bg-white/10 transition">
                Ubah Pencarian
            </a>
        </div>
    </div>
</section>

<!-- Filter Bar -->
<section class="bg-white border-b border-gray-100 sticky top-16 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 py-3.5 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <button class="flex items-center gap-2 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition font-medium">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filter
            </button>
            <div class="relative flex-1 sm:flex-none">
                <select class="w-full sm:w-auto appearance-none border border-gray-200 rounded-xl px-4 py-2.5 pr-10 text-sm text-gray-700 bg-white hover:bg-gray-50 transition font-medium cursor-pointer">
                    <option>Urutkan: Paling Awal</option>
                    <option>Harga Terendah</option>
                    <option>Harga Tertinggi</option>
                    <option>Paling Akhir</option>
                </select>
                <svg class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </div>
        </div>
        <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-400">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Semua waktu adalah waktu setempat
        </div>
    </div>
</section>

<!-- Trip Cards -->
<section class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 py-6 sm:py-8">
        <div class="flex flex-col gap-5">
            @foreach($trips as $trip)
            @php
                $depTime = \Carbon\Carbon::parse($trip->departure_time);
                $facilities = is_array($trip->facilities) ? $trip->facilities : json_decode($trip->facilities ?? '[]', true);
            @endphp
            <div class="bg-white rounded-2xl border border-gray-100 p-5 sm:p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5 lg:gap-8">
                    <!-- Left: Time & Route -->
                    <div class="flex items-start gap-4 sm:gap-8 flex-1">
                        <!-- Departure Time -->
                        <div class="min-w-[80px] sm:min-w-[100px]">
                            <p class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $depTime->format('H:i') }}</p>
                            <p class="text-xs sm:text-sm text-gray-500 mt-1">Berangkat</p>
                            <span class="inline-block mt-2 bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full">Tersedia</span>
                        </div>

                        <!-- Route Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start gap-2 mb-2">
                                <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                <span class="text-xs sm:text-sm text-gray-700 font-medium truncate">{{ $trip->origin->name }}, {{ $trip->origin->city }}</span>
                            </div>
                            <div class="flex items-center gap-2 ml-1.5 mb-2">
                                <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="text-[11px] text-gray-400">{{ $trip->duration }}</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                <span class="text-xs sm:text-sm text-gray-700 font-medium truncate">{{ $trip->destination->name }} {{ $trip->destination->city }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Center: Operator -->
                    <div class="flex items-center gap-3 sm:gap-4 flex-1 lg:justify-center border-t lg:border-t-0 lg:border-l border-gray-100 pt-4 lg:pt-0 lg:pl-8">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm border border-gray-100 overflow-hidden bg-white p-1">
                            <img src="{{ asset($trip->operator->logo_url ?? '') }}" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($trip->operator->name) }}&background=random&color=fff&size=128&bold=true&format=svg';" alt="{{ $trip->operator->name }}" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 text-sm sm:text-base">{{ $trip->operator->name }}</p>
                            <p class="text-xs sm:text-sm text-gray-500">{{ $trip->bus_class }} Class</p>
                            <div class="flex flex-wrap items-center gap-3 mt-2 sm:mt-3">
                                @foreach($facilities as $facility)
                                <div class="flex items-center gap-1.5 text-[11px] text-gray-500">
                                    @if(str_contains($facility, 'Reclining'))
                                    <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                    @elseif(str_contains($facility, 'AC'))
                                    <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                                    @else
                                    <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    @endif
                                    <span>{{ $facility }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Right: Price & Button -->
                    <div class="flex items-center justify-between lg:flex-col lg:items-end lg:justify-center lg:text-right border-t lg:border-t-0 lg:border-l border-gray-100 pt-4 lg:pt-0 lg:pl-8">
                        <div>
                            <p class="text-xl sm:text-2xl font-bold text-[#1e2a78]">Rp {{ number_format($trip->price, 0, ',', '.') }}</p>
                            <p class="text-[10px] sm:text-xs text-gray-400 mt-0.5">{{ $trip->available_seats }} kursi tersisa</p>
                        </div>
                        <a href="{{ route('ticket.select_seat', $trip->id) }}" class="inline-block bg-[#1e2a78] text-white font-bold px-6 sm:px-8 py-2.5 sm:py-3 rounded-xl text-xs sm:text-sm hover:bg-[#2d3a8c] transition shadow-md shadow-blue-900/10">
                            Pilih Kursi
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
