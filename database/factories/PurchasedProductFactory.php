<?php

namespace Database\Factories;

use App\Models\Bill;
use App\Models\Product;
use App\Models\PurchasedProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchasedProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PurchasedProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $bills = Bill::pluck('number')->all();
        $products = Product::pluck('id')->all();
        return [
            'quantity' => $this->faker->unique()->randomNumber(2),
            'total_price' => $this->faker->unique()->randomNumber(6),
            'bill_id' => $this->faker->randomElement($bills),
            'product_id' => $this->faker->randomElement($products)
        ];
    }
}
