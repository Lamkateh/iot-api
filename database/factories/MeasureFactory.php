<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MeasureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            "values" => [
                "latitude" => 0,
                "longitude" => 0,
                "temperature" => [
                    "value" => $this->faker->numberBetween(-10, 100),
                    "unit" => "°C",
                ],
                "humidité" => [
                    "value" => $this->faker->numberBetween(0, 100),
                    "unit" => "%",
                ],
            ]
        ];
    }
}
