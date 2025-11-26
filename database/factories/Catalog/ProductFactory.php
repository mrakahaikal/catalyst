<?php

namespace Database\Factories\Catalog;

use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catalog\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = ucwords($this->faker->words(3, true));

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . Str::lower(Str::random(5)),
            'description' => $this->faker->paragraph(3),
            'price' => $this->faker->numberBetween(10, 1000) * 1000,
            'stock' => 0,
            'has_variants' => false,
            'is_visible' => true,
        ];
    }
}
