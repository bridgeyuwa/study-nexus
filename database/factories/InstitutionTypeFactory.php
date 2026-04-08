<?php

namespace Database\Factories;

use App\Models\InstitutionTypeCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InstitutionTypeFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->word() . ' Institution';

        return [
            'name'                        => $name,
            'slug'                        => Str::slug($name . '-' . fake()->unique()->randomNumber(4)),
            'description'                 => null,
            'institution_type_category_id' => InstitutionTypeCategory::factory(),
        ];
    }

    public function public(): static
    {
        return $this->state(fn() => [
            'institution_type_category_id' => InstitutionTypeCategory::factory()->state(['slug' => 'public']),
        ]);
    }

    public function federal(): static
    {
        return $this->state(fn() => [
            'slug' => 'federal',
        ]);
    }

    public function stateOwned(): static
    {
        return $this->state(fn() => [
            'slug' => 'state',
        ]);
    }

    public function private(): static
    {
        return $this->state(fn() => [
            'slug' => 'private',
        ]);
    }
}
