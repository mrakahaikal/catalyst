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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->nullable()->unique(); // SKU induk (jika tidak ada varian)
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2); // Harga display
            $table->decimal('compare_at_price', 12, 2)->nullable(); // Harga coret (diskon)
            $table->decimal('cost_price', 12, 2)->nullable(); // HPP (untuk laporan profit internal)
            $table->integer('stock')->default(0); // Stok global (jika tidak ada varian)
            $table->boolean('is_visible')->default(true);
            $table->boolean('has_variants')->default(false);
            $table->enum('product_type', ['physical', 'digital'])->default('physical');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
