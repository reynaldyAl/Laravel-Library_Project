<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->updateOrInsert(
            ['id' => 1],
            [
                'name' => 'User One',
                'email' => 'userone@example.com',
                'password' => Hash::make('password')
            ]
        );

        DB::table('users')->updateOrInsert(
            ['id' => 2],
            [
                'name' => 'User Two',
                'email' => 'usertwo@example.com',
                'password' => Hash::make('password')
            ]
        );

        DB::table('users')->updateOrInsert(
            ['id' => 3],
            [
                'name' => 'User Three',
                'email' => 'userthree@example.com',
                'password' => Hash::make('password')
            ]
        );

        // Tambahkan pengguna lain sesuai kebutuhan
    }
}