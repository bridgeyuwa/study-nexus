<?php

namespace App\Queries;

use App\DTOs\SearchFiltersData;
use App\Models\Institution;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

final class InstitutionSearchQuery
{
    public function execute(SearchFiltersData $filters): LengthAwarePaginator
    {
        return Cache::remember($filters->cacheKey(), 60 * 60, function () use ($filters) {
            $query = Institution::query();

            // Institution Type filter
            if ($filters->typeSlug) {
                if ($filters->typeSlug == 'public') {
                    $query->whereHas('institutionType.institutionTypeCategory', function ($q) use ($filters) {
                        $q->where('slug', $filters->typeSlug);
                    });
                } elseif ($filters->typeSlug == 'federal' || $filters->typeSlug == 'state' || $filters->typeSlug == 'private') {
                    $query->whereHas('institutionType', function ($q) use ($filters) {
                        $q->where('slug', $filters->typeSlug);
                    });
                }
            }

            // Categories Filter
            if ($filters->categoryClass) {
                $query->whereHas('category.categoryClass', function ($q) use ($filters) {
                    $q->where('id', $filters->categoryClass->id);
                });
            }

            // Religious Affiliation Filter
            if ($filters->religiousAffiliationCategory) {
                $query->whereHas('religiousAffiliation.religiousAffiliationCategory', function ($q) use ($filters) {
                    $q->where('id', $filters->religiousAffiliationCategory->id);
                });
            }

            // State Filter
            if ($filters->state) {
                $query->where('state_id', $filters->state->id);
            }

            // Level Filter
            if ($filters->level) {
                $query->whereHas('levels', function ($q) use ($filters) {
                    $q->where('levels.id', $filters->level->id);
                });
            }

            // Program Filter
            if ($filters->program) {
                $query->whereHas('programs', function ($q) use ($filters) {
                    $q->where('programs.id', $filters->program->id);
                });
            }

            // Eager load program levels when only program is selected
            if (empty($filters->level) && ! empty($filters->program)) {
                $query->with([
                    'levels' => function ($q) use ($filters) {
                        $q->wherePivot('program_id', $filters->program->id);
                    },
                ]);
            }

            if (empty($filters->level) || empty($filters->program)) {
                $query->with([
                    'programs' => function ($q) use ($filters) {
                        if ($filters->program) {
                            $q->where('program_id', $filters->program->id);
                            if ($filters->level) {
                                $q->whereHas('levels', function ($q) use ($filters) {
                                    $q->where('levels.id', $filters->level->id);
                                });
                            }
                        }
                    },
                ]);
            }

            // Eager load common relationships
            $query->with([
                'state:id,name,is_state,code',
                'institutionType:id,name',
                'category:id,name',
            ]);

            // Sorting
            if ($filters->sortBy === 'rank') {
                $query->orderByRaw('rank IS NULL, rank');
            } elseif ($filters->sortBy === 'za') {
                $query->orderBy('name', 'desc');
            } else {
                $query->orderBy('name', 'asc');
            }

            return $query->paginate(30);
        });
    }
}
