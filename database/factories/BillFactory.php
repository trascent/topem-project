<?php

namespace Database\Factories;

use App\Models\Bill;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class BillFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bill::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->unique()->randomNumber(6),
            'emisor_name' => $this->faker->company,
            'emisor_nit' => $this->faker->unique()->randomNumber(9),
            'buyer_name' => $this->faker->company,
            'buyer_nit' => $this->faker->unique()->randomNumber(9),
            'net_amount' => $this->faker->randomNumber(6),
            'iva' => $this->faker->randomNumber(2),
            'bill_purchase_date' => Carbon::parse($this->faker->date('Y-m-d h:m-s')),
            'total_net_amount' => $this->faker->randomNumber(9),
        ];
    }
}
