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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->enum('vehicle_type', ['car', 'motorcycle'])->default('car');
            $table->string('model');
            $table->string('plate_number')->unique();
            $table->year('year');
            $table->string('color');
            $table->decimal('daily_rate', 12, 2);
            $table->enum('status', ['available', 'rented', 'maintenance'])->default('available');
            $table->string('image_front')->nullable();
            $table->string('image_side')->nullable();
            $table->string('image_interior')->nullable();
            $table->string('image_engine')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
