<?php

namespace Tests\Feature\Livewire;

use App\Livewire\SearchForm;
use App\Models\College;
use App\Models\Level;
use App\Models\Program;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;

class SearchFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Clear the array cache between tests so that stale 'all_levels' /
        // 'all_programs' / 'states' values from previous tests don't leak into
        // the component's mount() via Cache::remember().
        Cache::flush();
    }

    // -------------------------------------------------------------------------
    // mount — initial state
    // -------------------------------------------------------------------------

    public function test_mount_populates_levels(): void
    {
        $level = Level::factory()->create();

        Livewire::test(SearchForm::class)
            ->assertSet('levels', function ($levels) use ($level) {
                return $levels->contains('id', $level->id);
            });
    }

    public function test_mount_populates_programs_with_all_programs_when_no_level_in_request(): void
    {
        $program = Program::factory()->create();

        Livewire::test(SearchForm::class)
            ->assertSet('programs', function ($programs) use ($program) {
                return $programs->contains('id', $program->id);
            });
    }

    // -------------------------------------------------------------------------
    // updatedSelectedLevel
    // -------------------------------------------------------------------------

    public function test_selecting_a_level_filters_programs_to_that_levels_programs(): void
    {
        $level         = Level::factory()->create();
        $college       = College::factory()->create();
        $levelProgram  = Program::factory()->create(['college_id' => $college->id]);
        $otherProgram  = Program::factory()->create(['college_id' => $college->id]);

        // Associate levelProgram with the level via level_program pivot
        DB::table('level_program')->insert([
            'program_id' => $levelProgram->id,
            'level_id'   => $level->id,
        ]);

        // set() triggers updatedSelectedLevel() automatically in Livewire 3
        Livewire::test(SearchForm::class)
            ->set('selectedLevel', $level->id)
            ->assertSet('programs', function ($programs) use ($levelProgram, $otherProgram) {
                return $programs->contains('id', $levelProgram->id)
                    && !$programs->contains('id', $otherProgram->id);
            });
    }

    public function test_selecting_empty_level_shows_all_programs(): void
    {
        $level   = Level::factory()->create();
        $college = College::factory()->create();
        $prog1   = Program::factory()->create(['college_id' => $college->id]);
        $prog2   = Program::factory()->create(['college_id' => $college->id]);

        DB::table('level_program')->insert([
            'program_id' => $prog1->id,
            'level_id'   => $level->id,
        ]);

        Livewire::test(SearchForm::class)
            ->set('selectedLevel', $level->id) // narrow to level
            ->set('selectedLevel', '')          // clear it — triggers updatedSelectedLevel('')
            ->assertSet('programs', function ($programs) use ($prog1, $prog2) {
                return $programs->contains('id', $prog1->id)
                    && $programs->contains('id', $prog2->id);
            });
    }

    public function test_changing_level_resets_incompatible_selected_program(): void
    {
        $level1  = Level::factory()->create();
        $level2  = Level::factory()->create();
        $college = College::factory()->create();
        $prog1   = Program::factory()->create(['college_id' => $college->id]);
        $prog2   = Program::factory()->create(['college_id' => $college->id]);

        DB::table('level_program')->insert([
            ['program_id' => $prog1->id, 'level_id' => $level1->id],
            ['program_id' => $prog2->id, 'level_id' => $level2->id],
        ]);

        Livewire::test(SearchForm::class)
            ->set('selectedProgram', $prog1->id) // prog1 belongs to level1
            ->set('selectedLevel', $level2->id)  // switch to level2
            ->assertSet('selectedProgram', null); // prog1 not in level2 → reset
    }

    public function test_incompatible_program_is_cleared_when_level_changes(): void
    {
        // Covers the flash-and-reset code path in updatedSelectedLevel.
        // (Session flash cannot be directly asserted in Livewire 3 unit tests
        //  because Livewire disables the session middleware on AJAX requests;
        //  the reset of selectedProgram is the observable side effect we verify.)
        $level1  = Level::factory()->create();
        $level2  = Level::factory()->create();
        $college = College::factory()->create();
        $prog1   = Program::factory()->create(['college_id' => $college->id]);
        $prog2   = Program::factory()->create(['college_id' => $college->id]);

        DB::table('level_program')->insert([
            ['program_id' => $prog1->id, 'level_id' => $level1->id],
            ['program_id' => $prog2->id, 'level_id' => $level2->id],
        ]);

        // Before the level change, selectedProgram is set
        $component = Livewire::test(SearchForm::class)
            ->set('selectedProgram', $prog1->id)
            ->assertSet('selectedProgram', $prog1->id); // confirm it was set

        // After switching to an incompatible level, it must be cleared
        $component->set('selectedLevel', $level2->id)
            ->assertSet('selectedProgram', null);
    }

    public function test_changing_level_keeps_program_when_it_is_still_compatible(): void
    {
        $level1  = Level::factory()->create();
        $level2  = Level::factory()->create();
        $college = College::factory()->create();
        $program = Program::factory()->create(['college_id' => $college->id]);

        // program belongs to BOTH levels
        DB::table('level_program')->insert([
            ['program_id' => $program->id, 'level_id' => $level1->id],
            ['program_id' => $program->id, 'level_id' => $level2->id],
        ]);

        Livewire::test(SearchForm::class)
            ->set('selectedProgram', $program->id)
            ->set('selectedLevel', $level2->id)
            ->assertSet('selectedProgram', $program->id); // kept, still valid
    }

    // -------------------------------------------------------------------------
    // shouldDisableReligiousAffiliation
    // -------------------------------------------------------------------------

    public function test_religious_affiliation_is_disabled_for_public_type(): void
    {
        $result = Livewire::test(SearchForm::class)
            ->set('selectedType', 'public')
            ->call('shouldDisableReligiousAffiliation');

        $result->assertSet('selectedType', 'public');
        // Verify the method returns true for public type
        $component = $result->instance();
        $this->assertTrue($component->shouldDisableReligiousAffiliation());
    }

    public function test_religious_affiliation_is_disabled_for_federal_type(): void
    {
        $component = Livewire::test(SearchForm::class)
            ->set('selectedType', 'federal')
            ->instance();

        $this->assertTrue($component->shouldDisableReligiousAffiliation());
    }

    public function test_religious_affiliation_is_disabled_for_state_type(): void
    {
        $component = Livewire::test(SearchForm::class)
            ->set('selectedType', 'state')
            ->instance();

        $this->assertTrue($component->shouldDisableReligiousAffiliation());
    }

    public function test_religious_affiliation_is_not_disabled_for_private_type(): void
    {
        $component = Livewire::test(SearchForm::class)
            ->set('selectedType', 'private')
            ->instance();

        $this->assertFalse($component->shouldDisableReligiousAffiliation());
    }

    public function test_religious_affiliation_is_not_disabled_when_no_type_selected(): void
    {
        $component = Livewire::test(SearchForm::class)
            ->set('selectedType', '')
            ->instance();

        $this->assertFalse($component->shouldDisableReligiousAffiliation());
    }

    // -------------------------------------------------------------------------
    // clearFilters
    // -------------------------------------------------------------------------

    public function test_clear_filters_resets_type_category_religion_and_sort(): void
    {
        Livewire::test(SearchForm::class)
            ->set('selectedType', 'federal')
            ->set('selectedCategory', '5')
            ->set('selectedReligion', '2')
            ->set('selectedSort', 'rank')
            ->call('clearFilters')
            ->assertSet('selectedType', '')
            ->assertSet('selectedCategory', '')
            ->assertSet('selectedReligion', '')
            ->assertSet('selectedSort', '');
    }

    public function test_clear_filters_preserves_selected_program(): void
    {
        $college = College::factory()->create();
        $program = Program::factory()->create(['college_id' => $college->id]);

        Livewire::test(SearchForm::class)
            ->set('selectedProgram', $program->id)
            ->set('selectedType', 'federal')
            ->call('clearFilters')
            ->assertSet('selectedProgram', $program->id);
    }
}
