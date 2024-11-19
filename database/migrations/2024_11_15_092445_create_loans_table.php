<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('book_id')->nullable()->constrained('books')->nullOnDelete();
            $table->date('loan_date');
            $table->date('return_date')->nullable();
            $table->date('due_date')->nullable();
            $table->foreignId('loan_status_id')->nullable()->constrained('loan_statuses')->nullOnDelete();
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_returned')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};