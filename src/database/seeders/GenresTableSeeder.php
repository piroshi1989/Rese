<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('genres')->insert([
        'name' => 'イタリアン',
        'romaji_name' => 'italian',
        ]);

      DB::table('genres')->insert([
        'name' => 'ラーメン',
        'romaji_name' => 'ramen',
        ]);

      DB::table('genres')->insert([
        'name' => '居酒屋',
        'romaji_name' => 'izakaya',
        ]);

        DB::table('genres')->insert([
        'name' => '寿司',
        'romaji_name' => 'sushi',
        ]);

        DB::table('genres')->insert([
        'name' => '焼肉',
        'romaji_name' => 'yakiniku',
        ]);
    }
}