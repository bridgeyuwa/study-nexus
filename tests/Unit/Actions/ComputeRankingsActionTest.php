<?php

use App\Actions\Institution\ComputeRankingsAction;
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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->region = Region::factory()->create();
    $this->state1 = State::factory()->create(['region_id' => $this->region->id]);
    $this->state2 = State::factory()->create(['region_id' => $this->region->id]);
    $categoryClass = CategoryClass::factory()->create();
    $this->category = Category::factory()->create(['category_class_id' => $categoryClass->id]);
    $term = Term::factory()->create();
    $accBody = AccreditationBody::factory()->create();
    $accStatus = AccreditationStatus::factory()->create();
    $instType = InstitutionType::factory()->create();
    $relAff = ReligiousAffiliation::factory()->create();
    $instHead = InstitutionHead::factory()->create();

    $this->make = fn (State $state, ?int $rank) => Institution::factory()->create([
        'state_id' => $state->id,
        'category_id' => $this->category->id,
        'term_id' => $term->id,
        'accreditation_body_id' => $accBody->id,
        'accreditation_status_id' => $accStatus->id,
        'institution_type_id' => $instType->id,
        'religious_affiliation_id' => $relAff->id,
        'institution_head_id' => $instHead->id,
        'rank' => $rank,
    ]);

    $this->action = new ComputeRankingsAction;
});

function rankedCollection(Category $category): Collection
{
    return Institution::whereNotNull('rank')
        ->where('category_id', $category->id)
        ->orderBy('rank')
        ->with(['state.region.institutions', 'state.institutions', 'category'])
        ->get();
}

test('returns array keyed by institution id', function () {
    $inst = ($this->make)($this->state1, 1);

    $result = $this->action->execute(rankedCollection($this->category));

    expect($result)->toHaveKey($inst->id);
});

test('each entry has institution, region, and state keys', function () {
    ($this->make)($this->state1, 1);

    $result = $this->action->execute(rankedCollection($this->category));

    $entry = array_values($result)[0];
    expect($entry)->toHaveKeys(['institution', 'region', 'state']);
});

test('returns false for all positions when institution has no rank', function () {
    $inst = ($this->make)($this->state1, null);

    $all = Institution::where('id', $inst->id)
        ->with(['state.region.institutions', 'state.institutions', 'category'])
        ->get();
    $result = $this->action->execute($all);

    expect($result[$inst->id]['institution'])->toBeFalse()
        ->and($result[$inst->id]['region'])->toBeFalse()
        ->and($result[$inst->id]['state'])->toBeFalse();
});

test('gives rank 1 everywhere when it is the only ranked institution', function () {
    $inst = ($this->make)($this->state1, 1);

    $result = $this->action->execute(rankedCollection($this->category));

    expect($result[$inst->id]['institution'])->toBe(1)
        ->and($result[$inst->id]['region'])->toBe(1)
        ->and($result[$inst->id]['state'])->toBe(1);
});

test('reflects the correct position in the national list', function () {
    ($this->make)($this->state1, 1);
    $inst2 = ($this->make)($this->state1, 2);
    ($this->make)($this->state2, 3);

    $result = $this->action->execute(rankedCollection($this->category));

    expect($result[$inst2->id]['institution'])->toBe(2);
});

test('scopes state rank to institutions in the same state', function () {
    ($this->make)($this->state1, 1);
    ($this->make)($this->state1, 2);
    $inst3 = ($this->make)($this->state2, 3);

    $result = $this->action->execute(rankedCollection($this->category));

    expect($result[$inst3->id]['institution'])->toBe(3)
        ->and($result[$inst3->id]['state'])->toBe(1);
});

test('does not count unranked institutions in any position', function () {
    $inst1 = ($this->make)($this->state1, 1);
    ($this->make)($this->state1, null);

    $result = $this->action->execute(rankedCollection($this->category));

    expect($result[$inst1->id]['institution'])->toBe(1)
        ->and($result[$inst1->id]['region'])->toBe(1)
        ->and($result[$inst1->id]['state'])->toBe(1);
});
