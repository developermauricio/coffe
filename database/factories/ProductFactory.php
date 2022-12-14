<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_description' => $this->faker->sentence(20),
            'reference' => Str::random(5),
            'price' => $this->faker->randomFloat(3, 10, 20 ),
            'weight' => $this->faker->numberBetween(1, 5),
            'stock' => $this->faker->numberBetween(1, 10)
        ];
    }
}
