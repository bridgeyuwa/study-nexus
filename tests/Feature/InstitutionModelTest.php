<?php

use App\Models\AccreditationBody;
use App\Models\AccreditationStatus;
use App\Models\Category;
use App\Models\CategoryClass;
use App\Models\Institution;
use App\Models\InstitutionHead;
use App\Models\InstitutionType;
use App\Models\Level;
use App\Models\Program;
use App\Models\Region;
use App\Models\ReligiousAffiliation;
use App\Models\State;
use App\Models\Term;

beforeEach(function () {
    $this->region               = Region::factory()->create();
    $this->state                = State::factory()->create(['region_id' => $this->region->id]);
    $categoryClass              = CategoryClass::factory()->create();
    $this->category             = Category::factory()->create(['category_class_id' => $categoryClass->id]);
    $this->term                 = Term::factory()->create();
    $this->accreditationBody    = AccreditationBody::factory()->create();
    $this->accreditationStatus  = AccreditationStatus::factory()->create();
    $this->institutionType      = InstitutionType::factory()->create();
    $this->religiousAffiliation = ReligiousAffiliation::factory()->create();
    $this->institutionHead      = InstitutionHead::factory()->create();

    $this->createInstitution = fn (array $overrides = []) =>
        Institution::factory()->create(array_merge([
            'state_id'                 => $this->state->id,
            'category_id'              => $this->category->id,
            'term_id'                  => $this->term->id,
            'accreditation_body_id'    => $this->accreditationBody->id,
            'accreditation_status_id'  => $this->accreditationStatus->id,
            'institution_type_id'      => $this->institutionType->id,
            'religious_affiliation_id' => $this->religiousAffiliation->id,
            'institution_head_id'      => $this->institutionHead->id,
        ], $overrides));
});

// -------------------------------------------------------------------------
// Basic relationships
// -------------------------------------------------------------------------

it('institution belongs to state', function () {
    $institution = ($this->createInstitution)();

    expect($institution->state)->not->toBeNull()
        ->and($institution->state->id)->toBe($this->state->id);
});

it('institution belongs to category', function () {
    $institution = ($this->createInstitution)();

    expect($institution->category)->not->toBeNull()
        ->and($institution->category->id)->toBe($this->category->id);
});

it('institution belongs to institution type', function () {
    $institution = ($this->createInstitution)();

    expect($institution->institutionType)->not->toBeNull()
        ->and($institution->institutionType->id)->toBe($this->institutionType->id);
});

// -------------------------------------------------------------------------
// Self-referential: parent / child
// -------------------------------------------------------------------------

it('parent institution relationship resolves via parent_id', function () {
    $parent = ($this->createInstitution)();
    $child  = ($this->createInstitution)(['parent_id' => $parent->id]);

    expect($child->parentInstitution)->not->toBeNull()
        ->and($child->parentInstitution->id)->toBe($parent->id);
});

it('child institutions relationship returns correct children', function () {
    $parent = ($this->createInstitution)();
    $child1 = ($this->createInstitution)(['parent_id' => $parent->id]);
    $child2 = ($this->createInstitution)(['parent_id' => $parent->id]);
    ($this->createInstitution)(['parent_id' => null]); // unrelated

    $children = $parent->childInstitutions;

    expect($children)->toHaveCount(2)
        ->and($children->contains('id', $child1->id))->toBeTrue()
        ->and($children->contains('id', $child2->id))->toBeTrue();
});

it('institution with no parent has null parentInstitution', function () {
    $institution = ($this->createInstitution)(['parent_id' => null]);

    expect($institution->parentInstitution)->toBeNull();
});

// -------------------------------------------------------------------------
// Self-referential many-to-many: affiliatedInstitutions
// -------------------------------------------------------------------------

it('affiliated institutions uses correct pivot table and foreign keys', function () {
    $primary = ($this->createInstitution)();
    $related = ($this->createInstitution)();

    $primary->affiliatedInstitutions()->attach($related->id);

    $affiliates = $primary->affiliatedInstitutions;

    expect($affiliates)->toHaveCount(1)
        ->and($affiliates->first()->id)->toBe($related->id);
});

it('affiliated institutions relationship is not bidirectional by default', function () {
    $primary = ($this->createInstitution)();
    $related = ($this->createInstitution)();

    $primary->affiliatedInstitutions()->attach($related->id);

    expect($related->affiliatedInstitutions)->toHaveCount(0);
});

// -------------------------------------------------------------------------
// Programs pivot
// -------------------------------------------------------------------------

it('programs relationship allows access to pivot attributes', function () {
    $institution = ($this->createInstitution)();
    $level       = Level::factory()->create();
    $program     = Program::factory()->create();

    $institution->programs()->attach($program, [
        'level_id'              => $level->id,
        'accreditation_body_id' => $this->accreditationBody->id,
        'tuition_fee'           => 50000,
    ]);

    $attached = $institution->programs()->first();

    expect($attached)->not->toBeNull()
        ->and($attached->pivot->tuition_fee)->toBe(50000)
        ->and($attached->pivot->level_id)->toBe($level->id);
});

it('levels relationship returns levels through institution program pivot', function () {
    $institution = ($this->createInstitution)();
    $level       = Level::factory()->create();
    $program     = Program::factory()->create();

    $institution->programs()->attach($program, [
        'level_id'              => $level->id,
        'accreditation_body_id' => $this->accreditationBody->id,
    ]);

    expect($institution->levels->contains('id', $level->id))->toBeTrue();
});

// -------------------------------------------------------------------------
// News relationship
// -------------------------------------------------------------------------

it('news relationship returns news belonging to institution', function () {
    $institution   = ($this->createInstitution)();
    $news          = \App\Models\News::factory()->create(['institution_id' => $institution->id]);
    \App\Models\News::factory()->create(['institution_id' => null]); // unrelated

    $institutionNews = $institution->news;

    expect($institutionNews)->toHaveCount(1)
        ->and($institutionNews->first()->id)->toBe($news->id);
});

// -------------------------------------------------------------------------
// Route key (HasSelfHealingUrls)
// -------------------------------------------------------------------------

it('route key includes institution name as slug', function () {
    $institution = ($this->createInstitution)(['name' => 'University of Lagos']);
    $routeKey    = $institution->getRouteKey();

    expect($routeKey)
        ->toContain('university-of-lagos')
        ->toEndWith((string) $institution->id);
});
