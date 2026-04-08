<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'        => fake()->sentence(),
            'excerpt'      => fake()->paragraph(),
            'content'      => implode(' ', fake()->paragraphs(3)),
            'institution_id' => null,
            'cover_image'  => null,
        ];
    }

    public function forInstitution(\App\Models\Institution $institution): static
    {
        return $this->state(fn() => ['institution_id' => $institution->id]);
    }
}
