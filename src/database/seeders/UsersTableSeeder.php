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
            'name' => 'user2',
            'email' => 'b@gmail.com',
            'email_verified_at' =>  now(),
            'password' => Hash::make('password'),
            'role' => 0,
        ]);

        DB::table('users')->insert([
            'name' => 'user3',
            'email' => 'c@gmail.com',
            'email_verified_at' =>  now(),
            'password' => Hash::make('password'),
            'role' => 0,
        ]);

        DB::table('users')->insert([
            'name' => 'user4',
            'email' => 'd@gmail.com',
            'email_verified_at' =>  now(),
            'password' => Hash::make('password'),
            'role' => 0,
        ]);

        DB::table('users')->insert([
            'name' => 'user5',
            'email' => 'e@gmail.com',
            'email_verified_at' =>  now(),
            'password' => Hash::make('password'),
            'role' => 0,
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'f@gmail.com',
            'email_verified_at' =>  now(),
            'shop_id' => 1,
            'password' => Hash::make('password'),
            'role' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'superadmin',
            'email' => 'g@gmail.com',
            'email_verified_at' =>  now(),
            'password' => Hash::make('password'),
            'role' => 2,
        ]);
    }
}