<?php

namespace Database\Seeders;

use App\Models\Catalog\Brand;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Models\Catalog\ProductOption;
use App\Models\Catalog\ProductOptionValue;
use App\Models\Catalog\Sku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Master Data
        $categories = Category::factory(5)->create();
        $brands = Brand::factory(5)->create();

        // 2. Skenario A: Produk Simple (Tanpa Varian)
        // Misal: Topi, Tas (All Size)
        Product::factory(5)->create([
            'has_variants' => false,
            'stock' => 100,
            'sku' => function() { return 'SMPL-' . strtoupper(uniqid()); }
        ])->each(function ($product) use ($categories, $brands) {
            $product->brand()->associate($brands->random())->save();
            $product->categories()->attach($categories->random(1));
        });

        // 3. Skenario B: Produk Kompleks (Punya Varian Warna & Size)
        // Kita bikin 3 produk yang punya varian
        Product::factory(3)->create([
            'has_variants' => true,
            'stock' => 0, // Stock ikut SKU
        ])->each(function ($product) use ($categories, $brands) {

            $product->brand()->associate($brands->random())->save();
            $product->categories()->attach($categories->random(2)); // Masuk 2 kategori

            // A. Buat Opsi (Sumbu X dan Y)
            $optionColor = ProductOption::create([
                'product_id' => $product->id,
                'name' => 'Color',
                'visual_type' => 'color_swatch'
            ]);

            $optionSize = ProductOption::create([
                'product_id' => $product->id,
                'name' => 'Size',
                'visual_type' => 'text'
            ]);

            // B. Buat Nilai Opsi
            // Warna: Merah & Biru
            $red = ProductOptionValue::create(['product_option_id' => $optionColor->id, 'label' => 'Red', 'value' => '#FF0000']);
            $blue = ProductOptionValue::create(['product_option_id' => $optionColor->id, 'label' => 'Blue', 'value' => '#0000FF']);

            // Size: S, M, L
            $sizeS = ProductOptionValue::create(['product_option_id' => $optionSize->id, 'label' => 'S', 'value' => null]);
            $sizeM = ProductOptionValue::create(['product_option_id' => $optionSize->id, 'label' => 'M', 'value' => null]);
            $sizeL = ProductOptionValue::create(['product_option_id' => $optionSize->id, 'label' => 'L', 'value' => null]);

            // C. GENERATE SKU (Cartesian Product)
            // Kombinasi: [Red, Blue] x [S, M, L] = 6 SKU
            $colors = [$red, $blue];
            $sizes = [$sizeS, $sizeM, $sizeL];

            foreach ($colors as $color) {
                foreach ($sizes as $size) {

                    // 1. Buat Fisik SKU
                    $sku = Sku::create([
                        'product_id' => $product->id,
                        'code' => strtoupper(substr($product->name, 0, 3)) . '-' . $color->label[0] . '-' . $size->label, // Ex: KAO-R-S
                        'price' => $product->price + (rand(0, 1) ? 5000 : 0), // Iseng nambah harga random buat varian tertentu
                        'stock' => rand(10, 50),
                    ]);

                    // 2. Attach Pivot (sku_values)
                    // Ini yang bikin sistem tahu kalau SKU ini adalah "Merah" DAN "S"
                    $sku->values()->attach([$color->id, $size->id]);
                }
            }
        });
    }
}
