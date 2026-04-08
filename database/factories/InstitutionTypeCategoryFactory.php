<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InstitutionTypeCategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->word();

        return [
            'name'        => $name,
            'slug'        => Str::slug($name . '-' . fake()->unique()->randomNumber(4)),
            'description' => null,
        ];
    }
}
