<?php

namespace App\Application\Search\Queries;

use App\Application\Search\Data\SearchInstitutionsData;
use App\Models\CategoryClass;
use App\Models\Institution;
use App\Models\Level;
use App\Models\Program;
use App\Models\ReligiousAffiliationCategory;
use App\Models\State;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

final class InstitutionSearchQuery
{
    public function execute(SearchInstitutionsData $data): LengthAwarePaginator
    {
        $state = $data->location ? State::find($data->location) : null;
        $level = $data->level ? Level::find($data->level) : null;
        $program = $data->program ? Program::find($data->program) : null;
        $categoryClass = $data->category ? CategoryClass::find($data->category) : null;
        $religiousAffiliationCategory = $data->religion ? ReligiousAffiliationCategory::find($data->religion) : null;

        $query = Institution::query();

        if ($data->type) {
            if ($data->type === 'public') {
                $query->whereHas('institutionType.institutionTypeCategory', fn (Builder $q) => $q->where('slug', $data->type));
            } else {
                $query->whereHas('institutionType', fn (Builder $q) => $q->where('slug', $data->type));
            }
        }

        if ($categoryClass) {
            $query->whereHas('category.categoryClass', fn (Builder $q) => $q->where('id', $categoryClass->id));
        }

        if ($religiousAffiliationCategory) {
            $query->whereHas('religiousAffiliation.religiousAffiliationCategory', fn (Builder $q) => $q->where('id', $religiousAffiliationCategory->id));
        }

        if ($state) {
            $query->where('state_id', $state->id);
        }

        if ($level) {
            $query->whereHas('levels', fn (Builder $q) => $q->where('levels.id', $level->id));
        }

        if ($program) {
            $query->whereHas('programs', fn (Builder $q) => $q->where('programs.id', $program->id));
        }

        if (empty($level) && ! empty($program)) {
            $query->with(['levels' => fn (Builder $q) => $q->wherePivot('program_id', $program->id)]);
        }

        if (empty($level) || empty($program)) {
            $query->with([
                'programs' => function (Builder $q) use ($program, $level): void {
                    if ($program) {
                        $q->where('program_id', $program->id);

                        if ($level) {
                            $q->whereHas('levels', fn (Builder $levelsQuery) => $levelsQuery->where('levels.id', $level->id));
                        }
                    }
                },
            ]);
        }

        $query->with([
            'state:id,name,is_state,code',
            'institutionType:id,name',
            'category:id,name',
        ]);

        if ($data->sort->value === 'rank') {
            $query->orderByRaw('rank IS NULL, rank');
        } elseif ($data->sort->value === 'za') {
            $query->orderByDesc('name');
        } else {
            $query->orderBy('name');
        }

        return $query->paginate(30);
    }
}
