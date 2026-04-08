<?php

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

beforeEach(function () {
    $this->term       = Term::factory()->create();
    $this->accBody    = AccreditationBody::factory()->create();
    $this->accStatus  = AccreditationStatus::factory()->create();
    $this->instHead   = InstitutionHead::factory()->create();
    $categoryClass    = CategoryClass::factory()->create();
    $this->category   = Category::factory()->create(['category_class_id' => $categoryClass->id]);

    // Helper: create one institution with all required FKs satisfied.
    $this->make = fn (array $overrides = []) => Institution::factory()->create(array_merge([
        'state_id'                 => State::factory()->create(['region_id' => Region::factory()->create()->id])->id,
        'category_id'              => $this->category->id,
        'term_id'                  => $this->term->id,
        'accreditation_body_id'    => $this->accBody->id,
        'accreditation_status_id'  => $this->accStatus->id,
        'institution_type_id'      => InstitutionType::factory()->create()->id,
        'religious_affiliation_id' => ReligiousAffiliation::factory()->create()->id,
        'institution_head_id'      => $this->instHead->id,
    ], $overrides));
});

// -------------------------------------------------------------------------
// Basics
// -------------------------------------------------------------------------

it('returns 200 with no filters applied', function () {
    $this->get(route('search'))->assertStatus(200);
});

it('returns all institutions when no filters are set', function () {
    $a = ($this->make)();
    $b = ($this->make)();

    $this->get(route('search'))
        ->assertViewHas('institutions', fn ($i) =>
            $i->contains('id', $a->id) && $i->contains('id', $b->id)
        );
});

// -------------------------------------------------------------------------
// Type filter
// -------------------------------------------------------------------------

it('type=public matches institutions whose type category slug is public', function () {
    $publicTypeCat  = InstitutionTypeCategory::factory()->create(['slug' => 'public']);
    $publicType     = InstitutionType::factory()->create(['institution_type_category_id' => $publicTypeCat->id]);
    $privateTypeCat = InstitutionTypeCategory::factory()->create(['slug' => 'private-cat']);
    $privateType    = InstitutionType::factory()->create(['institution_type_category_id' => $privateTypeCat->id]);

    $public  = ($this->make)(['institution_type_id' => $publicType->id]);
    $private = ($this->make)(['institution_type_id' => $privateType->id]);

    $this->get(route('search', ['type' => 'public']))
        ->assertViewHas('institutions', fn ($i) =>
            $i->contains('id', $public->id) && !$i->contains('id', $private->id)
        );
});

it('type=federal matches institutions whose institution type slug is federal', function () {
    $federalType = InstitutionType::factory()->create(['slug' => 'federal']);
    $otherType   = InstitutionType::factory()->create(['slug' => 'private']);

    $federal = ($this->make)(['institution_type_id' => $federalType->id]);
    $other   = ($this->make)(['institution_type_id' => $otherType->id]);

    $this->get(route('search', ['type' => 'federal']))
        ->assertViewHas('institutions', fn ($i) =>
            $i->contains('id', $federal->id) && !$i->contains('id', $other->id)
        );
});

it('sanitises an invalid type and returns all institutions', function () {
    $institution = ($this->make)();
    $this->get(route('search', ['type' => 'hacked_value']))
        ->assertStatus(200)
        ->assertViewHas('institutions', fn ($i) => $i->contains('id', $institution->id));
});

// -------------------------------------------------------------------------
// State filter
// -------------------------------------------------------------------------

it('location filter returns only institutions in the requested state', function () {
    $region      = Region::factory()->create();
    $targetState = State::factory()->create(['region_id' => $region->id]);
    $otherState  = State::factory()->create(['region_id' => $region->id]);

    $matching    = ($this->make)(['state_id' => $targetState->id]);
    $nonMatching = ($this->make)(['state_id' => $otherState->id]);

    $this->get(route('search', ['location' => $targetState->id]))
        ->assertViewHas('institutions', fn ($i) =>
            $i->contains('id', $matching->id) && !$i->contains('id', $nonMatching->id)
        );
});

// -------------------------------------------------------------------------
// Category filter
// -------------------------------------------------------------------------

it('category filter returns only institutions in the requested category class', function () {
    $otherCatClass = CategoryClass::factory()->create();
    $otherCat      = Category::factory()->create(['category_class_id' => $otherCatClass->id]);

    $matching    = ($this->make)();
    $nonMatching = ($this->make)(['category_id' => $otherCat->id]);

    $this->get(route('search', ['category' => $this->category->categoryClass->id]))
        ->assertViewHas('institutions', fn ($i) =>
            $i->contains('id', $matching->id) && !$i->contains('id', $nonMatching->id)
        );
});

