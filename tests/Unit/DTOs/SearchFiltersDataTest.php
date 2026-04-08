<?php

use App\DTOs\SearchFiltersData;
use App\Models\CategoryClass;
use App\Models\Level;
use App\Models\Program;
use App\Models\ReligiousAffiliationCategory;
use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Build a SearchFiltersData with every field defaulting to null/empty. */
function makeFilters(array $overrides = []): SearchFiltersData
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

test('cache key contains null placeholders when all filters are null', function () {
    $key = makeFilters()->cacheKey();

    expect($key)
        ->toContain('location_null')
        ->toContain('level_null')
        ->toContain('program_null')
        ->toContain('type_null')
        ->toContain('category_null')
        ->toContain('religion_null');
});

test('cache key contains state id when state is set', function () {
    $state = State::factory()->make(['id' => 42]);

    $key = makeFilters(['state' => $state])->cacheKey();

    expect($key)->toContain('location_42');
});

test('cache key contains level id when level is set', function () {
    $level = Level::factory()->make(['id' => 7]);

    $key = makeFilters(['level' => $level])->cacheKey();

    expect($key)->toContain('level_7');
});

test('cache key contains program id when program is set', function () {
    $program = Program::factory()->make(['id' => 99]);

    $key = makeFilters(['program' => $program])->cacheKey();

    expect($key)->toContain('program_99');
});

test('cache key changes when state filter changes', function () {
    $stateA = State::factory()->make(['id' => 1]);
    $stateB = State::factory()->make(['id' => 2]);

    $keyA = makeFilters(['state' => $stateA])->cacheKey();
    $keyB = makeFilters(['state' => $stateB])->cacheKey();

    expect($keyA)->not->toBe($keyB);
});

test('cache key changes when sort changes', function () {
    $keyAz = makeFilters(['sortBy' => 'az'])->cacheKey();
    $keyZa = makeFilters(['sortBy' => 'za'])->cacheKey();

    expect($keyAz)->not->toBe($keyZa);
});

test('cache key includes page number', function () {
    $key = makeFilters(['page' => 3])->cacheKey();

    expect($key)->toContain('3');
});

test('default page is 1', function () {
    $dto = makeFilters();

    expect($dto->page)->toBe(1);
});

test('two identical filter sets produce the same cache key', function () {
    $state = State::factory()->make(['id' => 5]);

    $keyA = makeFilters(['state' => $state, 'sortBy' => 'rank', 'page' => 2])->cacheKey();
    $keyB = makeFilters(['state' => $state, 'sortBy' => 'rank', 'page' => 2])->cacheKey();

    expect($keyA)->toBe($keyB);
});

test('cache key includes category class id when set', function () {
    $catClass = CategoryClass::factory()->make(['id' => 11]);

    $key = makeFilters(['categoryClass' => $catClass])->cacheKey();

    expect($key)->toContain('category_11');
});

test('cache key includes religious affiliation category id when set', function () {
    $relCat = ReligiousAffiliationCategory::factory()->make(['id' => 22]);

    $key = makeFilters(['religiousAffiliationCategory' => $relCat])->cacheKey();

    expect($key)->toContain('religion_22');
});
