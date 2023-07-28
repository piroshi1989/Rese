<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        'name' => 'user',
        'email' => 'a@gmail.com',
        'password' => Hash::make('password'),
        'created_at' => '2020-01-01 00:00:00',
        'updated_at' => '2020-01-01 00:00:00',
        ]);
    }
}