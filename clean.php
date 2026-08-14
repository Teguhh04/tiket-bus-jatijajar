<?php
$depokTerminals = \Illuminate\Support\Facades\DB::table('terminals')->where('city', 'Depok')->pluck('id')->toArray();

// Find trips where destination is Depok
$tripIds = \Illuminate\Support\Facades\DB::table('trips')->whereIn('destination_id', $depokTerminals)->pluck('id')->toArray();

if (count($tripIds) > 0) {
    // Delete passengers associated with bookings of these trips
    $bookingIds = \Illuminate\Support\Facades\DB::table('bookings')->whereIn('trip_id', $tripIds)->pluck('id')->toArray();
    if (count($bookingIds) > 0) {
        \Illuminate\Support\Facades\DB::table('passengers')->whereIn('booking_id', $bookingIds)->delete();
        // Delete bookings
        \Illuminate\Support\Facades\DB::table('bookings')->whereIn('trip_id', $tripIds)->delete();
    }
    // Delete the trips
    \Illuminate\Support\Facades\DB::table('trips')->whereIn('id', $tripIds)->delete();
}

echo "Deleted " . count($tripIds) . " return trips.\n";
