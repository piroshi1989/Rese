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
        'alphabet_name' => 'italian',
        ]);

      DB::table('genres')->insert([
        'name' => 'ラーメン',
        'alphabet_name' => 'ramen',
        ]);

      DB::table('genres')->insert([
        'name' => '居酒屋',
        'alphabet_name' => 'izakaya',
        ]);

        DB::table('genres')->insert([
        'name' => '寿司',
        'alphabet_name' => 'sushi',
        ]);

        DB::table('genres')->insert([
        'name' => '焼肉',
        'alphabet_name' => 'yakiniku',
        ]);
    }
}