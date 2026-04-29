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
        Schema::create('cars', function (Blueprint $Schema) {
            $Schema->id();
            $Schema->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $Schema->string('model');
            $Schema->string('plate_number')->unique();
            $Schema->integer('capacity');
            $Schema->year('year');
            $Schema->string('color');
            $Schema->decimal('daily_rate', 12, 2);
            $Schema->enum('status', ['available', 'rented', 'maintenance'])->default('available');
            $Schema->enum('transmission', ['Manual', 'Automatic'])->default('Manual');
            $Schema->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
