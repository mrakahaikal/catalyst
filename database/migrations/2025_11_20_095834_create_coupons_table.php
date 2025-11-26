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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Misal: "RAMADHAN2025"
            $table->enum('type', ['fixed', 'percent'])->default('fixed'); // Potongan Rp 10rb atau 10%
            $table->decimal('value', 12, 2); // Nilai potongannya

            // Batasan (Validation Rules)
            $table->decimal('min_spend', 12, 2)->nullable(); // Minimal belanja
            $table->integer('usage_limit')->nullable(); // Max dipakai berapa kali (global)
            $table->integer('usage_limit_per_user')->nullable(); // 1 user max 1 kali

            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
