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
        Schema::create('return_cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->constrained('rentals');
            $table->dateTime('return_date');
            $table->string('car_condition');
            $table->decimal('payment_penalty', 12, 2)->default(0.0);
            $table->text('admin_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_cars');
    }
};
