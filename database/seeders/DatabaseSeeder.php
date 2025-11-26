<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Catalyst',
            'email' => 'admin@catalyst.test',
            'password' => bcrypt('password'), // Password default
            'email_verified_at' => now(),
        ]);

        $this->call([
            ProductSeeder::class,
        ]);
    }
}
