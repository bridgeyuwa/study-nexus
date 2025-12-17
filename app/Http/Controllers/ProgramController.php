<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\GeneratesShareLinks;
use App\Http\Controllers\Concerns\ProvidesCache;
use App\Http\Controllers\Concerns\ProvidesSEO;
use App\Models\Level;
use App\Models\Program;

class ProgramController extends Controller
{
    use GeneratesShareLinks;
    use ProvidesCache;
    use ProvidesSEO;

    /* list programs at a particular Level of study */
    public function index(Level $level)
    {
        if ($level->id == 3) {
            $programs = $this->cache("level_{$level->id}_programs", 60 * 60, fn () => $level->__programs()->with('college')->get()
                ->sortBy('name'));
        } else {
            $programs = $this->cache("level_{$level->id}_programs", 60 * 60, fn () => $level->__programs()->with('college')->get()
                ->groupBy(fn ($program) => $program->college->name)
                ->sortKeys()
                ->map(fn ($group) => $group->sortBy(fn ($program) => $program->name)));
        }

        $program_levels = $this->cache('all_levels', 60 * 60, fn () => Level::all());

        $SEOData = $this->seo(
            title: "{$level->name} Programmes in Nigeria",
            description: "Discover {$level->name} programmes across academic institutions in Nigeria. Compare and choose the best programme for your academic journey.",
        );

        $shareLinks = $this->shareLinks();

        return view('program.index', compact('programs', 'level', 'program_levels', 'SEOData', 'shareLinks'));
    }

    /* show a programme of a level of study */
    public function show(Level $level, Program $program)
    {
        $cacheKey = "level_{$level->id}_program_{$program->id}";

        $level_programs = $this->cache($cacheKey, 60 * 60, fn () => $level->programs()->where('program_id', $program->id)->get()); //for tuition min/max calculation

        $program = $this->cache("program_{$program->id}_at_level_{$level->id}", 60 * 60, fn () => $level->__programs()
            ->where('program_id', $program->id)
            ->withCount(['institutions' => fn ($query) => $query->where('level_id', $level->id)])->first());

        if (! $program) {
            abort(404);
        }

        $program_levels = $this->cache("program_{$program->id}_levels", 60 * 60, fn () => $program->__levels()->get());

        $SEOData = $this->seo(
            title: "{$program->name} {$level->name}  in Nigeria",
            description: "Detailed information about {$level->name} in {$program->name}",
        );

        $shareLinks = $this->shareLinks();

        return view('program.show', compact('level', 'program', 'level_programs', 'program_levels', 'SEOData', 'shareLinks'));
    }

    /* list institutions which have a program */
    public function institutions(Level $level, Program $program)
    {
        $cacheKey = "program_{$program->id}_institutions_level_{$level->id}_page_".request('page', 1);

        $institutions = $this->cache($cacheKey, 60 * 60, fn () => $program->institutions()
            ->with(['institutionType', 'category', 'state'])
            ->wherePivot('level_id', $level->id)
            ->orderBy('name')
            ->paginate(60));

        $program_levels = $this->cache("program_{$program->id}_levels", 60 * 60, fn () => $program->__levels()->get());

        $SEOData = $this->seo(
            title: "Academic Institutions Offering {$level->name} in {$program->name} in Nigeria",
            description: "Academic institutions offering {$level->name} in {$program->name} Explore the collection of institutions to make informed decisions.",
        );

        $shareLinks = $this->shareLinks();

        return view('program.institutions', compact('level', 'program', 'institutions', 'program_levels', 'SEOData', 'shareLinks'));
    }
}
