<?php

namespace Database\Factories;

use App\Models\College;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id'        => (string) fake()->unique()->randomNumber(6, true),
            'name'      => fake()->unique()->bs() . ' Studies',
            'college_id' => College::factory(),
        ];
    }
}
