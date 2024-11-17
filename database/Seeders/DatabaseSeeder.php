<?php

namespace Database\Seeders;

use App\Models\LoanStatus;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        LoanStatus::create([
            'name' => 'borrowed',
            'description' => 'Loan application is borrowed',
        ]);
        LoanStatus::create([
            'name' => 'returned',
            'description' => 'Loan application is returned',
        ]);
        LoanStatus::create([
            'name' => 'overdue',
            'description' => 'Loan application is overdue',
        ]);
    }
}
