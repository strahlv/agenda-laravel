<?php

namespace Database\Factories;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startDate = CarbonImmutable::parse(
            $this->faker->dateTimeThisYear('+12 months')->format('Y-m-d')
        );

        $endDate = $startDate->addHours(rand(0, 24 * 7));

        return [
            'title' => $this->faker->sentence(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'user_id' => 1
        ];
    }
}
