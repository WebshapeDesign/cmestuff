<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'registration_number' => strtoupper(fake()->regexify('[A-Z]{2}[0-9]{2} [A-Z]{3}')),
            'starting_mileage' => fake()->numberBetween(1000, 100000),
            'make' => fake()->randomElement(['Ford', 'Mercedes', 'Volkswagen', 'Toyota']),
            'model' => fake()->word(),
            'current_mileage' => fake()->numberBetween(1000, 100000),
            'user_id' => null,
        ];
    }
} 