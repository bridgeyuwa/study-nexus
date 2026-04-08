<?php

namespace Database\Factories;

use App\Models\AccreditationBody;
use App\Models\AccreditationStatus;
use App\Models\Category;
use App\Models\InstitutionHead;
use App\Models\InstitutionType;
use App\Models\ReligiousAffiliation;
use App\Models\State;
use App\Models\Term;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstitutionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id'                      => (string) fake()->unique()->randomNumber(6, true),
            'name'                    => fake()->company() . ' University',
            'former_name'             => null,
            'abbr'                    => strtoupper(fake()->lexify('???')),
            'description'             => fake()->paragraph(),
            'remarks'                 => null,
            'established'             => fake()->year(),
            'state_id'                => State::factory(),
            'locality'                => fake()->city(),
            'parent_id'               => null,
            'institution_type_id'     => InstitutionType::factory(),
            'category_id'             => Category::factory(),
            'term_id'                 => Term::factory(),
            'accreditation_body_id'   => AccreditationBody::factory(),
            'accreditation_status_id' => AccreditationStatus::factory(),
            'religious_affiliation_id' => ReligiousAffiliation::factory(),
            'institution_head_id'     => InstitutionHead::factory(),
            'slogan'                  => null,
            'address'                 => fake()->address(),
            'coordinates'             => null,
            'url'                     => fake()->url(),
            'logo'                    => null,
            'postal_code'             => null,
            'email'                   => fake()->companyEmail(),
            'rank'                    => null,
        ];
    }

    public function ranked(int $rank): static
    {
        return $this->state(fn() => ['rank' => $rank]);
    }

    public function withParent(\App\Models\Institution $parent): static
    {
        return $this->state(fn() => ['parent_id' => $parent->id]);
    }
}
