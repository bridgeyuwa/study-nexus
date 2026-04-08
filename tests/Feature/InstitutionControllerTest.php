<?php

namespace Tests\Feature;

use App\Models\AccreditationBody;
use App\Models\AccreditationStatus;
use App\Models\Category;
use App\Models\CategoryClass;
use App\Models\College;
use App\Models\Institution;
use App\Models\InstitutionHead;
use App\Models\InstitutionType;
use App\Models\Level;
use App\Models\Program;
use App\Models\Region;
use App\Models\ReligiousAffiliation;
use App\Models\State;
use App\Models\Term;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InstitutionControllerTest extends TestCase
{
    use RefreshDatabase;

    // Shared FK dependencies
    private Term $term;
    private AccreditationBody $accreditationBody;
    private AccreditationStatus $accreditationStatus;
    private InstitutionType $institutionType;
    private ReligiousAffiliation $religiousAffiliation;
    private InstitutionHead $institutionHead;
    private Category $category;
    private CategoryClass $categoryClass;
    private State $state;

    protected function setUp(): void
    {
        parent::setUp();

        $region                     = Region::factory()->create();
        $this->state                = State::factory()->create(['region_id' => $region->id]);
        $this->categoryClass        = CategoryClass::factory()->create();
        $this->category             = Category::factory()->create(['category_class_id' => $this->categoryClass->id]);
        $this->term                 = Term::factory()->create();
        $this->accreditationBody    = AccreditationBody::factory()->create();
        $this->accreditationStatus  = AccreditationStatus::factory()->create();
        $this->institutionType      = InstitutionType::factory()->create();
        $this->religiousAffiliation = ReligiousAffiliation::factory()->create();
        $this->institutionHead      = InstitutionHead::factory()->create();
    }

    private function createInstitution(array $overrides = []): Institution
    {
        return Institution::factory()->create(array_merge([
            'state_id'                 => $this->state->id,
            'category_id'              => $this->category->id,
            'term_id'                  => $this->term->id,
            'accreditation_body_id'    => $this->accreditationBody->id,
            'accreditation_status_id'  => $this->accreditationStatus->id,
            'institution_type_id'      => $this->institutionType->id,
            'religious_affiliation_id' => $this->religiousAffiliation->id,
            'institution_head_id'      => $this->institutionHead->id,
        ], $overrides));
    }

    // -------------------------------------------------------------------------
    // index
    // -------------------------------------------------------------------------

    public function test_index_returns_200(): void
    {
        $this->createInstitution();

        $this->get(route('institutions.index'))->assertStatus(200);
    }

    public function test_index_passes_institutions_to_view(): void
    {
        $institution = $this->createInstitution();

        $this->get(route('institutions.index'))
            ->assertViewHas('institutions');
    }

    // -------------------------------------------------------------------------
    // category
    // -------------------------------------------------------------------------

    public function test_category_returns_200(): void
    {
        $this->createInstitution();

        $this->get(route('institutions.categories.index', $this->categoryClass))
            ->assertStatus(200);
    }

    public function test_category_only_shows_institutions_of_that_category_class(): void
    {
        $otherCategoryClass = CategoryClass::factory()->create();
        $otherCategory      = Category::factory()->create(['category_class_id' => $otherCategoryClass->id]);

        $matching    = $this->createInstitution();
        $nonMatching = $this->createInstitution(['category_id' => $otherCategory->id]);

        $this->get(route('institutions.categories.index', $this->categoryClass))
            ->assertViewHas('institutions', function ($institutions) use ($matching, $nonMatching) {
                return $institutions->contains('id', $matching->id)
                    && !$institutions->contains('id', $nonMatching->id);
            });
    }

    // -------------------------------------------------------------------------
    // showLocation
    // -------------------------------------------------------------------------

    public function test_show_location_returns_200(): void
    {
        $this->createInstitution();

        $this->get(route('institutions.location.show', $this->state))
            ->assertStatus(200);
    }

    public function test_show_location_only_shows_institutions_in_that_state(): void
    {
        $otherState = State::factory()->create(['region_id' => Region::factory()->create()->id]);
        $matching   = $this->createInstitution();
        $other      = $this->createInstitution(['state_id' => $otherState->id]);

        $this->get(route('institutions.location.show', $this->state))
            ->assertViewHas('institutions', function ($institutions) use ($matching, $other) {
                return $institutions->contains('id', $matching->id)
                    && !$institutions->contains('id', $other->id);
            });
    }

    // -------------------------------------------------------------------------
    // show
    // -------------------------------------------------------------------------

    public function test_show_returns_200(): void
    {
        $institution = $this->createInstitution();

        $this->get(route('institutions.show', $institution))
            ->assertStatus(200);
    }

    public function test_show_passes_institution_to_view(): void
    {
        $institution = $this->createInstitution();

        $this->get(route('institutions.show', $institution))
            ->assertViewHas('institution', function ($viewInstitution) use ($institution) {
                return $viewInstitution->id === $institution->id;
            });
    }

    public function test_show_computes_rank_for_ranked_institution(): void
    {
        $institution = $this->createInstitution(['rank' => 1]);

        $this->get(route('institutions.show', $institution))
            ->assertViewHas('rank', function ($rank) {
                return $rank['institution'] === 1;
            });
    }

    // -------------------------------------------------------------------------
    // programs (level branching)
    // -------------------------------------------------------------------------

    public function test_programs_for_level_3_returns_flat_sorted_collection(): void
    {
        $institution = $this->createInstitution();
        $level       = Level::factory()->create(['id' => 3]);
        $college     = College::factory()->create();
        $program     = Program::factory()->create(['college_id' => $college->id]);

        $institution->programs()->attach($program, [
            'level_id'              => $level->id,
            'accreditation_body_id' => $this->accreditationBody->id,
        ]);

        $this->get(route('institutions.programs', [$institution, $level]))
            ->assertStatus(200)
            ->assertViewHas('programs', function ($programs) {
                // Level 3 returns a flat Collection, not a nested structure
                return !$programs instanceof \Illuminate\Support\Collection
                    || !($programs->first() instanceof \Illuminate\Support\Collection);
            });
    }

    public function test_programs_for_other_levels_returns_collection_grouped_by_college(): void
    {
        $institution = $this->createInstitution();
        $level       = Level::factory()->create();
        $college     = College::factory()->create(['name' => 'College of Engineering']);
        $program     = Program::factory()->create(['college_id' => $college->id]);

        $institution->programs()->attach($program, [
            'level_id'              => $level->id,
            'accreditation_body_id' => $this->accreditationBody->id,
        ]);

        $this->get(route('institutions.programs', [$institution, $level]))
            ->assertStatus(200)
            ->assertViewHas('programs', function ($programs) use ($college) {
                // Non-level-3 returns a collection keyed by college name
                return $programs->has($college->name);
            });
    }

    // -------------------------------------------------------------------------
    // showProgram — 404 guard
    // -------------------------------------------------------------------------

    public function test_show_program_returns_404_when_program_not_associated_with_institution(): void
    {
        $institution = $this->createInstitution();
        $level       = Level::factory()->create();
        $program     = Program::factory()->create();

        // No pivot row inserted → program does not belong to institution at this level
        $this->get(route('institutions.program.show', [$institution, $level, $program]))
            ->assertStatus(404);
    }

    public function test_show_program_returns_200_when_program_is_associated(): void
    {
        $institution = $this->createInstitution();
        $level       = Level::factory()->create();
        $program     = Program::factory()->create();

        $institution->programs()->attach($program, [
            'level_id'              => $level->id,
            'accreditation_body_id' => $this->accreditationBody->id,
        ]);

        $this->get(route('institutions.program.show', [$institution, $level, $program]))
            ->assertStatus(200);
    }

    // -------------------------------------------------------------------------
    // institutionRanking
    // -------------------------------------------------------------------------

    public function test_institution_ranking_returns_200(): void
    {
        $this->createInstitution(['rank' => 1]);

        $this->get(route('institutions.categories.ranking', $this->categoryClass))
            ->assertStatus(200);
    }

    public function test_ranking_view_has_correct_rank_data(): void
    {
        $first  = $this->createInstitution(['rank' => 1]);
        $second = $this->createInstitution(['rank' => 2]);

        $this->get(route('institutions.categories.ranking', $this->categoryClass))
            ->assertViewHas('rank', function ($rank) use ($first, $second) {
                return $rank[$first->id]['institution'] === 1
                    && $rank[$second->id]['institution'] === 2;
            });
    }

    public function test_ranking_is_null_when_no_institutions_have_a_rank(): void
    {
        $this->createInstitution(['rank' => null]);

        $this->get(route('institutions.categories.ranking', $this->categoryClass))
            ->assertViewHas('rank', null);
    }
}
