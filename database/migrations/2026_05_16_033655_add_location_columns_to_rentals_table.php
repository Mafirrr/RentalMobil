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
        Schema::table('rentals', function (Blueprint $table) {
            $table->string('pickup_location')->nullable()->after('vehicle_id');
            $table->string('deliver_to_location')->nullable()->after('pickup_location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menambahkan kolom setelah kolom vehicle_id atau sesuaikan dengan kebutuhan Anda
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn(['pickup_location', 'deliver_to_location']);
        });
    }
};
