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
        Schema::create('payments', function (Blueprint $Schema) {
            $Schema->id();
            $Schema->foreignId('rental_id')->constrained()->onDelete('cascade');
            $Schema->dateTime('payment_date');
            $Schema->decimal('amount', 15, 2);
            $Schema->string('payment_method');
            $Schema->string('payment_status')->default('success');
            $Schema->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
