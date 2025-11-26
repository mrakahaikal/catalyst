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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete(); // Null jika produk dihapus
            $table->foreignId('sku_id')->nullable()->constrained('skus')->nullOnDelete();
            // Product Snapshot (PENTING)
            $table->string('product_name'); // Simpan nama saat beli
            $table->string('variant_name')->nullable(); // "Red / XL"
            $table->decimal('unit_price', 12, 2); // Harga saat beli
            $table->integer('quantity');
            $table->decimal('total_price', 12, 2); // unit_price * quantity
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
