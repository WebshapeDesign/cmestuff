<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VanLogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'vehicle_mileage' => fake()->numberBetween(1000, 100000),
            'oil_level_action' => fake()->randomElement(['Checked', 'Topped Up', 'Changed']),
            'oil_level_signed' => fake()->name(),
            'water_level_action' => fake()->randomElement(['Checked', 'Topped Up']),
            'water_level_signed' => fake()->name(),
            'tyres_action' => fake()->randomElement(['Checked', 'Replaced']),
            'tyres_signed' => fake()->name(),
            'screen_action' => fake()->randomElement(['Checked', 'Replaced']),
            'screen_signed' => fake()->name(),
            'vehicle_defects' => fake()->optional()->sentence(),
            'van_items_check' => [],
            'ppe_check' => [],
        ];
    }
} 