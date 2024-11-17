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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); 
            $table->foreignId('book_id')->constrained('books')->cascadeOnDelete(); 
            $table->date('reservation_date')->nullable(false); // Required reservation date
            $table->foreignId('status_id')->constrained('reservation_statuses')->cascadeOnDelete(); // Foreign key to reservation statuses
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
