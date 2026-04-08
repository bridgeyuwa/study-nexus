<?php

use App\Models\AccreditationBody;
use App\Models\AccreditationStatus;
use App\Models\Category;
use App\Models\CategoryClass;
use App\Models\Institution;
use App\Models\InstitutionHead;
use App\Models\InstitutionType;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Region;
use App\Models\ReligiousAffiliation;
use App\Models\State;
use App\Models\Term;

beforeEach(function () {
    $region                  = Region::factory()->create();
    $state                   = State::factory()->create(['region_id' => $region->id]);
    $categoryClass           = CategoryClass::factory()->create();
    $category                = Category::factory()->create(['category_class_id' => $categoryClass->id]);
    $term                    = Term::factory()->create();
    $this->accBody           = AccreditationBody::factory()->create();
    $accStatus               = AccreditationStatus::factory()->create();
    $instType                = InstitutionType::factory()->create();
    $relAff                  = ReligiousAffiliation::factory()->create();
    $instHead                = InstitutionHead::factory()->create();

    $this->institution = Institution::factory()->create([
        'state_id'                 => $state->id,
        'category_id'              => $category->id,
        'term_id'                  => $term->id,
        'accreditation_body_id'    => $this->accBody->id,
        'accreditation_status_id'  => $accStatus->id,
        'institution_type_id'      => $instType->id,
        'religious_affiliation_id' => $relAff->id,
        'institution_head_id'      => $instHead->id,
    ]);
});

// -------------------------------------------------------------------------
// index
// -------------------------------------------------------------------------

it('news index returns 200', function () {
    $this->get(route('news.index'))->assertStatus(200);
});

it('news index passes news collection to the view', function () {
    News::factory()->create();
    $this->get(route('news.index'))->assertViewHas('news');
});

// -------------------------------------------------------------------------
// show
// -------------------------------------------------------------------------

it('news show returns 200', function () {
    $news = News::factory()->create();
    $this->get(route('news.show', $news))->assertStatus(200);
});

it('news show attaches a read time to the news item', function () {
    $news = News::factory()->create([
        'content' => implode(' ', array_fill(0, 200, 'word')),
    ]);

    $this->get(route('news.show', $news))
        ->assertViewHas('news', fn ($n) => $n->readTime == 1); // ceil() returns float
});

it('news show includes similar news in the view', function () {
    $category = NewsCategory::factory()->create();
    $news     = News::factory()->create();
    $news->newsCategories()->attach($category);

    $similar = News::factory()->create();
    $similar->newsCategories()->attach($category);

    $this->get(route('news.show', $news))->assertViewHas('similarNews');
});

// -------------------------------------------------------------------------
// showByInstitution — 404 guard
// -------------------------------------------------------------------------

it('show by institution returns 200 when the news belongs to that institution', function () {
    $news = News::factory()->create(['institution_id' => $this->institution->id]);

    $this->get(route('institutions.news.show', [$this->institution, $news]))
        ->assertStatus(200);
});

it('show by institution returns 404 when the news belongs to a different institution', function () {
    $other = Institution::factory()->create([
        'state_id'                 => State::factory()->create(['region_id' => Region::factory()->create()->id])->id,
        'category_id'              => Category::factory()->create(['category_class_id' => CategoryClass::factory()->create()->id])->id,
        'term_id'                  => Term::factory()->create()->id,
        'accreditation_body_id'    => $this->accBody->id,
        'accreditation_status_id'  => AccreditationStatus::factory()->create()->id,
        'institution_type_id'      => InstitutionType::factory()->create()->id,
        'religious_affiliation_id' => ReligiousAffiliation::factory()->create()->id,
        'institution_head_id'      => InstitutionHead::factory()->create()->id,
    ]);

    $news = News::factory()->create(['institution_id' => $other->id]);

    $this->get(route('institutions.news.show', [$this->institution, $news]))
        ->assertStatus(404);
});

// -------------------------------------------------------------------------
// showByNewsCategory — 404 guard
// -------------------------------------------------------------------------

it('show by news category returns 200 for the correct category', function () {
    $category = NewsCategory::factory()->create();
    $news     = News::factory()->create();
    $news->newsCategories()->attach($category);

    $this->get(route('news.newsCategory.show', [$category, $news]))->assertStatus(200);
});

it('show by news category returns 404 when the news is not in that category', function () {
    $category      = NewsCategory::factory()->create();
    $otherCategory = NewsCategory::factory()->create();
    $news          = News::factory()->create();
    $news->newsCategories()->attach($otherCategory);

    $this->get(route('news.newsCategory.show', [$category, $news]))->assertStatus(404);
});

// -------------------------------------------------------------------------
// indexByInstitution
// -------------------------------------------------------------------------

it('index by institution returns 200', function () {
    $this->get(route('institutions.news', $this->institution))->assertStatus(200);
});

it('index by institution shows only that institution\'s news', function () {
    $ownNews   = News::factory()->create(['institution_id' => $this->institution->id]);
    $otherNews = News::factory()->create(['institution_id' => null]);

    $this->get(route('institutions.news', $this->institution))
        ->assertViewHas('news', fn ($n) =>
            $n->contains('id', $ownNews->id) && !$n->contains('id', $otherNews->id)
        );
});
