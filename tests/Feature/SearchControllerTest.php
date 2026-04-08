<?php

namespace Tests\Feature;

use App\Models\AccreditationBody;
use App\Models\AccreditationStatus;
use App\Models\Category;
use App\Models\CategoryClass;
use App\Models\Institution;
use App\Models\InstitutionHead;
use App\Models\InstitutionType;
use App\Models\InstitutionTypeCategory;
use App\Models\Level;
use App\Models\Program;
use App\Models\Region;
use App\Models\ReligiousAffiliation;
use App\Models\ReligiousAffiliationCategory;
use App\Models\State;
use App\Models\Term;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchControllerTest extends TestCase
{
    use RefreshDatabase;

    private Term $term;
    private AccreditationBody $accreditationBody;
    private AccreditationStatus $accreditationStatus;
    private InstitutionHead $institutionHead;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->term                 = Term::factory()->create();
        $this->accreditationBody    = AccreditationBody::factory()->create();
        $this->accreditationStatus  = AccreditationStatus::factory()->create();
        $this->institutionHead      = InstitutionHead::factory()->create();
        $categoryClass              = CategoryClass::factory()->create();
        $this->category             = Category::factory()->create(['category_class_id' => $categoryClass->id]);
    }

    private function createInstitution(array $overrides = []): Institution
    {
        $region  = Region::factory()->create();
        $state   = State::factory()->create(['region_id' => $region->id]);
        $relAff  = ReligiousAffiliation::factory()->create();
        $type    = InstitutionType::factory()->create();

        return Institution::factory()->create(array_merge([
            'state_id'                 => $state->id,
            'category_id'              => $this->category->id,
            'term_id'                  => $this->term->id,
            'accreditation_body_id'    => $this->accreditationBody->id,
            'accreditation_status_id'  => $this->accreditationStatus->id,
            'institution_type_id'      => $type->id,
            'religious_affiliation_id' => $relAff->id,
            'institution_head_id'      => $this->institutionHead->id,
        ], $overrides));
    }

    // -------------------------------------------------------------------------
    // Basic
    // -------------------------------------------------------------------------

    public function test_search_with_no_filters_returns_200(): void
    {
        $this->get(route('search'))->assertStatus(200);
    }

    public function test_search_returns_all_institutions_when_no_filters_applied(): void
    {
        $inst1 = $this->createInstitution();
        $inst2 = $this->createInstitution();

        $this->get(route('search'))
            ->assertViewHas('institutions', function ($institutions) use ($inst1, $inst2) {
                return $institutions->contains('id', $inst1->id)
                    && $institutions->contains('id', $inst2->id);
            });
    }

    // -------------------------------------------------------------------------
    // Type filter
    // -------------------------------------------------------------------------

    public function test_search_filter_type_public_matches_institutions_with_public_type_category(): void
    {
        $publicTypeCat  = InstitutionTypeCategory::factory()->create(['slug' => 'public']);
        $publicType     = InstitutionType::factory()->create(['institution_type_category_id' => $publicTypeCat->id]);
        $privateTypeCat = InstitutionTypeCategory::factory()->create(['slug' => 'private-cat']);
        $privateType    = InstitutionType::factory()->create(['institution_type_category_id' => $privateTypeCat->id]);

        $public  = $this->createInstitution(['institution_type_id' => $publicType->id]);
        $private = $this->createInstitution(['institution_type_id' => $privateType->id]);

        $this->get(route('search', ['type' => 'public']))
            ->assertViewHas('institutions', function ($institutions) use ($public, $private) {
                return $institutions->contains('id', $public->id)
                    && !$institutions->contains('id', $private->id);
            });
    }

    public function test_search_filter_type_federal_matches_by_institution_type_slug(): void
    {
        $federalType  = InstitutionType::factory()->create(['slug' => 'federal']);
        $otherType    = InstitutionType::factory()->create(['slug' => 'private']);

        $federal = $this->createInstitution(['institution_type_id' => $federalType->id]);
        $other   = $this->createInstitution(['institution_type_id' => $otherType->id]);

        $this->get(route('search', ['type' => 'federal']))
            ->assertViewHas('institutions', function ($institutions) use ($federal, $other) {
                return $institutions->contains('id', $federal->id)
                    && !$institutions->contains('id', $other->id);
            });
    }

    public function test_search_invalid_type_is_sanitized_and_returns_all_results(): void
    {
        $institution = $this->createInstitution();

        $this->get(route('search', ['type' => 'hacked_value']))
            ->assertStatus(200)
            ->assertViewHas('institutions', function ($institutions) use ($institution) {
                return $institutions->contains('id', $institution->id);
            });
    }

    // -------------------------------------------------------------------------
    // State filter
    // -------------------------------------------------------------------------

    public function test_search_filter_by_state_returns_only_matching_institutions(): void
    {
        $region      = Region::factory()->create();
        $targetState = State::factory()->create(['region_id' => $region->id]);
        $otherState  = State::factory()->create(['region_id' => $region->id]);

        $relAff = ReligiousAffiliation::factory()->create();
        $type   = InstitutionType::factory()->create();

        $matching = Institution::factory()->create([
            'state_id'                 => $targetState->id,
            'category_id'              => $this->category->id,
            'term_id'                  => $this->term->id,
            'accreditation_body_id'    => $this->accreditationBody->id,
            'accreditation_status_id'  => $this->accreditationStatus->id,
            'institution_type_id'      => $type->id,
            'religious_affiliation_id' => $relAff->id,
            'institution_head_id'      => $this->institutionHead->id,
        ]);

        $nonMatching = Institution::factory()->create([
            'state_id'                 => $otherState->id,
            'category_id'              => $this->category->id,
            'term_id'                  => $this->term->id,
            'accreditation_body_id'    => $this->accreditationBody->id,
            'accreditation_status_id'  => $this->accreditationStatus->id,
            'institution_type_id'      => $type->id,
            'religious_affiliation_id' => $relAff->id,
            'institution_head_id'      => $this->institutionHead->id,
        ]);

        $this->get(route('search', ['location' => $targetState->id]))
            ->assertViewHas('institutions', function ($institutions) use ($matching, $nonMatching) {
                return $institutions->contains('id', $matching->id)
                    && !$institutions->contains('id', $nonMatching->id);
            });
    }

    // -------------------------------------------------------------------------
    // Category filter
    // -------------------------------------------------------------------------

    public function test_search_filter_by_category_class_returns_only_matching_institutions(): void
    {
        $otherCategoryClass = CategoryClass::factory()->create();
        $otherCategory      = Category::factory()->create(['category_class_id' => $otherCategoryClass->id]);

        $matching    = $this->createInstitution();
        $nonMatching = $this->createInstitution(['category_id' => $otherCategory->id]);

        $this->get(route('search', ['category' => $this->category->categoryClass->id]))
            ->assertViewHas('institutions', function ($institutions) use ($matching, $nonMatching) {
                return $institutions->contains('id', $matching->id)
                    && !$institutions->contains('id', $nonMatching->id);
            });
    }

    // -------------------------------------------------------------------------
    // Level filter
    // -------------------------------------------------------------------------

    public function test_search_filter_by_level_returns_institutions_offering_that_level(): void
    {
        $institution = $this->createInstitution();
        $level       = Level::factory()->create();
        $program     = Program::factory()->create();

        $institution->programs()->attach($program, [
            'level_id'              => $level->id,
            'accreditation_body_id' => $this->accreditationBody->id,
        ]);

        $noLevelInstitution = $this->createInstitution();

        $this->get(route('search', ['level' => $level->id]))
            ->assertViewHas('institutions', function ($institutions) use ($institution, $noLevelInstitution) {
                return $institutions->contains('id', $institution->id)
                    && !$institutions->contains('id', $noLevelInstitution->id);
            });
    }

    // -------------------------------------------------------------------------
    // Program filter
    // -------------------------------------------------------------------------

    public function test_search_filter_by_program_returns_institutions_offering_that_program(): void
    {
        $institution    = $this->createInstitution();
        $otherInstitution = $this->createInstitution();
        $level          = Level::factory()->create();
        $program        = Program::factory()->create();

        $institution->programs()->attach($program, [
            'level_id'              => $level->id,
            'accreditation_body_id' => $this->accreditationBody->id,
        ]);

        $this->get(route('search', ['program' => $program->id]))
            ->assertViewHas('institutions', function ($institutions) use ($institution, $otherInstitution) {
                return $institutions->contains('id', $institution->id)
                    && !$institutions->contains('id', $otherInstitution->id);
            });
    }

    // -------------------------------------------------------------------------
    // Religious affiliation filter
    // -------------------------------------------------------------------------

    public function test_search_filter_by_religion_returns_matching_institutions(): void
    {
        $relCategory    = ReligiousAffiliationCategory::factory()->create();
        $targetAffil    = ReligiousAffiliation::factory()->create(['religious_affiliation_category_id' => $relCategory->id]);
        $otherAffil     = ReligiousAffiliation::factory()->create();

        $matching    = $this->createInstitution(['religious_affiliation_id' => $targetAffil->id]);
        $nonMatching = $this->createInstitution(['religious_affiliation_id' => $otherAffil->id]);

        $this->get(route('search', ['religion' => $relCategory->id]))
            ->assertViewHas('institutions', function ($institutions) use ($matching, $nonMatching) {
                return $institutions->contains('id', $matching->id)
                    && !$institutions->contains('id', $nonMatching->id);
            });
    }

    // -------------------------------------------------------------------------
    // Sorting
    // -------------------------------------------------------------------------

    public function test_search_default_sort_is_alphabetical_ascending(): void
    {
        $this->createInstitution(['name' => 'Zeta University']);
        $this->createInstitution(['name' => 'Alpha University']);

        $this->get(route('search'))
            ->assertViewHas('institutions', function ($institutions) {
                return $institutions->first()->name === 'Alpha University';
            });
    }

    public function test_search_sort_za_orders_descending(): void
    {
        $this->createInstitution(['name' => 'Alpha University']);
        $this->createInstitution(['name' => 'Zeta University']);

        $this->get(route('search', ['sort' => 'za']))
            ->assertViewHas('institutions', function ($institutions) {
                return $institutions->first()->name === 'Zeta University';
            });
    }

    public function test_search_sort_rank_places_ranked_institutions_first(): void
    {
        $ranked   = $this->createInstitution(['rank' => 1, 'name' => 'Zeta University']);
        $unranked = $this->createInstitution(['rank' => null, 'name' => 'Alpha University']);

        $this->get(route('search', ['sort' => 'rank']))
            ->assertViewHas('institutions', function ($institutions) use ($ranked) {
                return $institutions->first()->id === $ranked->id;
            });
    }

    public function test_search_invalid_sort_is_sanitized_and_defaults_to_az(): void
    {
        $this->createInstitution(['name' => 'Alpha University']);
        $this->createInstitution(['name' => 'Zeta University']);

        $this->get(route('search', ['sort' => 'invalid_value']))
            ->assertStatus(200)
            ->assertViewHas('institutions', function ($institutions) {
                return $institutions->first()->name === 'Alpha University';
            });
    }

    // -------------------------------------------------------------------------
    // Cache key isolation
    // -------------------------------------------------------------------------

    public function test_different_state_filters_return_different_results(): void
    {
        $region = Region::factory()->create();
        $state1 = State::factory()->create(['region_id' => $region->id]);
        $state2 = State::factory()->create(['region_id' => $region->id]);

        $relAff = ReligiousAffiliation::factory()->create();
        $type   = InstitutionType::factory()->create();

        $base = [
            'category_id'              => $this->category->id,
            'term_id'                  => $this->term->id,
            'accreditation_body_id'    => $this->accreditationBody->id,
            'accreditation_status_id'  => $this->accreditationStatus->id,
            'institution_type_id'      => $type->id,
            'religious_affiliation_id' => $relAff->id,
            'institution_head_id'      => $this->institutionHead->id,
        ];

        $inst1 = Institution::factory()->create(array_merge($base, ['state_id' => $state1->id]));
        $inst2 = Institution::factory()->create(array_merge($base, ['state_id' => $state2->id]));

        $resultState1 = $this->get(route('search', ['location' => $state1->id]))->viewData('institutions');
        $resultState2 = $this->get(route('search', ['location' => $state2->id]))->viewData('institutions');

        $this->assertTrue($resultState1->contains('id', $inst1->id));
        $this->assertFalse($resultState1->contains('id', $inst2->id));
        $this->assertTrue($resultState2->contains('id', $inst2->id));
        $this->assertFalse($resultState2->contains('id', $inst1->id));
    }
}
