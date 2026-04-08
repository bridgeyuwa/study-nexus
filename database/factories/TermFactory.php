<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TermFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Semester', 'Trimester', 'Quarter']),
        ];
    }
}
