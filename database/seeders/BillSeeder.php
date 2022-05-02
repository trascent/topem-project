<?php

namespace Database\Seeders;

use App\Models\Bill;
use Illuminate\Database\Seeder;

class BillSeeder extends Seeder
{
    /**
     * Seed the application's bills.
     *
     * @return void
     */
    public function run()
    {
        // Agregar facturas
        Bill::factory()->times(5)->create();
    }
}
