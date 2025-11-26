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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('payment_gateway'); // "midtrans", "stripe"
            $table->string('transaction_id'); // ID dari gateway
            $table->string('payment_type'); // "credit_card", "gopay"
            $table->decimal('amount', 12, 2);
            $table->string('status'); // Status mentah dari gateway
            $table->json('payload')->nullable(); // Simpan response JSON lengkap buat debugging
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
