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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('order_number')->unique(); // Generate: ORD-2024-0001
            // Status Management
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['unpaid', 'paid', 'failed', 'refunded'])->default('unpaid');
            $table->enum('shipping_status', ['pending', 'shipped', 'delivered'])->default('pending');
            // Financial Snapshot
            $table->string('currency')->default('IDR');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('shipping_price', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2); // subtotal + tax + shipping - discount
            // Shipping & Payment Info
            $table->string('shipping_method')->nullable(); // "JNE - REG"
            $table->string('payment_method')->nullable(); // "bank_transfer", "credit_card"
            $table->text('notes')->nullable();
            // Address Snapshot (JSON lebih aman daripada relasi ID yang bisa dihapus user)
            $table->json('shipping_address');
            $table->json('billing_address')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
