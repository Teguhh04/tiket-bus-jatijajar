<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 0. Seed Users
        \DB::table('users')->insert([
            [
                'name' => 'Administrator',
                'email' => 'admin@jatijajar.com',
                'password' => \Hash::make('password'),
                'role' => 'admin',
                'phone' => '081234567890',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'User Biasa',
                'email' => 'user@gmail.com',
                'password' => \Hash::make('password'),
                'role' => 'customer',
                'phone' => '089876543210',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        $userId = \DB::table('users')->where('email', 'user@gmail.com')->value('id');

        // 1. Seed Terminals
        $JATIJAJARId = \DB::table('terminals')->insertGetId([
            'name' => 'Terminal Jatijajar', 
            'city' => 'Depok', 
            'address' => 'Jl. Raya Bogor, Jatijajar, Kec. Tapos, Kota Depok, Jawa Barat',
            'created_at' => now(), 
            'updated_at' => now()
        ]);
        
        $destinations = [
            'Purwokerto' => 'Jl. Suwatio No.3, Teluk, Kec. Purwokerto Sel., Kabupaten Banyumas',
            'Klaten' => 'Jl. Bima, Buntalan, Kec. Klaten Tengah, Kabupaten Klaten',
            'Tegal' => 'Jl. Dr. Wahidin Sudirohusodo, Pesurungan Kidul, Kota Tegal',
            'Pekalongan' => 'Jl. Dr. Sutomo, Baros, Kec. Pekalongan Tim., Kota Pekalongan',
            'Semarang' => 'Jl. Terminal Terboyo, Terboyo Wetan, Genuk, Kota Semarang',
            'Solo' => 'Jl. A. Yani, Gilingan, Kec. Banjarsari, Kota Surakarta, Jawa Tengah',
            'Wonogiri' => 'Jl. Wonogiri-Ponorogo, Purworejo, Kec. Wonogiri, Kabupaten Wonogiri',
            'Yogyakarta' => 'Jl. Imogiri Tim. No.163, Giwangan, Umbulharjo, Kota Yogyakarta',
            'Madiun' => 'Jl. Basuki Rahmat No.1, Purbayan, Kec. Madiun, Kota Madiun',
            'Surabaya' => 'Jl. Letjen Sutoyo No.136, Medaeng, Kec. Waru, Kabupaten Sidoarjo',
            'Malang' => 'Jl. Raden Intan No.1, Arjosari, Kec. Blimbing, Kota Malang',
            'Karanganyar' => 'Jl. Lawu, Popongan, Kec. Karanganyar, Kabupaten Karanganyar',
            'Ponorogo' => 'Jl. Arif Rahman Hakim, Keniten, Kec. Ponorogo, Kabupaten Ponorogo',
            'Ngawi' => 'Jl. Ir. Soekarno, Grudo, Kec. Ngawi, Kabupaten Ngawi',
            'Kediri' => 'Jl. Semeru, Tamanan, Kec. Mojoroto, Kota Kediri',
            'Tulungagung' => 'Jl. Pahlawan, Kedungwaru, Kec. Kedungwaru, Kabupaten Tulungagung',
            'Blitar' => 'Jl. Kenari, Plosokerep, Sananwetan, Kota Blitar',
            'Magetan' => 'Jl. Raya Maospati, Maospati, Kabupaten Magetan',
            'Kudus' => 'Jl. AKBP Agil Kusumadya, Jati Wetan, Jati, Kabupaten Kudus',
            'Jepara' => 'Jl. Pemuda, Panggang, Kec. Jepara, Kabupaten Jepara',
            'Pati' => 'Jl. P. Sudirman, Pati Wetan/Kampung, Pati, Kabupaten Pati',
            'Madura' => 'Jl. Raya Tlanakan, Tlanakan, Kabupaten Pamekasan'
        ];
        
        $terminalIds = [];
        foreach ($destinations as $dest => $address) {
            $terminalIds[$dest] = \DB::table('terminals')->insertGetId([
                'name' => 'Terminal ' . $dest,
                'city' => $dest,
                'address' => $address,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // 2. Seed Operators & Trips
        $rawPos = [
            ['name' => 'Sinar Jaya', 'domain' => 'sinarjayagroup.co.id', 'logo' => 'images/operators/sinar_jaya.png', 'destinations' => ['Purwokerto', 'Klaten', 'Tegal', 'Pekalongan'], 'facilities' => ['AC', 'Reclining Seat (2-2)', 'Leg Rest', 'Toilet'], 'price' => 250000, 'time' => '13:00:00'],
            ['name' => 'Agra Mas', 'domain' => 'agramasgroup.com', 'logo' => 'images/operators/agra_mas.png', 'destinations' => ['Semarang', 'Solo', 'Wonogiri', 'Yogyakarta'], 'facilities' => ['AC', 'Leg Rest', 'LCD TV', 'Makan', 'Toilet'], 'price' => 275000, 'time' => '14:30:00'],
            ['name' => 'Rosalia Indah', 'domain' => 'rosalia-indah.co.id', 'logo' => 'images/operators/rosalia_indah.png', 'destinations' => ['Solo', 'Madiun', 'Surabaya', 'Malang'], 'facilities' => ['AC', 'Leg Rest', 'Selimut & Bantal', 'Makan'], 'price' => 320000, 'time' => '15:00:00'],
            ['name' => 'Putra Mulya', 'domain' => 'putramulya.co.id', 'logo' => 'images/operators/putra_mulya.png', 'destinations' => ['Solo', 'Karanganyar', 'Ponorogo'], 'facilities' => ['AC', 'USB Port', 'Snack', 'Leg Rest'], 'price' => 260000, 'time' => '16:00:00'],
            ['name' => 'Harapan Jaya', 'domain' => 'poharapanjaya.com', 'logo' => 'images/operators/harapan_jaya.png', 'destinations' => ['Ngawi', 'Kediri', 'Tulungagung', 'Blitar'], 'facilities' => ['AC', 'Audio Video On Demand', 'Toilet'], 'price' => 290000, 'time' => '16:30:00'],
            ['name' => 'Lorena', 'domain' => 'lorena-transport.com', 'logo' => 'images/operators/lorena.png', 'destinations' => ['Semarang', 'Surabaya', 'Blitar'], 'facilities' => ['AC', 'Makan', 'Toilet', 'Kursi Nyaman'], 'price' => 310000, 'time' => '17:00:00'],
            ['name' => 'Sudiro Tungga Jaya', 'domain' => 'sudirotunggajaya.com', 'logo' => 'images/operators/sudiro_tungga_jaya.png', 'destinations' => ['Magetan', 'Madiun', 'Ponorogo'], 'facilities' => ['AC', 'USB Charger', 'Snack', 'Full Music'], 'price' => 280000, 'time' => '17:30:00'],
            ['name' => 'Gunung Harta', 'domain' => 'gunungharta.com', 'logo' => 'images/operators/gunung_harta.png', 'destinations' => ['Semarang', 'Solo', 'Surabaya', 'Malang'], 'facilities' => ['AC', 'Toilet', 'Smoking Area', 'Makan'], 'price' => 340000, 'time' => '14:00:00'],
            ['name' => 'Haryanto', 'domain' => 'poharyanto.co.id', 'logo' => 'images/operators/haryanto.png', 'destinations' => ['Kudus', 'Jepara', 'Pati', 'Madura'], 'facilities' => ['AC', 'Leg Rest', 'Sholat Berjamaah di Rest Area'], 'price' => 270000, 'time' => '18:00:00'],
            ['name' => 'Shantika', 'domain' => 'poshantika.co.id', 'logo' => 'images/operators/shantika.png', 'destinations' => ['Jepara', 'Kudus', 'Pati'], 'facilities' => ['AC', 'Power Outlet', 'Bantal', 'Selimut'], 'price' => 260000, 'time' => '18:30:00'],
        ];

        $tripIds = [];

        foreach ($rawPos as $po) {
            $operatorId = \DB::table('operators')->insertGetId([
                'name' => $po['name'],
                'domain' => $po['domain'],
                'logo_url' => $po['logo'],
                'rating' => mt_rand(40, 50) / 10,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            foreach ($po['destinations'] as $index => $dest) {
                if (isset($terminalIds[$dest])) {
                    // Depok -> City
                    for ($d = 0; $d < 5; $d++) { // create trips for next 5 days
                        $depTime = \Carbon\Carbon::parse(date('Y-m-d') . ' ' . $po['time'])->addDays($d);
                        $arrTime = clone $depTime;
                        $arrTime->addHours(mt_rand(8, 14));
                        
                        $durationHours = $arrTime->diffInHours($depTime);
                        $durationMins = $arrTime->diffInMinutes($depTime) % 60;
                        $durationStr = $durationHours . 'j ' . $durationMins . 'm';

                        $tripIds[] = \DB::table('trips')->insertGetId([
                            'operator_id' => $operatorId,
                            'origin_id' => $JATIJAJARId,
                            'destination_id' => $terminalIds[$dest],
                            'bus_class' => 'Executive',
                            'facilities' => json_encode($po['facilities']),
                            'departure_time' => $depTime,
                            'arrival_time' => $arrTime,
                            'duration' => $durationStr,
                            'price' => $po['price'] + ($index * 2000),
                            'available_seats' => 39,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);

                    }
                }
            }
        }

        // 3. Seed some Bookings
        for ($i = 0; $i < 20; $i++) {
            $tripId = $tripIds[array_rand($tripIds)];
            $ticketCode = strtoupper(uniqid('JTJ-'));
            
            $bookingId = \DB::table('bookings')->insertGetId([
                'ticket_code' => $ticketCode,
                'user_id' => $userId,
                'trip_id' => $tripId,
                'total_passengers' => 1,
                'ticket_price' => 300000,
                'admin_fee' => 5000,
                'total_amount' => 305000,
                'payment_method' => 'bank_transfer',
                'status' => 'lunas',
                'created_at' => now()->subDays(mt_rand(1, 30)),
                'updated_at' => now()
            ]);

            \DB::table('passengers')->insert([
                'booking_id' => $bookingId,
                'name' => 'Passenger ' . $i,
                'phone' => '0812345678' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'nik' => '123456789012345' . ($i % 10),
                'seat_number' => (string) mt_rand(1, 39),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
