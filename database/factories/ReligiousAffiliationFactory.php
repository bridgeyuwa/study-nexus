<?php

namespace Database\Factories;

use App\Models\ReligiousAffiliationCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReligiousAffiliationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'                              => fake()->unique()->word() . ' Affiliation',
            'description'                       => null,
            'religious_affiliation_category_id' => ReligiousAffiliationCategory::factory(),
        ];
    }
}
