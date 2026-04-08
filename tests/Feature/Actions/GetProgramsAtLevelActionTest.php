<?php

use App\Actions\Program\GetProgramsAtLevelAction;
use App\Models\College;
use App\Models\Level;
use App\Models\Program;
use Illuminate\Support\Facades\Cache;

/** Attach $programs to $level via the level_program pivot table. */
function attachProgramsToLevel(Level $level, iterable $programs): void
{
    foreach ($programs as $program) {
        DB::table('level_program')->insert([
            'program_id' => $program->id,
            'level_id' => $level->id,
        ]);
    }
}

test('level with id 3 returns a flat collection sorted by name', function () {
    $level = Level::factory()->create(['id' => 3]);

    $programs = collect([
        Program::factory()->create(['name' => 'Zoology Studies']),
        Program::factory()->create(['name' => 'Anatomy Studies']),
        Program::factory()->create(['name' => 'Medicine Studies']),
    ]);

    attachProgramsToLevel($level, $programs);

    $result = (new GetProgramsAtLevelAction)->execute($level);

    expect($result->values()->first()->name)->toBe('Anatomy Studies');
    expect($result->values()->last()->name)->toBe('Zoology Studies');
});

test('level with id other than 3 returns programs grouped by college', function () {
    $level = Level::factory()->create();
    $collegeA = College::factory()->create(['name' => 'College of Arts']);
    $collegeB = College::factory()->create(['name' => 'College of Science']);

    $progA = Program::factory()->create(['college_id' => $collegeA->id]);
    $progB = Program::factory()->create(['college_id' => $collegeB->id]);

    attachProgramsToLevel($level, collect([$progA, $progB]));

    $result = (new GetProgramsAtLevelAction)->execute($level);

    expect($result)->toHaveKey('College of Arts')
        ->and($result)->toHaveKey('College of Science');
});

test('grouped result is sorted alphabetically by college name', function () {
    $level = Level::factory()->create();
    $collegeZ = College::factory()->create(['name' => 'Zoology College']);
    $collegeA = College::factory()->create(['name' => 'Arts College']);

    $progZ = Program::factory()->create(['college_id' => $collegeZ->id]);
    $progA = Program::factory()->create(['college_id' => $collegeA->id]);

    attachProgramsToLevel($level, collect([$progZ, $progA]));

    $result = (new GetProgramsAtLevelAction)->execute($level);

    expect($result->keys()->first())->toBe('Arts College');
});

test('programs within each college group are sorted by name', function () {
    $level = Level::factory()->create();
    $college = College::factory()->create(['name' => 'College of Arts']);

    $progZ = Program::factory()->create(['name' => 'Zoology Studies', 'college_id' => $college->id]);
    $progA = Program::factory()->create(['name' => 'Anatomy Studies', 'college_id' => $college->id]);

    attachProgramsToLevel($level, collect([$progZ, $progA]));

    $result = (new GetProgramsAtLevelAction)->execute($level);

    $group = $result->get('College of Arts');
    expect($group->values()->first()->name)->toBe('Anatomy Studies');
});

test('returns empty collection when level has no programs', function () {
    $level = Level::factory()->create();

    $result = (new GetProgramsAtLevelAction)->execute($level);

    expect($result)->toBeEmpty();
});

test('result is cached for one hour', function () {
    $level = Level::factory()->create();

    Cache::spy();

    (new GetProgramsAtLevelAction)->execute($level);

    Cache::shouldHaveReceived('remember')
        ->once()
        ->withArgs(fn ($key, $ttl) => $key === "level_{$level->id}_programs" && $ttl === 3600);
});

test('second call with same level returns cached result', function () {
    $level = Level::factory()->create();
    $college = College::factory()->create(['name' => 'College of Arts']);
    $prog = Program::factory()->create(['college_id' => $college->id]);

    attachProgramsToLevel($level, collect([$prog]));

    $action = new GetProgramsAtLevelAction;
    $first = $action->execute($level);

    // Add another program after first call.
    $prog2 = Program::factory()->create(['college_id' => $college->id]);
    attachProgramsToLevel($level, collect([$prog2]));

    $second = $action->execute($level);

    expect($first->flatten()->pluck('id')->sort()->values())
        ->toEqual($second->flatten()->pluck('id')->sort()->values());
});
