<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserSettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'show_holidays' => $this->faker->boolean(),
            'week_starts_monday' => $this->faker->boolean(),
            'year_starts_day_one' => $this->faker->boolean()
        ];
    }
}