// -------------------------------------------------------------------------
// Level / Program filters
// -------------------------------------------------------------------------

it('level filter returns only institutions that offer the requested level', function () {
    $institution = ($this->make)();
    $level       = Level::factory()->create();
    $program     = Program::factory()->create();

    $institution->programs()->attach($program, [
        'level_id'              => $level->id,
        'accreditation_body_id' => $this->accBody->id,
    ]);

    $noLevel = ($this->make)();

    $this->get(route('search', ['level' => $level->id]))
        ->assertViewHas('institutions', fn ($i) =>
            $i->contains('id', $institution->id) && !$i->contains('id', $noLevel->id)
        );
});

it('program filter returns only institutions that offer the requested program', function () {
    $institution = ($this->make)();
    $other       = ($this->make)();
    $level       = Level::factory()->create();
    $program     = Program::factory()->create();

    $institution->programs()->attach($program, [
        'level_id'              => $level->id,
        'accreditation_body_id' => $this->accBody->id,
    ]);

    $this->get(route('search', ['program' => $program->id]))
        ->assertViewHas('institutions', fn ($i) =>
            $i->contains('id', $institution->id) && !$i->contains('id', $other->id)
        );
});

// -------------------------------------------------------------------------
// Religious affiliation filter
// -------------------------------------------------------------------------

it('religion filter returns only institutions with the requested affiliation category', function () {
    $relCategory = ReligiousAffiliationCategory::factory()->create();
    $targetAffil = ReligiousAffiliation::factory()->create(['religious_affiliation_category_id' => $relCategory->id]);
    $otherAffil  = ReligiousAffiliation::factory()->create();

    $matching    = ($this->make)(['religious_affiliation_id' => $targetAffil->id]);
    $nonMatching = ($this->make)(['religious_affiliation_id' => $otherAffil->id]);

    $this->get(route('search', ['religion' => $relCategory->id]))
        ->assertViewHas('institutions', fn ($i) =>
            $i->contains('id', $matching->id) && !$i->contains('id', $nonMatching->id)
        );
});

// -------------------------------------------------------------------------
// Sorting
// -------------------------------------------------------------------------

it('default sort is A-Z by name', function () {
    ($this->make)(['name' => 'Zeta University']);
    ($this->make)(['name' => 'Alpha University']);

    $this->get(route('search'))
        ->assertViewHas('institutions', fn ($i) => $i->first()->name === 'Alpha University');
});

it('sort=za orders institutions Z-A', function () {
    ($this->make)(['name' => 'Alpha University']);
    ($this->make)(['name' => 'Zeta University']);

    $this->get(route('search', ['sort' => 'za']))
        ->assertViewHas('institutions', fn ($i) => $i->first()->name === 'Zeta University');
});

it('sort=rank places ranked institutions before unranked', function () {
    $ranked   = ($this->make)(['rank' => 1,    'name' => 'Zeta University']);
    ($this->make)(               ['rank' => null, 'name' => 'Alpha University']);

    $this->get(route('search', ['sort' => 'rank']))
        ->assertViewHas('institutions', fn ($i) => $i->first()->id === $ranked->id);
});

it('sanitises an invalid sort value and defaults to A-Z', function () {
    ($this->make)(['name' => 'Alpha University']);
    ($this->make)(['name' => 'Zeta University']);

    $this->get(route('search', ['sort' => 'bad_value']))
        ->assertStatus(200)
        ->assertViewHas('institutions', fn ($i) => $i->first()->name === 'Alpha University');
});

// -------------------------------------------------------------------------
// Cache key isolation
// -------------------------------------------------------------------------

it('different state filters return independent result sets', function () {
    $region = Region::factory()->create();
    $state1 = State::factory()->create(['region_id' => $region->id]);
    $state2 = State::factory()->create(['region_id' => $region->id]);

    $inst1 = ($this->make)(['state_id' => $state1->id]);
    $inst2 = ($this->make)(['state_id' => $state2->id]);

    $r1 = $this->get(route('search', ['location' => $state1->id]))->viewData('institutions');
    $r2 = $this->get(route('search', ['location' => $state2->id]))->viewData('institutions');

    expect($r1->contains('id', $inst1->id))->toBeTrue();
    expect($r1->contains('id', $inst2->id))->toBeFalse();
    expect($r2->contains('id', $inst2->id))->toBeTrue();
    expect($r2->contains('id', $inst1->id))->toBeFalse();
});
