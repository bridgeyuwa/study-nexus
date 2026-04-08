<?php

namespace Tests\Unit;

use App\Http\Controllers\InstitutionController;
use App\Models\AccreditationBody;
use App\Models\AccreditationStatus;
use App\Models\Category;
use App\Models\CategoryClass;
use App\Models\Institution;
use App\Models\InstitutionHead;
use App\Models\InstitutionType;
use App\Models\Region;
use App\Models\ReligiousAffiliation;
use App\Models\State;
use App\Models\Term;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ReflectionMethod;
use Tests\TestCase;

class ComputeRankTest extends TestCase
{
    use RefreshDatabase;

    private InstitutionController $controller;
    private ReflectionMethod $computeRank;

    // Shared dependencies reused across institutions in the same test
    private Region $region;
    private State $state1;
    private State $state2;
    private Category $category;
    private Term $term;
    private AccreditationBody $accreditationBody;
    private AccreditationStatus $accreditationStatus;
    private InstitutionType $institutionType;
    private ReligiousAffiliation $religiousAffiliation;
    private InstitutionHead $institutionHead;

    protected function setUp(): void
    {
        parent::setUp();

        $this->controller  = new InstitutionController();
        $this->computeRank = new ReflectionMethod(InstitutionController::class, 'computeRank');
        $this->computeRank->setAccessible(true);

        // Build shared relational data once per test
        $this->region               = Region::factory()->create();
        $this->state1               = State::factory()->create(['region_id' => $this->region->id]);
        $this->state2               = State::factory()->create(['region_id' => $this->region->id]);
        $categoryClass              = CategoryClass::factory()->create();
        $this->category             = Category::factory()->create(['category_class_id' => $categoryClass->id]);
        $this->term                 = Term::factory()->create();
        $this->accreditationBody    = AccreditationBody::factory()->create();
        $this->accreditationStatus  = AccreditationStatus::factory()->create();
        $this->institutionType      = InstitutionType::factory()->create();
        $this->religiousAffiliation = ReligiousAffiliation::factory()->create();
        $this->institutionHead      = InstitutionHead::factory()->create();
    }

    /** Create an institution with all required FKs pre-filled. */
    private function makeInstitution(State $state, ?int $rank, array $overrides = []): Institution
    {
        return Institution::factory()->create(array_merge([
            'state_id'                 => $state->id,
            'category_id'              => $this->category->id,
            'term_id'                  => $this->term->id,
            'accreditation_body_id'    => $this->accreditationBody->id,
            'accreditation_status_id'  => $this->accreditationStatus->id,
            'institution_type_id'      => $this->institutionType->id,
            'religious_affiliation_id' => $this->religiousAffiliation->id,
            'institution_head_id'      => $this->institutionHead->id,
            'rank'                     => $rank,
        ], $overrides));
    }

    /** Call the private computeRank method. */
    private function invokeComputeRank(Institution $institution, $allInstitutions): array
    {
        $institution->load(['state.region.institutions', 'state.institutions', 'category']);

        return $this->computeRank->invoke($this->controller, $institution, $allInstitutions);
    }

    public function test_institution_without_rank_returns_false_for_all_positions(): void
    {
        $institution     = $this->makeInstitution($this->state1, null);
        $allInstitutions = Institution::whereNotNull('rank')->orderBy('rank')->get();

        $result = $this->invokeComputeRank($institution, $allInstitutions);

        $this->assertFalse($result['institution']);
        $this->assertFalse($result['region']);
        $this->assertFalse($result['state']);
    }

    public function test_sole_ranked_institution_gets_rank_1_everywhere(): void
    {
        $institution     = $this->makeInstitution($this->state1, 1);
        $allInstitutions = Institution::whereNotNull('rank')
            ->where('category_id', $this->category->id)
            ->orderBy('rank')
            ->get();

        $result = $this->invokeComputeRank($institution, $allInstitutions);

        $this->assertEquals(1, $result['institution']);
        $this->assertEquals(1, $result['region']);
        $this->assertEquals(1, $result['state']);
    }

    public function test_national_rank_reflects_position_in_all_institutions_list(): void
    {
        $inst1 = $this->makeInstitution($this->state1, 1);
        $inst2 = $this->makeInstitution($this->state1, 2);
        $inst3 = $this->makeInstitution($this->state2, 3);

        $allInstitutions = Institution::whereNotNull('rank')
            ->where('category_id', $this->category->id)
            ->orderBy('rank')
            ->get();

        // inst2 is 2nd in the national list
        $result = $this->invokeComputeRank($inst2, $allInstitutions);

        $this->assertEquals(2, $result['institution']);
    }

    public function test_regional_rank_is_scoped_to_institutions_in_same_region(): void
    {
        // inst1 → state1 (this->region), rank 1
        // inst2 → state2 (this->region), rank 2
        // inst3 → otherState (DIFFERENT region), rank 3
        $otherRegion = Region::factory()->create();
        $otherState  = State::factory()->create(['region_id' => $otherRegion->id]);

        $inst1 = $this->makeInstitution($this->state1, 1);
        $inst2 = $this->makeInstitution($this->state2, 2);
        /*inst3*/ $this->makeInstitution($otherState, 3);

        $allInstitutions = Institution::whereNotNull('rank')
            ->where('category_id', $this->category->id)
            ->orderBy('rank')
            ->get();

        // inst2 has rank 2, so it is 2nd in the all-institutions list
        // Its region contains only inst1 and inst2 (inst3 is in a different region)
        $result = $this->invokeComputeRank($inst2, $allInstitutions);

        $this->assertEquals(2, $result['institution']); // 2nd nationally
        $this->assertEquals(2, $result['region']);      // 2nd in its own region (after inst1)
    }

    public function test_state_rank_is_scoped_to_institutions_in_same_state(): void
    {
        // inst1 and inst2 are in state1; inst3 is in state2
        // All three share the SAME region (both states are in $this->region)
        $inst1 = $this->makeInstitution($this->state1, 1);
        /*inst2*/ $this->makeInstitution($this->state1, 2);
        $inst3 = $this->makeInstitution($this->state2, 3);

        $allInstitutions = Institution::whereNotNull('rank')
            ->where('category_id', $this->category->id)
            ->orderBy('rank')
            ->get();

        // inst3 is 3rd nationally; all 3 are in the same region so it is 3rd
        // regionally too; but it is alone in state2 so it is 1st in its state.
        $result = $this->invokeComputeRank($inst3, $allInstitutions);

        $this->assertEquals(3, $result['institution']); // 3rd nationally
        $this->assertEquals(3, $result['region']);      // 3rd in shared region
        $this->assertEquals(1, $result['state']);       // 1st in state2
    }

    public function test_unranked_institution_does_not_affect_ranked_institutions_position(): void
    {
        $inst1   = $this->makeInstitution($this->state1, 1);
        /*unranked*/ $this->makeInstitution($this->state1, null);

        $allInstitutions = Institution::whereNotNull('rank')
            ->where('category_id', $this->category->id)
            ->orderBy('rank')
            ->get();

        $result = $this->invokeComputeRank($inst1, $allInstitutions);

        // Unranked institution should not appear in the rank calculations
        $this->assertEquals(1, $result['institution']);
        $this->assertEquals(1, $result['region']);
        $this->assertEquals(1, $result['state']);
    }
}
