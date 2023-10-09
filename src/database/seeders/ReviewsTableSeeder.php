<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reviews')->insert([
        'user_id' => 1,
        'shop_id' => 1,
        'rating' => 5,
        'comment' => 'おいしかった',
        ]);

        DB::table('reviews')->insert([
        'user_id' => 2,
        'shop_id' => 1,
        'rating' => 4,
        'comment' => 'ssssssasasa',
        ]);

        DB::table('reviews')->insert([
        'user_id' => 3,
        'shop_id' => 1,
        'rating' => 3,
        'comment' => 'sdsadwsaaaaaaaaaaaaaadd',
        ]);

        DB::table('reviews')->insert([
        'user_id' => 4,
        'shop_id' => 1,
        'rating' => 2,
        'comment' => 'えええええええええええええええええええええええええええ',
        ]);
    
        DB::table('reviews')->insert([
        'user_id' => 5,
        'shop_id' => 1,
        'rating' => 1,
        'comment' => 'ggggggggggggggggggggggggfffffffffffff',
        ]);
    }
}