<?php

namespace Database\seeders;

use Illuminate\Database\seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'Fiction'],
            ['id' => 2, 'name' => 'Non-Fiction'],
            ['id' => 3, 'name' => 'Science Fiction'],
            // Tambahkan kategori lain sesuai kebutuhan
        ]);
    }
}