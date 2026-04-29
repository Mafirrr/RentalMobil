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
        Schema::create('rentals', function (Blueprint $Schema) {
            $Schema->id();
            $Schema->foreignId('user_id')->constrained('users');
            $Schema->foreignId('car_id')->constrained('cars');
            $Schema->dateTime('rental_date');
            $Schema->dateTime('return_date_scheduled');
            $Schema->dateTime('return_date_actual')->nullable();
            $Schema->decimal('total_price', 15, 2)->default(0);
            $Schema->enum('status', ['pending', 'ongoing', 'completed', 'cancelled'])->default('pending');
            $Schema->timestamps();
            $Schema->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
