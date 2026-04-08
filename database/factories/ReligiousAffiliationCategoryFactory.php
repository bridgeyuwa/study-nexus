<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReligiousAffiliationCategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => fake()->unique()->word() . ' Religion',
            'description' => null,
        ];
    }
}
