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
            $Schema->string('merchant_ref')->unique()->index();
            $Schema->foreignId('user_id')->constrained('users');
            $Schema->foreignId('driver_id')->nullable()->constrained('drivers')->onDelete('set null');
            $Schema->string('NIK')->nullable();
            $Schema->foreignId('vehicle_id')->constrained('vehicles');
            $Schema->dateTime('rental_date');
            $Schema->dateTime('return_date_scheduled');
            $Schema->integer('duration')->default(1);
            $Schema->decimal('total_price', 12, 2)->default(0);
            $Schema->decimal('amount_paid', 12, 2)->default(0);
            $Schema->enum('status', ['pending', 'ongoing', 'completed', 'cancelled'])->default('ongoing');
            $Schema->boolean('with_driver')->default(0);
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
