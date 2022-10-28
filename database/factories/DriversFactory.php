<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DriversFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->words(2,true)),
        ];
    }
}
