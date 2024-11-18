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
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role_id' => 1, // admin
            ]
        );

        DB::table('users')->updateOrInsert(
            ['id' => 2],
            [
                'name' => 'Staff User',
                'email' => 'staff@example.com',
                'password' => Hash::make('password'),
                'role_id' => 2, // staff
            ]
        );

        DB::table('users')->updateOrInsert(
            ['id' => 3],
            [
                'name' => 'Mahasiswa User',
                'email' => 'mahasiswa@example.com',
                'password' => Hash::make('password'),
                'role_id' => 3, // mahasiswa
            ]
        );

        // Tambahkan pengguna lain sesuai kebutuhan
    }
}