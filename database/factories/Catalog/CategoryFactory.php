<?php

namespace Database\Factories\Catalog;

use App\Models\Catalog\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catalog\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $categories = [
            'Electronics', 'Fashion', 'Home & Living',
            'Books', 'Health & Beauty', 'Automotive',
            'Toys & Hobbies', 'Groceries', 'Sports'
        ];

        // Ambil random, tapi unik biar gak ada kategori kembar
        $name = $this->faker->unique()->randomElement($categories);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'is_visible' => true,
            'description' => $this->faker->sentence(),
        ];
    }
}
