<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*=============================================
            CREAMOS 3 CATEGORÍAS
        =============================================*/
        Category::factory()->count(1)->create([
            'category_name' => 'Postres',
            'category_slug' => Str::slug('postres' . '-' . Str::random(5), '-')
        ]);
        Category::factory()->count(1)->create([
            'category_name' => 'Panadería',
            'category_slug' => Str::slug('panaderia' . '-' . Str::random(5), '-')
        ]);
        Category::factory()->count(1)->create([
            'category_name' => 'Bebidas',
            'category_slug' => Str::slug('bebidas' . '-' . Str::random(5), '-')
        ]);

        /*=============================================
           CREAMOS 5 PRODUCTOS
       =============================================*/
        Product::factory()->count(1)->create([
            'product_name' => 'Postre Tiramisu',
            'picture' => '/images/postre-tiramisu.png',
            'product_category_id' => 1,
            'product_slug' => Str::slug('postre-tiramisu' . '-' . Str::random(5), '-')
        ]);
        Product::factory()->count(1)->create([
            'product_name' => 'Postre de Maracuyá',
            'product_category_id' => 1,
            'picture' => '/images/postre-de-maracuya.png',
            'product_slug' => Str::slug('postre-maracuya' . '-' . Str::random(5), '-')
        ]);
        Product::factory()->count(1)->create([
            'product_name' => 'Croissant',
            'product_category_id' => 2,
            'picture' => '/images/croissant.png',
            'product_slug' => Str::slug('croissant' . '-' . Str::random(5), '-')
        ]);
        Product::factory()->count(1)->create([
            'product_name' => 'Pan Queso',
            'product_category_id' => 2,
            'picture' => '/images/pan-queso.png',
            'product_slug' => Str::slug('pan-quese' . '-' . Str::random(5), '-')
        ]);
        Product::factory()->count(1)->create([
            'product_name' => 'Cafe en Leche',
            'product_category_id' => 3,
            'picture' => '/images/cafe-leche.png',
            'product_slug' => Str::slug('cafe-leche' . '-' . Str::random(5), '-')
        ]);
        Product::factory()->count(1)->create([
            'product_name' => 'Milo Caliente',
            'picture' => '/images/milo-caliente.png',
            'product_category_id' => 3,
            'product_slug' => Str::slug('milo-caliente' . '-' . Str::random(5), '-')
        ]);
    }
}
