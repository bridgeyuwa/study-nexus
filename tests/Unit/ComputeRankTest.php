<?php

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

uses(RefreshDatabase::class);

beforeEach(function () {
    $controller = new InstitutionController();
    $method     = tap(
        new ReflectionMethod(InstitutionController::class, 'computeRank'),
        fn ($m) => $m->setAccessible(true)
    );

    $this->region               = Region::factory()->create();
    $this->state1               = State::factory()->create(['region_id' => $this->region->id]);
    $this->state2               = State::factory()->create(['region_id' => $this->region->id]);
    $categoryClass              = CategoryClass::factory()->create();
    $this->category             = Category::factory()->create(['category_class_id' => $categoryClass->id]);
    $term                       = Term::factory()->create();
    $accreditationBody          = AccreditationBody::factory()->create();
    $accreditationStatus        = AccreditationStatus::factory()->create();
    $institutionType            = InstitutionType::factory()->create();
    $religiousAffiliation       = ReligiousAffiliation::factory()->create();
    $institutionHead            = InstitutionHead::factory()->create();

    // Closure: create an institution with all required FKs pre-filled.
    $this->make = fn (State $state, ?int $rank, array $overrides = []) =>
        Institution::factory()->create(array_merge([
            'state_id'                 => $state->id,
            'category_id'              => $this->category->id,
            'term_id'                  => $term->id,
            'accreditation_body_id'    => $accreditationBody->id,
            'accreditation_status_id'  => $accreditationStatus->id,
            'institution_type_id'      => $institutionType->id,
            'religious_affiliation_id' => $religiousAffiliation->id,
            'institution_head_id'      => $institutionHead->id,
            'rank'                     => $rank,
        ], $overrides));

    // Closure: eager-load relationships then call the private computeRank.
    $this->computeRank = function (Institution $institution, $allInstitutions) use ($controller, $method): array {
        $institution->load(['state.region.institutions', 'state.institutions', 'category']);
        return $method->invoke($controller, $institution, $allInstitutions);
    };
});

// Helper: fetch all ranked institutions for the shared category, ordered by rank.
function allRanked(Category $category): \Illuminate\Database\Eloquent\Collection
{
    return Institution::whereNotNull('rank')
        ->where('category_id', $category->id)
        ->orderBy('rank')
        ->get();
}

it('returns false for all positions when the institution has no rank', function () {
    $institution = ($this->make)($this->state1, null);

    $result = ($this->computeRank)($institution, allRanked($this->category));

    expect($result['institution'])->toBeFalse();
    expect($result['region'])->toBeFalse();
    expect($result['state'])->toBeFalse();
});

it('gives rank 1 everywhere when it is the only ranked institution', function () {
    $institution = ($this->make)($this->state1, 1);

    $result = ($this->computeRank)($institution, allRanked($this->category));

    expect($result['institution'])->toBe(1)
        ->and($result['region'])->toBe(1)
        ->and($result['state'])->toBe(1);
});

it('reflects the correct position in the national list', function () {
    ($this->make)($this->state1, 1);
    $inst2 = ($this->make)($this->state1, 2);
    ($this->make)($this->state2, 3);

    $result = ($this->computeRank)($inst2, allRanked($this->category));

    expect($result['institution'])->toBe(2);
});

it('scopes regional rank to institutions in the same region', function () {
    $otherRegion = Region::factory()->create();
    $otherState  = State::factory()->create(['region_id' => $otherRegion->id]);

    // inst1 and inst2 share $this->region; inst3 is in a different region.
    ($this->make)($this->state1, 1);
    $inst2 = ($this->make)($this->state2, 2);
    ($this->make)($otherState,  3);

    $result = ($this->computeRank)($inst2, allRanked($this->category));

    expect($result['institution'])->toBe(2) // 2nd nationally
        ->and($result['region'])->toBe(2);  // 2nd in its region (inst3 is elsewhere)
});

it('scopes state rank to institutions in the same state', function () {
    // inst1 + inst2 in state1; inst3 in state2 — all share the same region.
    ($this->make)($this->state1, 1);
    ($this->make)($this->state1, 2);
    $inst3 = ($this->make)($this->state2, 3);

    $result = ($this->computeRank)($inst3, allRanked($this->category));

    expect($result['institution'])->toBe(3) // 3rd nationally
        ->and($result['region'])->toBe(3)   // 3rd in shared region
        ->and($result['state'])->toBe(1);   // 1st in state2 alone
});

it('does not count unranked institutions in any position', function () {
    $inst1 = ($this->make)($this->state1, 1);
    ($this->make)($this->state1, null); // unranked sibling

    $result = ($this->computeRank)($inst1, allRanked($this->category));

    expect($result['institution'])->toBe(1)
        ->and($result['region'])->toBe(1)
        ->and($result['state'])->toBe(1);
});
