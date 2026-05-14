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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique()->index();
            $table->string('merchant_ref')->unique()->index();
            $table->foreignId('rental_id')->constrained('rentals')->onDelete('cascade');
            $table->decimal('total_bill', 12, 2);
            $table->decimal('amount', 12, 2);
            $table->enum('payment_type', ['dp', 'full', 'repayment'])->default('full');
            $table->decimal('fee_amount', 12, 2)->default(0);
            $table->decimal('net_amount', 12, 2)->default(0);
            $table->string('payment_method');
            $table->string('payment_name');
            $table->enum('status', ['unpaid', 'paid', 'expired', 'failed', 'refund'])->default('unpaid');
            $table->string('checkout_url')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
