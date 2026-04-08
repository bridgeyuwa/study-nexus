<?php

use App\DTOs\SearchFiltersData;
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
use App\Models\State;
use App\Models\Term;
use App\Queries\InstitutionSearchQuery;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

beforeEach(function () {
    $this->term = Term::factory()->create();
    $this->accBody = AccreditationBody::factory()->create();
    $this->accStatus = AccreditationStatus::factory()->create();
    $this->instHead = InstitutionHead::factory()->create();
    $catClass = CategoryClass::factory()->create();
    $this->category = Category::factory()->create(['category_class_id' => $catClass->id]);

    $this->make = fn (array $overrides = []) => Institution::factory()->create(array_merge([
        'state_id' => State::factory()->create(['region_id' => Region::factory()->create()->id])->id,
        'category_id' => $this->category->id,
        'term_id' => $this->term->id,
        'accreditation_body_id' => $this->accBody->id,
        'accreditation_status_id' => $this->accStatus->id,
        'institution_type_id' => InstitutionType::factory()->create()->id,
        'religious_affiliation_id' => ReligiousAffiliation::factory()->create()->id,
        'institution_head_id' => $this->instHead->id,
    ], $overrides));

    $this->query = new InstitutionSearchQuery;
});

function nullFilters(array $overrides = []): SearchFiltersData
{
    return new SearchFiltersData(
        state: $overrides['state'] ?? null,
        level: $overrides['level'] ?? null,
        program: $overrides['program'] ?? null,
        typeSlug: $overrides['typeSlug'] ?? '',
        categoryClass: $overrides['categoryClass'] ?? null,
        religiousAffiliationCategory: $overrides['religiousAffiliationCategory'] ?? null,
        sortBy: $overrides['sortBy'] ?? '',
        page: $overrides['page'] ?? 1,
    );
}

// -------------------------------------------------------------------------
// Basics
// -------------------------------------------------------------------------

test('all-null filters returns all institutions paginated', function () {
    $a = ($this->make)();
    $b = ($this->make)();

    $result = $this->query->execute(nullFilters());

    expect($result->items())->toHaveCount(2);
});

test('returns a LengthAwarePaginator', function () {
    $result = $this->query->execute(nullFilters());

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
});

// -------------------------------------------------------------------------
// State filter
// -------------------------------------------------------------------------

test('state filter returns only institutions in that state', function () {
    $region = Region::factory()->create();
    $targetState = State::factory()->create(['region_id' => $region->id]);
    $otherState = State::factory()->create(['region_id' => $region->id]);

    $matching = ($this->make)(['state_id' => $targetState->id]);
    $nonMatching = ($this->make)(['state_id' => $otherState->id]);

    $result = $this->query->execute(nullFilters(['state' => $targetState]));

    $ids = collect($result->items())->pluck('id');
    expect($ids)->toContain($matching->id)
        ->not->toContain($nonMatching->id);
});

// -------------------------------------------------------------------------
// Level filter
// -------------------------------------------------------------------------

test('level filter returns only institutions offering that level', function () {
    $institution = ($this->make)();
    $other = ($this->make)();
    $level = Level::factory()->create();
    $program = Program::factory()->create();

    $institution->programs()->attach($program, [
        'level_id' => $level->id,
        'accreditation_body_id' => $this->accBody->id,
    ]);

    $result = $this->query->execute(nullFilters(['level' => $level]));

    $ids = collect($result->items())->pluck('id');
    expect($ids)->toContain($institution->id)
        ->not->toContain($other->id);
});

// -------------------------------------------------------------------------
// Program filter
// -------------------------------------------------------------------------

test('program filter returns only institutions offering that program', function () {
    $institution = ($this->make)();
    $other = ($this->make)();
    $level = Level::factory()->create();
    $program = Program::factory()->create();

    $institution->programs()->attach($program, [
        'level_id' => $level->id,
        'accreditation_body_id' => $this->accBody->id,
    ]);

    $result = $this->query->execute(nullFilters(['program' => $program]));

    $ids = collect($result->items())->pluck('id');
    expect($ids)->toContain($institution->id)
        ->not->toContain($other->id);
});

