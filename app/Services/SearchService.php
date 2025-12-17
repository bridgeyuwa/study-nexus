<?php

namespace App\Services;

use App\Models\Institution;
use Illuminate\Http\Request;

class SearchService
{
    public function search(Request $request)
    {
        $query = Institution::query();

        // Institution Type filter
        if ($request->filled('type')) {
            $typeSlug = $request->input('type');
            if ($typeSlug == "public") {
                $query->whereHas('institutionType.institutionTypeCategory', function ($q) use ($typeSlug) {
                    $q->where('slug', $typeSlug);
                });
            } elseif (in_array($typeSlug, ['federal', 'state', 'private'])) {
                $query->whereHas('institutionType', function ($q) use ($typeSlug) {
                    $q->where('slug', $typeSlug);
                });
            }
        }

        // Categories Filter
        if ($request->filled('category')) {
            $query->whereHas('category.categoryClass', function ($q) use ($request) {
                $q->where('id', $request->input('category'));
            });
        }

        // Religious Affiliation Filter
        if ($request->filled('religion')) {
            $query->whereHas('religiousAffiliation.religiousAffiliationCategory', function ($q) use ($request) {
                $q->where('id', $request->input('religion'));
            });
        }

        // State Filter
        if ($request->filled('location')) {
            $query->where('state_id', $request->input('location'));
        }

        // Level Filter
        if ($request->filled('level')) {
            $query->whereHas('levels', function ($q) use ($request) {
                $q->where('levels.id', $request->input('level'));
            });
        }

        // Program Filter
        if ($request->filled('program')) {
            $query->whereHas('programs', function ($q) use ($request) {
                $q->where('programs.id', $request->input('program'));
            });
        }

        // Eager load the program levels when only program is selected
        if (! $request->filled('level') && $request->filled('program')) {
            $query->with([
                'levels' => function ($q) use ($request) {
                    $q->wherePivot('program_id', $request->input('program'));
                },
            ]);
        }

        if (! $request->filled('level') || ! $request->filled('program')) {
            $query->with([
                'programs' => function ($q) use ($request) {
                    if ($request->filled('program')) {
                        $q->where('program_id', $request->input('program'));
                        if ($request->filled('level')) {
                            $q->whereHas('levels', function ($q) use ($request) {
                                $q->where('levels.id', $request->input('level'));
                            });
                        }
                    }
                },
            ]);
        }

        // Eager Load common Relationships
        $query->with([
            'state:id,name,is_state,code',
            'institutionType:id,name',
            'category:id,name',
        ]);

        // Sorting
        $sortBy = $request->input('sort');
        if ($sortBy === "rank") {
            $query->orderByRaw('rank IS NULL, rank');
        } elseif ($sortBy === "za") {
            $query->orderBy('name', 'desc');
        } else {
            $query->orderBy('name', 'asc');
        }

        return $query->paginate(30)->appends($request->except('page'));
    }
}
