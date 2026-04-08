<?php

namespace Database\Factories;

use App\Models\CategoryClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->word();

        return [
            'name'              => $name,
            'name_plural'       => $name . 's',
            'category_class_id' => CategoryClass::factory(),
        ];
    }
}
