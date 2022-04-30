<?php

namespace Database\Seeders;

use App\Models\PurchasedProduct;
use Illuminate\Database\Seeder;

class PurchasedProductSeeder extends Seeder
{
    /**
     * Seed the application's products.
     *
     * @return void
     */
    public function run()
    {
        // Agregar productos
        PurchasedProduct::factory()->times(15)->create();
    }
}
