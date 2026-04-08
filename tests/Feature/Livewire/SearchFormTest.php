<?php

use App\Livewire\SearchForm;
use App\Models\College;
use App\Models\Level;
use App\Models\Program;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;

beforeEach(function () {
    // Clear the array cache between tests so that stale 'all_levels' /
    // 'all_programs' / 'states' values from previous tests don't leak into
    // the component's mount() via Cache::remember().
    Cache::flush();
});

// -------------------------------------------------------------------------
// mount — initial state
// -------------------------------------------------------------------------

it('mount populates levels', function () {
    $level = Level::factory()->create();

    Livewire::test(SearchForm::class)
        ->assertSet('levels', fn ($levels) => $levels->contains('id', $level->id));
});

it('mount populates programs with all programs when no level in request', function () {
    $program = Program::factory()->create();

    Livewire::test(SearchForm::class)
        ->assertSet('programs', fn ($programs) => $programs->contains('id', $program->id));
});

// -------------------------------------------------------------------------
// updatedSelectedLevel
// -------------------------------------------------------------------------

it('selecting a level filters programs to that levels programs', function () {
    $level        = Level::factory()->create();
    $college      = College::factory()->create();
    $levelProgram = Program::factory()->create(['college_id' => $college->id]);
    $otherProgram = Program::factory()->create(['college_id' => $college->id]);

    // Associate levelProgram with the level via level_program pivot
    DB::table('level_program')->insert([
        'program_id' => $levelProgram->id,
        'level_id'   => $level->id,
    ]);

    // set() triggers updatedSelectedLevel() automatically in Livewire 3
    Livewire::test(SearchForm::class)
        ->set('selectedLevel', $level->id)
        ->assertSet('programs', fn ($programs) =>
            $programs->contains('id', $levelProgram->id)
            && !$programs->contains('id', $otherProgram->id)
        );
});

it('selecting empty level shows all programs', function () {
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
        ->assertSet('programs', fn ($programs) =>
            $programs->contains('id', $prog1->id)
            && $programs->contains('id', $prog2->id)
        );
});

it('changing level resets incompatible selected program', function () {
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
});

it('incompatible program is cleared when level changes', function () {
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
});

it('changing level keeps program when it is still compatible', function () {
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
});

// -------------------------------------------------------------------------
// shouldDisableReligiousAffiliation
// -------------------------------------------------------------------------

it('religious affiliation is disabled for public type', function () {
    $component = Livewire::test(SearchForm::class)
        ->set('selectedType', 'public')
        ->instance();

    expect($component->shouldDisableReligiousAffiliation())->toBeTrue();
});

it('religious affiliation is disabled for federal type', function () {
    $component = Livewire::test(SearchForm::class)
        ->set('selectedType', 'federal')
        ->instance();

    expect($component->shouldDisableReligiousAffiliation())->toBeTrue();
});

it('religious affiliation is disabled for state type', function () {
    $component = Livewire::test(SearchForm::class)
        ->set('selectedType', 'state')
        ->instance();

    expect($component->shouldDisableReligiousAffiliation())->toBeTrue();
});

it('religious affiliation is not disabled for private type', function () {
    $component = Livewire::test(SearchForm::class)
        ->set('selectedType', 'private')
        ->instance();

    expect($component->shouldDisableReligiousAffiliation())->toBeFalse();
});

it('religious affiliation is not disabled when no type selected', function () {
    $component = Livewire::test(SearchForm::class)
        ->set('selectedType', '')
        ->instance();

    expect($component->shouldDisableReligiousAffiliation())->toBeFalse();
});

// -------------------------------------------------------------------------
// clearFilters
// -------------------------------------------------------------------------

it('clear filters resets type category religion and sort', function () {
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
});

it('clear filters preserves selected program', function () {
    $college = College::factory()->create();
    $program = Program::factory()->create(['college_id' => $college->id]);

    Livewire::test(SearchForm::class)
        ->set('selectedProgram', $program->id)
        ->set('selectedType', 'federal')
        ->call('clearFilters')
        ->assertSet('selectedProgram', $program->id);
});
