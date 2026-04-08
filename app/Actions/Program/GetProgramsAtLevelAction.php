<?php

namespace App\Actions\Program;

use App\Models\Level;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class GetProgramsAtLevelAction
{
    /** Returns Collection sorted/grouped by college, respecting level 3 (postgraduate) special case */
    public function execute(Level $level): Collection
    {
        return Cache::remember("level_{$level->id}_programs", 60 * 60, function () use ($level) {
            $programs = $level->__programs()->with('college')->get();

            // Level 3 = postgraduate: flat sort by name only
            if ($level->id === 3) {
                return $programs->sortBy('name');
            }

            return $programs
                ->groupBy(fn ($program) => $program->college->name)
                ->sortKeys()
                ->map(fn ($group) => $group->sortBy(fn ($program) => $program->name));
        });
    }
}
