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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('cart_id')->constrained('carts')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('sku_id')->nullable()->constrained('skus'); // Nullable jika produk simple
            $table->integer('quantity')->default(1);
            $table->json('options')->nullable(); // Snapshot nama varian ("Warna: Merah") untuk display cepat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
