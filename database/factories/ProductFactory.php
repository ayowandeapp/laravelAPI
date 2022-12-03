<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'name' => $this->faker->name(),
            'slug' => $this->faker->words(1,true),
            'description' => $this->faker->words(5,true),
            'price' => $this->faker->randomNumber(3,true),
            //
        ];
    }
}
