<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CarsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'model' => ucfirst($this->faker->words(1,true)).'CAR ',
            'driver' => '0',
        ];
    }
}
