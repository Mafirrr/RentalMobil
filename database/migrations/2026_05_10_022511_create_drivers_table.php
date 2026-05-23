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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 15)->unique();
            $table->text('address');
            $table->string('avatar_path')->nullable();
            $table->string('license_number', 50)->unique();
            $table->enum('license_type', ['A', 'B1', 'B2', 'C', 'Internasional']);
            $table->date('license_expired');
            $table->string('license_image_path')->nullable();
            $table->enum('status', ['available', 'assigned', 'off', 'suspended'])->default('available');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
