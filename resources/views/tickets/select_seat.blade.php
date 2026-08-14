@extends('layouts.app')
@section('content')
@php
$dep = \Carbon\Carbon::parse($trip->departure_time);
$dbOccupied = \App\Models\Passenger::whereHas('booking', function ($q) use ($trip) {
    $q->where('trip_id', $trip->id)
      ->whereIn('status', ['lunas', 'menunggu_verifikasi', 'pending']);
})->pluck('seat_number')->map(function($seat) {
    return (int) preg_replace('/[^0-9]/', '', $seat);
})->filter()->values()->all();

$occupiedSeats = array_values(array_unique($dbOccupied));
@endphp

<div x-data="{ 
    selectedSeats: [], 
    maxSeats: 3,
    pricePerSeat: {{ $trip->price }},
    occupiedSeats: {{ json_encode($occupiedSeats) }},
    toggleSeat(id) {
        if (this.occupiedSeats.includes(id)) return;
        if (this.selectedSeats.includes(id)) {
            this.selectedSeats = this.selectedSeats.filter(s => s !== id);
        } else {
            if (this.selectedSeats.length < this.maxSeats) {
                this.selectedSeats.push(id);
            } else {
                alert('Maksimal pemesanan adalah 3 kursi');
            }
        }
    },
    get totalPrice() {
        return this.selectedSeats.length * this.pricePerSeat;
    },
    get    passengerBreakdown() {
        if (this.selectedSeats.length === 0) return 'Belum ada kursi';
        return this.selectedSeats.length + ' Penumpang';
    }
}">

<!-- Unified Compact Header -->
<div class="pt-16 bg-[#1e2a78] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 py-5 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
        <div class="flex items-center gap-4 sm:gap-6">
            <a href="{{ route('ticket.search') }}" class="p-2 hover:bg-white/10 rounded-xl transition border border-white/20 text-white flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="text-base sm:text-lg font-bold">Pilih Kursi</h2>
                <div class="flex items-center gap-2 sm:gap-3 text-blue-200 text-[10px] opacity-60">
                    <span class="font-bold">{{ $trip->origin->city }}</span>
                    <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    <span class="font-bold">{{ $trip->destination->city }}</span>
                </div>
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
    </div>
</div>

