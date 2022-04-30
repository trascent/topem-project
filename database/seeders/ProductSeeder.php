<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Seed the application's products.
     *
     * @return void
     */
    public function run()
    {
        // Agregar productos
        Product::factory()->times(rand(5, 10))->create();
    }
}