// -------------------------------------------------------------------------
// Type filter
// -------------------------------------------------------------------------

test('type=public filters by institution type category slug', function () {
    $publicTypeCat = InstitutionTypeCategory::factory()->create(['slug' => 'public']);
    $publicType = InstitutionType::factory()->create(['institution_type_category_id' => $publicTypeCat->id]);
    $privateTypeCat = InstitutionTypeCategory::factory()->create(['slug' => 'private-cat']);
    $privateType = InstitutionType::factory()->create(['institution_type_category_id' => $privateTypeCat->id]);

    $publicInst = ($this->make)(['institution_type_id' => $publicType->id]);
    $privateInst = ($this->make)(['institution_type_id' => $privateType->id]);

    $result = $this->query->execute(nullFilters(['typeSlug' => 'public']));

    $ids = collect($result->items())->pluck('id');
    expect($ids)->toContain($publicInst->id)
        ->not->toContain($privateInst->id);
});

test('type=federal filters by institution type slug', function () {
    $federalType = InstitutionType::factory()->create(['slug' => 'federal']);
    $otherType = InstitutionType::factory()->create(['slug' => 'other']);

    $federal = ($this->make)(['institution_type_id' => $federalType->id]);
    $other = ($this->make)(['institution_type_id' => $otherType->id]);

    $result = $this->query->execute(nullFilters(['typeSlug' => 'federal']));

    $ids = collect($result->items())->pluck('id');
    expect($ids)->toContain($federal->id)
        ->not->toContain($other->id);
});

// -------------------------------------------------------------------------
// Sorting
// -------------------------------------------------------------------------

test('default sort orders by name ascending', function () {
    ($this->make)(['name' => 'Zeta University']);
    ($this->make)(['name' => 'Alpha University']);

    $result = $this->query->execute(nullFilters());

    expect(collect($result->items())->first()->name)->toBe('Alpha University');
});

test('sort=za orders by name descending', function () {
    ($this->make)(['name' => 'Alpha University']);
    ($this->make)(['name' => 'Zeta University']);

    $result = $this->query->execute(nullFilters(['sortBy' => 'za']));

    expect(collect($result->items())->first()->name)->toBe('Zeta University');
});

test('sort=rank places ranked institutions before unranked', function () {
    $ranked = ($this->make)(['rank' => 1,    'name' => 'Zeta University']);
    $unranked = ($this->make)(['rank' => null,  'name' => 'Alpha University']);

    $result = $this->query->execute(nullFilters(['sortBy' => 'rank']));

    expect(collect($result->items())->first()->id)->toBe($ranked->id);
});

// -------------------------------------------------------------------------
// Caching
// -------------------------------------------------------------------------

test('result is cached using the filter cache key', function () {
    $filters = nullFilters();

    Cache::spy();

    $this->query->execute($filters);

    Cache::shouldHaveReceived('remember')
        ->once()
        ->withArgs(fn ($key) => $key === $filters->cacheKey());
});

test('different state filters produce independent cached result sets', function () {
    $region = Region::factory()->create();
    $state1 = State::factory()->create(['region_id' => $region->id]);
    $state2 = State::factory()->create(['region_id' => $region->id]);

    $inst1 = ($this->make)(['state_id' => $state1->id]);
    $inst2 = ($this->make)(['state_id' => $state2->id]);

    $result1 = $this->query->execute(nullFilters(['state' => $state1]));
    $result2 = $this->query->execute(nullFilters(['state' => $state2]));

    $ids1 = collect($result1->items())->pluck('id');
    $ids2 = collect($result2->items())->pluck('id');

    expect($ids1)->toContain($inst1->id)->not->toContain($inst2->id);
    expect($ids2)->toContain($inst2->id)->not->toContain($inst1->id);
});
