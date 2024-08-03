<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendances>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1,10),
            'date' => now(),
            'check_in' => $this->faker->time($format = 'H:i:s', $max = 'now'),
            'check_out' => $this->faker->time($format = 'H:i:s', $max = 'now'),
        ];
    }
}
