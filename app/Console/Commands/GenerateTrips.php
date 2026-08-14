<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Trip;
use App\Models\Booking;
use Carbon\Carbon;

class GenerateTrips extends Command
{
    protected $signature = 'trips:generate-daily';
    protected $description = 'Keep a rolling 30-day schedule: generate missing future trips and soft-delete old ones';

    public function handle()
    {
        $today    = Carbon::today();
        $in30days = Carbon::today()->addDays(30);
        $created  = 0;

        // ------------------------------------------------------------------
        // Langkah 1: Temukan semua "template jadwal" yang unik
        // (kombinasi operator + rute + jam + kelas)
        // Kita ambil dari jadwal yang pernah ada dalam 7 hari terakhir
        // agar tetap punya referensi walau hari ini kosong.
        // ------------------------------------------------------------------
        $templateTrips = Trip::withTrashed()
            ->get()
            ->unique(function ($t) {
                return $t->operator_id . '-' . $t->origin_id . '-' . $t->destination_id
                    . '-' . $t->departure_time->format('H:i')
                    . '-' . $t->bus_class;
            });

        if ($templateTrips->isEmpty()) {
            $this->warn('Tidak ada template jadwal ditemukan. Pastikan minimal ada 1 jadwal yang dibuat manual terlebih dahulu.');
            return;
        }

        // ------------------------------------------------------------------
        // Langkah 2: Untuk setiap template, pastikan setiap hari dari
        // besok sampai 30 hari ke depan sudah terisi.
        // ------------------------------------------------------------------
        foreach ($templateTrips as $template) {
            $departureHour   = $template->departure_time->format('H');
            $departureMinute = $template->departure_time->format('i');
            $durationMinutes = $template->departure_time->diffInMinutes($template->arrival_time);

            for ($d = 1; $d <= 30; $d++) {
                $targetDeparture = $today->copy()
                    ->addDays($d)
                    ->setHour((int) $departureHour)
                    ->setMinute((int) $departureMinute)
                    ->setSecond(0);

                $targetArrival = $targetDeparture->copy()->addMinutes($durationMinutes);

                // Cek apakah sudah ada (termasuk yang soft-deleted)
                $exists = Trip::withTrashed()
                    ->where('operator_id', $template->operator_id)
                    ->where('origin_id', $template->origin_id)
                    ->where('destination_id', $template->destination_id)
                    ->where('bus_class', $template->bus_class)
                    ->whereDate('departure_time', $targetDeparture->toDateString())
                    ->exists();

                if (!$exists) {
                    $newTrip                  = $template->replicate();
                    $newTrip->departure_time  = $targetDeparture;
                    $newTrip->arrival_time    = $targetArrival;
                    $newTrip->available_seats = $template->available_seats; // kursi penuh
                    $newTrip->deleted_at      = null; // pastikan tidak soft-deleted
                    $newTrip->save();
                    $created++;
                }
            }
        }

        $this->info("✅ {$created} jadwal baru berhasil dibuat (rolling 30 hari ke depan).");

        // ------------------------------------------------------------------
        // Langkah 3: Soft-delete jadwal yang sudah >30 hari berlalu
        // Data booking tetap aman karena hanya soft-delete.
        // ------------------------------------------------------------------
        $cutoff  = $today->copy()->subDays(30);
        $deleted = Trip::whereDate('departure_time', '<', $cutoff)->delete(); // soft delete

        if ($deleted > 0) {
            $this->info("🗂  {$deleted} jadwal lama (>30 hari) diarsipkan (soft-delete).");
        }
    }
}
