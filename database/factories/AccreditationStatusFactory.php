<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AccreditationStatusFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'  => fake()->randomElement(['Accredited', 'Provisional', 'Pending']),
            'class' => fake()->randomElement(['success', 'warning', 'danger']),
        ];
    }
}