<!-- Main Content -->
<div class="bg-[#f8fafc] min-h-screen pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 py-6 sm:py-10 flex flex-col lg:flex-row gap-6 lg:gap-10 items-stretch lg:items-start">
        
        <!-- LEFT: BUS LAYOUT -->
        <div class="w-full lg:flex-1">
            <div class="bg-white rounded-3xl sm:rounded-[2.5rem] p-5 sm:p-10 shadow-xl shadow-blue-900/5 border border-gray-100">
                <!-- Legend -->
                <div class="flex flex-wrap justify-center items-center gap-4 sm:gap-10 mb-8 sm:mb-12 bg-gray-50 p-4 rounded-2xl">
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 sm:w-6 sm:h-6 rounded-lg bg-white border border-gray-200 shadow-sm flex-shrink-0"></div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-500">Tersedia</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 sm:w-6 sm:h-6 rounded-lg bg-[#f5a623] shadow-md shadow-orange-200 flex-shrink-0"></div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-700">Dipilih</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 sm:w-6 sm:h-6 rounded-lg bg-gray-300 flex-shrink-0"></div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-400">Terisi</span>
                    </div>
                </div>

                <div class="max-w-md mx-auto">
                    <!-- Bus Body Structure -->
                    <div class="relative bg-gray-100 border-[6px] sm:border-[10px] border-gray-200 rounded-t-[50px] sm:rounded-t-[80px] rounded-b-[30px] sm:rounded-b-[40px] p-6 sm:p-12 pt-20 sm:pt-24 shadow-inner">
                        <!-- Windshield Area -->
                        <div class="absolute top-0 left-0 right-0 h-16 sm:h-24 bg-gray-800 rounded-t-[44px] sm:rounded-t-[70px] flex items-center justify-center border-b-4 border-gray-700">
                            <div class="w-16 sm:w-20 h-1 bg-gray-600 rounded-full opacity-30"></div>
                        </div>

                        <!-- Steering Wheel -->
                        <div class="absolute top-6 sm:top-10 right-8 sm:right-14">
                            <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-full border-2 sm:border-4 border-gray-600 flex items-center justify-center">
                                <div class="w-4 sm:w-6 h-0.5 sm:h-1 bg-gray-600 rotate-45"></div>
                                <div class="w-4 sm:w-6 h-0.5 sm:h-1 bg-gray-600 -rotate-45"></div>
                            </div>
                        </div>

                        <!-- Entrance -->
                        <div class="absolute top-20 sm:top-28 left-0 w-1 sm:w-2 h-10 sm:h-16 bg-yellow-400 rounded-r-lg"></div>

                        <!-- Seat Grid -->
                        <div class="grid grid-cols-5 gap-y-3 sm:gap-y-4 gap-x-2 sm:gap-x-3 justify-items-center">
                            @php
                                $seatNum = 1;
                                $totalS = 39;
                                $rs = ceil($totalS / 4);
                            @endphp
                            
                            @for($r = 1; $r <= $rs + 1; $r++)
                                @for($c = 1; $c <= 5; $c++)
                                    @if($c == 3)
                                        <div class="w-10 sm:w-12 h-12 flex items-center justify-center">
                                            <span class="text-[9px] sm:text-[10px] font-bold text-gray-300 uppercase tracking-tighter">{{ $r }}</span>
                                        </div>
                                    @else
                                        @if($seatNum <= $totalS)
                                            @php $sId = $seatNum; @endphp
                                            <button 
                                                @click="toggleSeat({{ $sId }})"
                                                :class="{
                                                    'bg-gray-300 cursor-not-allowed border-gray-300': occupiedSeats.includes({{ $sId }}),
                                                    'bg-white border-gray-200 hover:border-blue-500 hover:shadow-lg hover:-translate-y-0.5': !occupiedSeats.includes({{ $sId }}) && !selectedSeats.includes({{ $sId }}),
                                                    'bg-[#f5a623] border-[#f5a623] text-white shadow-lg scale-105': selectedSeats.includes({{ $sId }})
                                                }"
                                                class="w-10 h-12 sm:w-12 sm:h-14 rounded-lg sm:rounded-xl flex flex-col items-center justify-center text-xs font-bold transition-all border sm:border-2 group relative"
                                            >
                                                <span :class="selectedSeats.includes({{ $sId }}) ? 'text-white' : 'text-gray-700'">{{ $seatNum++ }}</span>
                                                <!-- Seat Cushion Effect -->
                                                <div class="absolute bottom-1 w-6 sm:w-8 h-1 rounded-full bg-black/5"></div>
                                            </button>
                                        @else
                                            <div class="w-10 h-12 sm:w-12 sm:h-14"></div>
                                        @endif
                                    @endif
                                @endfor
                            @endfor
                        </div>
                    </div>
                    
                    <!-- Rear Engine Area -->
                    <div class="mt-4 bg-gray-300 h-8 sm:h-10 rounded-xl flex items-center justify-center gap-4">
                        <div class="w-10 sm:w-12 h-1 bg-gray-400 rounded-full"></div>
                        <div class="w-10 sm:w-12 h-1 bg-gray-400 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: SELECTION SUMMARY -->
        <div class="w-full lg:w-[400px] flex-shrink-0">
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl shadow-blue-900/5 border border-gray-100 lg:sticky lg:top-24">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center justify-between">
                    Ringkasan Kursi
                    <span class="text-xs bg-blue-50 text-blue-600 px-3 py-1 rounded-full" x-text="selectedSeats.length + '/3'"></span>
                </h3>

                <!-- Selected Seats Display -->
                <div class="space-y-4 mb-8">
                    <template x-if="selectedSeats.length === 0">
                        <div class="py-12 text-center border-2 border-dashed border-gray-100 rounded-2xl">
                            <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            <p class="text-sm text-gray-400 font-medium">Silakan pilih kursi Anda</p>
                        </div>
                    </template>
                    
                    <template x-for="(seat, index) in selectedSeats" :key="seat">
                        <div class="flex items-center justify-between p-4 bg-blue-50 rounded-2xl border border-blue-100 animate-fade-in-up">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-[#1e2a78] text-white rounded-xl flex items-center justify-center font-bold text-lg">
                                    <span x-text="seat"></span>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800" x-text="'Penumpang ' + (index + 1)"></p>
                                    <p class="text-[10px] text-blue-600 font-bold uppercase tracking-widest">{{ $trip->bus_class }} Class</p>
                                </div>
                            </div>
                            <button @click="toggleSeat(seat)" class="text-red-400 hover:text-red-600 p-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </template>
                </div>

                <!-- Price Detail -->
                <div class="bg-gray-50 rounded-2xl p-5 sm:p-6 mb-8 border border-gray-100">
                    <div class="flex justify-between items-center mb-4 text-xs sm:text-sm">
                        <span class="text-gray-500 font-medium">Total Penumpang</span>
                        <span class="font-bold text-gray-800" x-text="selectedSeats.length + ' Orang'"></span>
                    </div>
                    <div class="flex justify-between items-center mb-6 text-xs sm:text-sm">
                        <span class="text-gray-500 font-medium">Harga Per Kursi</span>
                        <span class="font-bold text-gray-800">Rp {{ number_format($trip->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-5 border-t border-gray-200">
                        <span class="font-bold text-gray-900 text-sm sm:text-base">Total Harga</span>
                        <span class="text-xl sm:text-2xl font-bold text-[#1e2a78]" x-text="'Rp ' + (totalPrice).toLocaleString('id-ID')"></span>
                    </div>
                </div>

                <!-- CTA -->
                <a 
                    :href="selectedSeats.length > 0 ? '{{ route('ticket.detail', $trip->id) }}?seats=' + selectedSeats.join(',') : '#'"
                    :class="selectedSeats.length > 0 ? 'bg-[#1e2a78] hover:bg-[#2d3a8c] shadow-lg shadow-blue-200' : 'bg-gray-300 cursor-not-allowed'"
                    class="flex items-center justify-center gap-3 w-full text-white font-bold py-4 sm:py-5 rounded-2xl text-sm transition-all group"
                >
                    Konfirmasi <span x-text="selectedSeats.length"></span> Kursi
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
                
                <p class="text-center text-[10px] text-gray-400 mt-4 font-medium uppercase tracking-widest">Aman & Terpercaya via JATIJAJAR</p>
            </div>
        </div>
    </div>
</div>

</div>

<style>
    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fade-in-up 0.3s ease-out forwards;
    }
</style>
@endsection
