<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reservations')->insert([
        'user_id' => 1,
        'shop_id' => 1,
        'date' => '2021-04-01',
        'time' => '18:00:00',
        'number' => 2,
        ]);

        DB::table('reservations')->insert([
        'user_id' => 1,
        'shop_id' => 2,
        'date' => '2024-04-01',
        'time' => '18:00:00',
        'number' => 2,
        ]);

        DB::table('reservations')->insert([
        'user_id' => 1,
        'shop_id' => 20,
        'date' => '2025-04-01',
        'time' => '18:00:00',
        'number' => 2,
        ]);

        DB::table('reservations')->insert([
        'user_id' => 1,
        'shop_id' => 1,
        'date' => '2020-04-01',
        'time' => '18:00:00',
        'number' => 2,
        ]);
    }
}