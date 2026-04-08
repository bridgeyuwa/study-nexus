<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AccreditationBodyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' Accreditation Body',
            'abbr' => strtoupper(fake()->lexify('???')),
            'url'  => fake()->url(),
            'logo' => null,
        ];
    }
}
