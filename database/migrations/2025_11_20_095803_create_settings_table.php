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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group'); // Kelompok setting, misal: 'general', 'payment', 'social'
            $table->string('key')->unique(); // Misal: 'shop_name', 'shop_logo', 'tax_rate'
            $table->text('value')->nullable(); // Isinya bisa text biasa, atau path gambar
            $table->string('type')->default('text'); // 'text', 'boolean', 'image', 'json' (buat render input field yang pas di Filament)
            $table->boolean('is_locked')->default(false); // Kalau true, cuma Super Admin yang bisa hapus
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
