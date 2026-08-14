<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Booking;
use App\Models\Trip;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Task Scheduler for Auto-Canceling Expired Bookings
Schedule::call(function () {
    $expiredBookings = Booking::where('status', 'pending')
        ->where('created_at', '<', now()->subMinutes(30))
        ->get();

    foreach ($expiredBookings as $booking) {
        $booking->update(['status' => 'batal']);
        
        // Return available seats
        $trip = Trip::find($booking->trip_id);
        if ($trip) {
            $trip->increment('available_seats', $booking->total_passengers);
        }
    }
})->everyMinute();

// Task Scheduler for Auto Generating Trips (Runs daily at midnight)
Schedule::command('trips:generate-daily')->daily();
