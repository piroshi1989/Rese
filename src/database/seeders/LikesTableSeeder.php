<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class likesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('likes')->insert([
        'user_id' => 1,
        'shop_id' => 1,
        ]);

        DB::table('likes')->insert([
        'user_id' => 1,
        'shop_id' => 2,
        ]);

        DB::table('likes')->insert([
        'user_id' => 1,
        'shop_id' => 3,
        ]);

        DB::table('likes')->insert([
        'user_id' => 1,
        'shop_id' => 4,
        ]);

        DB::table('likes')->insert([
        'user_id' => 1,
        'shop_id' => 5,
        ]);

        DB::table('likes')->insert([
        'user_id' => 1,
        'shop_id' => 6,
        ]);
    }
}