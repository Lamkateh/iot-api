<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $period = $this->faker->numberBetween(1000, 10000);
        $start = new Carbon($this->faker->dateTime());
        $secondsToAdd = $this->faker->numberBetween($period * $this->faker->numberBetween(10, 1000), $period * $this->faker->numberBetween(1000, 10000));

        return [
            'name' => $this->faker->word,
            'period' => $period,
            'start' => $start,
            'end' => $start->copy()->addSeconds($secondsToAdd),
        ];
    }
}
