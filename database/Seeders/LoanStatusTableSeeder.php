<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LoanStatus;

class LoanStatusTableSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            ['name' => 'waiting', 'description' => 'Loan application is waiting for approval'],
            ['name' => 'borrowed', 'description' => 'Loan application is borrowed'],
            ['name' => 'returned', 'description' => 'Loan application is returned'],
            ['name' => 'overdue', 'description' => 'Loan application is overdue'],
            ['name' => 'rejected', 'description' => 'Loan application is rejected'],
        ];

        foreach ($statuses as $status) {
            LoanStatus::updateOrCreate(['name' => $status['name']], $status);
        }
    }
}