<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LevelFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Undergraduate', 'Postgraduate', 'Diploma', 'Certificate', 'PhD',
        ]) . '-' . fake()->unique()->randomNumber(3);

        return [
            'name'        => $name,
            'abbr'        => strtoupper(fake()->lexify('??')),
            'utme_cutoff' => null,
        ];
    }
}
