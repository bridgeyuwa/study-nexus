<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InstitutionHeadFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->jobTitle(),
        ];
    }
}
