<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminPasswordSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')
            ->where('email', 'admin@jatijajar.com')
            ->update([
                'password' => Hash::driver('argon2id')->make('password'),
                'updated_at' => now(),
            ]);
    }
}
