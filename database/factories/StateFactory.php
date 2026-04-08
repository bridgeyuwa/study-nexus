<?php

namespace Database\Factories;

use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

class StateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'      => fake()->unique()->city(),
            'code'      => strtoupper(fake()->unique()->lexify('??')),
            'is_state'  => 1,
            'region_id' => Region::factory(),
        ];
    }
}
