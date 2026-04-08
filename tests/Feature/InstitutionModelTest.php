<?php

namespace Tests\Feature;

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
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InstitutionModelTest extends TestCase
{
    use RefreshDatabase;

    private Region $region;
    private State $state;
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
    }

    private function createInstitution(array $overrides = []): Institution
    {
        return Institution::factory()->create(array_merge([
            'state_id'                 => $this->state->id,
            'category_id'              => $this->category->id,
            'term_id'                  => $this->term->id,
            'accreditation_body_id'    => $this->accreditationBody->id,
            'accreditation_status_id'  => $this->accreditationStatus->id,
            'institution_type_id'      => $this->institutionType->id,
            'religious_affiliation_id' => $this->religiousAffiliation->id,
            'institution_head_id'      => $this->institutionHead->id,
        ], $overrides));
    }

    // -------------------------------------------------------------------------
    // Basic relationships
    // -------------------------------------------------------------------------

    public function test_institution_belongs_to_state(): void
    {
        $institution = $this->createInstitution();

        $this->assertNotNull($institution->state);
        $this->assertEquals($this->state->id, $institution->state->id);
    }

    public function test_institution_belongs_to_category(): void
    {
        $institution = $this->createInstitution();

        $this->assertNotNull($institution->category);
        $this->assertEquals($this->category->id, $institution->category->id);
    }

    public function test_institution_belongs_to_institution_type(): void
    {
        $institution = $this->createInstitution();

        $this->assertNotNull($institution->institutionType);
        $this->assertEquals($this->institutionType->id, $institution->institutionType->id);
    }

    // -------------------------------------------------------------------------
    // Self-referential: parent / child
    // -------------------------------------------------------------------------

    public function test_parent_institution_relationship_resolves_via_parent_id(): void
    {
        $parent = $this->createInstitution();
        $child  = $this->createInstitution(['parent_id' => $parent->id]);

        $this->assertNotNull($child->parentInstitution);
        $this->assertEquals($parent->id, $child->parentInstitution->id);
    }

    public function test_child_institutions_relationship_returns_correct_children(): void
    {
        $parent = $this->createInstitution();
        $child1 = $this->createInstitution(['parent_id' => $parent->id]);
        $child2 = $this->createInstitution(['parent_id' => $parent->id]);
        /*unrelated*/ $this->createInstitution(['parent_id' => null]);

        $children = $parent->childInstitutions;

        $this->assertCount(2, $children);
        $this->assertTrue($children->contains('id', $child1->id));
        $this->assertTrue($children->contains('id', $child2->id));
    }

    public function test_institution_with_no_parent_has_null_parent_institution(): void
    {
        $institution = $this->createInstitution(['parent_id' => null]);

        $this->assertNull($institution->parentInstitution);
    }

    // -------------------------------------------------------------------------
    // Self-referential many-to-many: affiliatedInstitutions
    // -------------------------------------------------------------------------

    public function test_affiliated_institutions_uses_correct_pivot_table_and_foreign_keys(): void
    {
        $primary = $this->createInstitution();
        $related = $this->createInstitution();

        // Attach via the pivot using the documented FK column names
        $primary->affiliatedInstitutions()->attach($related->id);

        $affiliates = $primary->affiliatedInstitutions;

        $this->assertCount(1, $affiliates);
        $this->assertEquals($related->id, $affiliates->first()->id);
    }

    public function test_affiliated_institutions_relationship_is_not_bidirectional_by_default(): void
    {
        $primary = $this->createInstitution();
        $related = $this->createInstitution();

        $primary->affiliatedInstitutions()->attach($related->id);

        // The inverse relationship (related → primary) is NOT set up automatically
        $this->assertCount(0, $related->affiliatedInstitutions);
    }

    // -------------------------------------------------------------------------
    // Programs pivot
    // -------------------------------------------------------------------------

    public function test_programs_relationship_allows_access_to_pivot_attributes(): void
    {
        $institution = $this->createInstitution();
        $level       = Level::factory()->create();
        $program     = Program::factory()->create();

        $institution->programs()->attach($program, [
            'level_id'              => $level->id,
            'accreditation_body_id' => $this->accreditationBody->id,
            'tuition_fee'           => 50000,
        ]);

        $attached = $institution->programs()->first();

        $this->assertNotNull($attached);
        $this->assertEquals(50000, $attached->pivot->tuition_fee);
        $this->assertEquals($level->id, $attached->pivot->level_id);
    }

    public function test_levels_relationship_returns_levels_through_institution_program_pivot(): void
    {
        $institution = $this->createInstitution();
        $level       = Level::factory()->create();
        $program     = Program::factory()->create();

        $institution->programs()->attach($program, [
            'level_id'              => $level->id,
            'accreditation_body_id' => $this->accreditationBody->id,
        ]);

        $levels = $institution->levels;

        $this->assertTrue($levels->contains('id', $level->id));
    }

    // -------------------------------------------------------------------------
    // News relationship
    // -------------------------------------------------------------------------

    public function test_news_relationship_returns_news_belonging_to_institution(): void
    {
        $institution  = $this->createInstitution();
        $news         = \App\Models\News::factory()->create(['institution_id' => $institution->id]);
        $unrelatedNews = \App\Models\News::factory()->create(['institution_id' => null]);

        $institutionNews = $institution->news;

        $this->assertCount(1, $institutionNews);
        $this->assertEquals($news->id, $institutionNews->first()->id);
    }

    // -------------------------------------------------------------------------
    // Route key (HasSelfHealingUrls)
    // -------------------------------------------------------------------------

    public function test_route_key_includes_institution_name_as_slug(): void
    {
        $institution = $this->createInstitution(['name' => 'University of Lagos']);
        $routeKey    = $institution->getRouteKey();

        // Route key should contain the slugified name
        $this->assertStringContainsString('university-of-lagos', $routeKey);
        // And the model's actual primary key at the end
        $this->assertStringEndsWith((string) $institution->id, $routeKey);
    }
}
