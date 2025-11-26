<?php

namespace Database\Factories\Catalog;

use App\Models\Catalog\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catalog\Brand>
 */
class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        $name = ucwords($this->faker->words(2, true));

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'is_visible' => true,
            'website' => 'https://www.' . Str::slug($name) . '.com',
            'description' => $this->faker->paragraph(),
        ];
    }
}
