<?php

namespace Tests\Feature;

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
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsControllerTest extends TestCase
{
    use RefreshDatabase;

    private Institution $institution;
    private AccreditationBody $accreditationBody;

    protected function setUp(): void
    {
        parent::setUp();

        $region                    = Region::factory()->create();
        $state                     = State::factory()->create(['region_id' => $region->id]);
        $categoryClass             = CategoryClass::factory()->create();
        $category                  = Category::factory()->create(['category_class_id' => $categoryClass->id]);
        $term                      = Term::factory()->create();
        $this->accreditationBody   = AccreditationBody::factory()->create();
        $accreditationStatus       = AccreditationStatus::factory()->create();
        $institutionType           = InstitutionType::factory()->create();
        $religiousAffiliation      = ReligiousAffiliation::factory()->create();
        $institutionHead           = InstitutionHead::factory()->create();

        $this->institution = Institution::factory()->create([
            'state_id'                 => $state->id,
            'category_id'              => $category->id,
            'term_id'                  => $term->id,
            'accreditation_body_id'    => $this->accreditationBody->id,
            'accreditation_status_id'  => $accreditationStatus->id,
            'institution_type_id'      => $institutionType->id,
            'religious_affiliation_id' => $religiousAffiliation->id,
            'institution_head_id'      => $institutionHead->id,
        ]);
    }

    // -------------------------------------------------------------------------
    // index
    // -------------------------------------------------------------------------

    public function test_news_index_returns_200(): void
    {
        $this->get(route('news.index'))->assertStatus(200);
    }

    public function test_news_index_passes_news_collection_to_view(): void
    {
        News::factory()->create();

        $this->get(route('news.index'))
            ->assertViewHas('news');
    }

    // -------------------------------------------------------------------------
    // show
    // -------------------------------------------------------------------------

    public function test_news_show_returns_200(): void
    {
        $news = News::factory()->create();

        $this->get(route('news.show', $news))->assertStatus(200);
    }

    public function test_news_show_attaches_read_time_to_news_item(): void
    {
        // 200 words of plain text → 1 minute read time
        $content = implode(' ', array_fill(0, 200, 'word'));
        $news    = News::factory()->create(['content' => $content]);

        $this->get(route('news.show', $news))
            ->assertViewHas('news', function ($viewNews) {
                // ceil() returns float; use == for type-coercing comparison
                return $viewNews->readTime == 1;
            });
    }

    public function test_news_show_includes_similar_news_in_view(): void
    {
        $category = NewsCategory::factory()->create();
        $news     = News::factory()->create();
        $news->newsCategories()->attach($category);

        $similar = News::factory()->create();
        $similar->newsCategories()->attach($category);

        $this->get(route('news.show', $news))
            ->assertViewHas('similarNews');
    }

    // -------------------------------------------------------------------------
    // showByInstitution — 404 guard
    // -------------------------------------------------------------------------

    public function test_show_by_institution_returns_200_for_matching_institution(): void
    {
        $news = News::factory()->create(['institution_id' => $this->institution->id]);

        $this->get(route('institutions.news.show', [$this->institution, $news]))
            ->assertStatus(200);
    }

    public function test_show_by_institution_returns_404_when_news_belongs_to_different_institution(): void
    {
        $region      = Region::factory()->create();
        $state       = State::factory()->create(['region_id' => $region->id]);
        $categoryClass = CategoryClass::factory()->create();
        $category    = Category::factory()->create(['category_class_id' => $categoryClass->id]);
        $term        = Term::factory()->create();
        $accStatus   = AccreditationStatus::factory()->create();
        $instType    = InstitutionType::factory()->create();
        $relAff      = ReligiousAffiliation::factory()->create();
        $instHead    = InstitutionHead::factory()->create();

        $otherInstitution = Institution::factory()->create([
            'state_id'                 => $state->id,
            'category_id'              => $category->id,
            'term_id'                  => $term->id,
            'accreditation_body_id'    => $this->accreditationBody->id,
            'accreditation_status_id'  => $accStatus->id,
            'institution_type_id'      => $instType->id,
            'religious_affiliation_id' => $relAff->id,
            'institution_head_id'      => $instHead->id,
        ]);

        // News belongs to otherInstitution, not $this->institution
        $news = News::factory()->create(['institution_id' => $otherInstitution->id]);

        $this->get(route('institutions.news.show', [$this->institution, $news]))
            ->assertStatus(404);
    }

    // -------------------------------------------------------------------------
    // showByNewsCategory — 404 guard
    // -------------------------------------------------------------------------

    public function test_show_by_news_category_returns_200_for_matching_category(): void
    {
        $category = NewsCategory::factory()->create();
        $news     = News::factory()->create();
        $news->newsCategories()->attach($category);

        $this->get(route('news.newsCategory.show', [$category, $news]))
            ->assertStatus(200);
    }

    public function test_show_by_news_category_returns_404_when_news_does_not_belong_to_category(): void
    {
        $category      = NewsCategory::factory()->create();
        $otherCategory = NewsCategory::factory()->create();
        $news          = News::factory()->create();

        // Attach news to otherCategory only
        $news->newsCategories()->attach($otherCategory);

        $this->get(route('news.newsCategory.show', [$category, $news]))
            ->assertStatus(404);
    }

    // -------------------------------------------------------------------------
    // indexByInstitution
    // -------------------------------------------------------------------------

    public function test_index_by_institution_returns_200(): void
    {
        $this->get(route('institutions.news', $this->institution))
            ->assertStatus(200);
    }

    public function test_index_by_institution_shows_only_institution_news(): void
    {
        $institutionNews = News::factory()->create(['institution_id' => $this->institution->id]);
        $otherNews       = News::factory()->create(['institution_id' => null]);

        $this->get(route('institutions.news', $this->institution))
            ->assertViewHas('news', function ($news) use ($institutionNews, $otherNews) {
                return $news->contains('id', $institutionNews->id)
                    && !$news->contains('id', $otherNews->id);
            });
    }
}
