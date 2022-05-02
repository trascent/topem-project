<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // Facturas Base
            BillSeeder::class,
            // Productos Base
            ProductSeeder::class,
            // Productos comprados Base
            PurchasedProductSeeder::class,
        ]);
        //Agregar usuario de autenticación
        User::factory()->times(1)->create();
    }
}
