<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CollegeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'College of ' . fake()->unique()->word(),
        ];
    }
}
