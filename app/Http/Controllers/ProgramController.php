<?php

namespace App\Http\Controllers;

use App\Actions\BuildShareLinksAction;
use App\Actions\Program\GetProgramsAtLevelAction;
use App\Models\Level;
use App\Models\Program;
use Illuminate\Support\Facades\Cache;
use RalphJSmit\Laravel\SEO\Support\SEOData;

final class ProgramController extends Controller
{
    public function __construct(
        private readonly GetProgramsAtLevelAction $getProgramsAtLevel,
        private readonly BuildShareLinksAction $buildShareLinks,
    ) {}

    /* list programs at a particular Level of study */
    public function index(Level $level)
    {
        $programs = $this->getProgramsAtLevel->execute($level);

        $program_levels = Cache::remember('all_levels', 60 * 60, function () {
            return Level::all();
        });

        $SEOData = new SEOData(
            title: "{$level->name} Programmes in Nigeria",
            description: "Discover {$level->name} programmes across academic institutions in Nigeria. Compare and choose the best programme for your academic journey.",
        );

        $shareLinks = $this->buildShareLinks->execute();

        return view('program.index', compact('programs', 'level', 'program_levels', 'SEOData', 'shareLinks'));
    }

    /* show a programme of a level of study */
    public function show(Level $level, Program $program)
    {
        $cacheKey = "level_{$level->id}_program_{$program->id}";

        $level_programs = Cache::remember($cacheKey, 60 * 60, function () use ($level, $program) {
            return $level->programs()->where('program_id', $program->id)->get();
        }); // for tuition min/max calculation

        $program = Cache::remember("program_{$program->id}_at_level_{$level->id}", 60 * 60, function () use ($level, $program) {
            return $level->__programs()
                ->where('program_id', $program->id)
                ->withCount(['institutions' => function ($query) use ($level) {
                    $query->where('level_id', $level->id);
                }])->first();
        });

        if (! $program) {
            abort(404);
        }

        $program_levels = Cache::remember("program_{$program->id}_levels", 60 * 60, function () use ($program) {
            return $program->__levels()->get();
        });

        $SEOData = new SEOData(
            title: "{$program->name} {$level->name}  in Nigeria",
            description: "Detailed information about {$level->name} in {$program->name}",
        );

        $shareLinks = $this->buildShareLinks->execute();

        return view('program.show', compact('level', 'program', 'level_programs', 'program_levels', 'SEOData', 'shareLinks'));
    }

    /* list institutions which have a program */
    public function institutions(Level $level, Program $program)
    {
        $cacheKey = "program_{$program->id}_institutions_level_{$level->id}_page_".request('page', 1);

        $institutions = Cache::remember($cacheKey, 60 * 60, function () use ($program, $level) {
            return $program->institutions()
                ->with(['institutionType', 'category', 'state'])
                ->wherePivot('level_id', $level->id)
                ->orderBy('name')
                ->paginate(60);
        });

        $program_levels = Cache::remember("program_{$program->id}_levels", 60 * 60, function () use ($program) {
            return $program->__levels()->get();
        });

        $SEOData = new SEOData(
            title: "Academic Institutions Offering {$level->name} in {$program->name} in Nigeria",
            description: "Academic institutions offering {$level->name} in {$program->name} Explore the collection of institutions to make informed decisions.",
        );

        $shareLinks = $this->buildShareLinks->execute();

        return view('program.institutions', compact('level', 'program', 'institutions', 'program_levels', 'SEOData', 'shareLinks'));
    }
}
