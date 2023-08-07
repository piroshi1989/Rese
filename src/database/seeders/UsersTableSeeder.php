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
            'name' => 'user1',
            'email' => 'a@gmail.com',
            'email_verified_at' =>  now(),
            'password' => Hash::make('password'),
            'role' => 0,
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'b@gmail.com',
            'email_verified_at' =>  now(),
            'shop_id' => 1,
            'password' => Hash::make('password'),
            'role' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'superadmin',
            'email' => 'c@gmail.com',
            'email_verified_at' =>  now(),
            'password' => Hash::make('password'),
            'role' => 2,
        ]);
    }
}