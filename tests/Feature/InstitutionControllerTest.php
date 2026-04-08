<?php

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

// Shared setup: create all required FK dependencies once per test.
beforeEach(function () {
    $region                    = Region::factory()->create();
    $this->state               = State::factory()->create(['region_id' => $region->id]);
    $this->categoryClass       = CategoryClass::factory()->create();
    $this->category            = Category::factory()->create(['category_class_id' => $this->categoryClass->id]);
    $this->term                = Term::factory()->create();
    $this->accBody             = AccreditationBody::factory()->create();
    $this->accStatus           = AccreditationStatus::factory()->create();
    $this->instType            = InstitutionType::factory()->create();
    $this->relAff              = ReligiousAffiliation::factory()->create();
    $this->instHead            = InstitutionHead::factory()->create();

    $this->createInstitution = fn (array $overrides = []) =>
        Institution::factory()->create(array_merge([
            'state_id'                 => $this->state->id,
            'category_id'              => $this->category->id,
            'term_id'                  => $this->term->id,
            'accreditation_body_id'    => $this->accBody->id,
            'accreditation_status_id'  => $this->accStatus->id,
            'institution_type_id'      => $this->instType->id,
            'religious_affiliation_id' => $this->relAff->id,
            'institution_head_id'      => $this->instHead->id,
        ], $overrides));
});

// -------------------------------------------------------------------------
// index
// -------------------------------------------------------------------------

it('institution index returns 200', function () {
    ($this->createInstitution)();
    $this->get(route('institutions.index'))->assertStatus(200);
});

it('institution index passes institutions to the view', function () {
    ($this->createInstitution)();
    $this->get(route('institutions.index'))->assertViewHas('institutions');
});

// -------------------------------------------------------------------------
// category
// -------------------------------------------------------------------------

it('category page returns 200', function () {
    ($this->createInstitution)();
    $this->get(route('institutions.categories.index', $this->categoryClass))->assertStatus(200);
});

it('category page only shows institutions belonging to that category class', function () {
    $otherCategoryClass = CategoryClass::factory()->create();
    $otherCategory      = Category::factory()->create(['category_class_id' => $otherCategoryClass->id]);

    $matching    = ($this->createInstitution)();
    $nonMatching = ($this->createInstitution)(['category_id' => $otherCategory->id]);

    $this->get(route('institutions.categories.index', $this->categoryClass))
        ->assertViewHas('institutions', function ($institutions) use ($matching, $nonMatching) {
            return $institutions->contains('id', $matching->id)
                && !$institutions->contains('id', $nonMatching->id);
        });
});

// -------------------------------------------------------------------------
// showLocation
// -------------------------------------------------------------------------

it('show location returns 200', function () {
    ($this->createInstitution)();
    $this->get(route('institutions.location.show', $this->state))->assertStatus(200);
});

it('show location only shows institutions in the requested state', function () {
    $otherState  = State::factory()->create(['region_id' => Region::factory()->create()->id]);
    $matching    = ($this->createInstitution)();
    $other       = ($this->createInstitution)(['state_id' => $otherState->id]);

    $this->get(route('institutions.location.show', $this->state))
        ->assertViewHas('institutions', function ($institutions) use ($matching, $other) {
            return $institutions->contains('id', $matching->id)
                && !$institutions->contains('id', $other->id);
        });
});

// -------------------------------------------------------------------------
// show
// -------------------------------------------------------------------------

it('show returns 200', function () {
    $institution = ($this->createInstitution)();
    $this->get(route('institutions.show', $institution))->assertStatus(200);
});

it('show passes the correct institution to the view', function () {
    $institution = ($this->createInstitution)();
    $this->get(route('institutions.show', $institution))
        ->assertViewHas('institution', fn ($v) => $v->id === $institution->id);
});

it('show computes rank for a ranked institution', function () {
    $institution = ($this->createInstitution)(['rank' => 1]);
    $this->get(route('institutions.show', $institution))
        ->assertViewHas('rank', fn ($rank) => $rank['institution'] === 1);
});

// -------------------------------------------------------------------------
// programs — level branching
// -------------------------------------------------------------------------

it('programs for level 3 returns a flat sorted collection', function () {
    $institution = ($this->createInstitution)();
    $level       = Level::factory()->create(['id' => 3]);
    $program     = Program::factory()->create();

    $institution->programs()->attach($program, [
        'level_id'              => $level->id,
        'accreditation_body_id' => $this->accBody->id,
    ]);

    $this->get(route('institutions.programs', [$institution, $level]))
        ->assertStatus(200)
        ->assertViewHas('programs', function ($programs) {
            // Level 3 returns a flat Collection (not nested by college key)
            return !($programs->first() instanceof \Illuminate\Support\Collection);
        });
});

it('programs for other levels are grouped by college name', function () {
    $institution = ($this->createInstitution)();
    $level       = Level::factory()->create();
    $college     = College::factory()->create(['name' => 'College of Engineering']);
    $program     = Program::factory()->create(['college_id' => $college->id]);

    $institution->programs()->attach($program, [
        'level_id'              => $level->id,
        'accreditation_body_id' => $this->accBody->id,
    ]);

    $this->get(route('institutions.programs', [$institution, $level]))
        ->assertStatus(200)
        ->assertViewHas('programs', fn ($programs) => $programs->has($college->name));
});

// -------------------------------------------------------------------------
// showProgram — 404 guard
// -------------------------------------------------------------------------

it('show program returns 404 when the program is not associated with the institution', function () {
    $institution = ($this->createInstitution)();
    $level       = Level::factory()->create();
    $program     = Program::factory()->create();

    // No pivot row → 404
    $this->get(route('institutions.program.show', [$institution, $level, $program]))
        ->assertStatus(404);
});

it('show program returns 200 when the program is associated', function () {
    $institution = ($this->createInstitution)();
    $level       = Level::factory()->create();
    $program     = Program::factory()->create();

    $institution->programs()->attach($program, [
        'level_id'              => $level->id,
        'accreditation_body_id' => $this->accBody->id,
    ]);

    $this->get(route('institutions.program.show', [$institution, $level, $program]))
        ->assertStatus(200);
});

// -------------------------------------------------------------------------
// institutionRanking
// -------------------------------------------------------------------------

it('institution ranking page returns 200', function () {
    ($this->createInstitution)(['rank' => 1]);
    $this->get(route('institutions.categories.ranking', $this->categoryClass))->assertStatus(200);
});

it('ranking view contains correct rank data', function () {
    $first  = ($this->createInstitution)(['rank' => 1]);
    $second = ($this->createInstitution)(['rank' => 2]);

    $this->get(route('institutions.categories.ranking', $this->categoryClass))
        ->assertViewHas('rank', function ($rank) use ($first, $second) {
            return $rank[$first->id]['institution'] === 1
                && $rank[$second->id]['institution'] === 2;
        });
});

it('ranking view passes null rank when no institutions have a rank', function () {
    ($this->createInstitution)(['rank' => null]);
    $this->get(route('institutions.categories.ranking', $this->categoryClass))
        ->assertViewHas('rank', null);
});
