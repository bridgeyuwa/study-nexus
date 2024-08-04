<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institution;
use App\Models\State;
use App\Models\Program;
use App\Models\Level;
use App\Models\Category;
use App\Models\ReligiousAffiliationCategory;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $stateSlug = $request->input('location');
        $levelSlug = $request->input('level');
        $programId = $request->input('program');
        $typeSlug = $request->input('type');
        $categorySlug = $request->input('category');
        $religionSlug = $request->input('religion');
        $sortBy = $request->input('sort');

        $query = Institution::query();

        // Institution Type filter
        if ($typeSlug) {
            if ($typeSlug == "public") {
                $query->whereHas('institutionType.institutionTypeCategory', function ($q) use ($typeSlug) {
                    $q->where('slug', $typeSlug);
                });
            } else {
                $query->whereHas('institutionType', function ($q) use ($typeSlug) {
                    $q->where('slug', $typeSlug);
                });
            }
        }

        // Categories Filter
        $category = $categorySlug ? Category::where('slug', $categorySlug)->first() : null;
        if ($category) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Religious Affiliation Filter
        $religiousAffiliationCategory = $religionSlug ? ReligiousAffiliationCategory::where('slug', $religionSlug)->first() : null;
        if ($religiousAffiliationCategory) {
            $query->whereHas('religiousAffiliation.religiousAffiliationCategory', function ($q) use ($religionSlug) {
                $q->where('slug', $religionSlug);
            });
        }

        // State Filter
        $state = $stateSlug ? State::where('slug', $stateSlug)->first() : null;
        if ($state) {
            $query->where('state_id', $state->id);
        }

        // Level Filter
        $level = $levelSlug ? Level::where('slug', $levelSlug)->first() : null;
        if ($level) {
            $query->whereHas('levels', function ($q) use ($level) {
                $q->where('levels.id', $level->id);
            });
        }

        // Program Filter
        $program = $programId ? Program::find($programId) : null;
        if ($program) {
            $query->whereHas('programs', function ($q) use ($program) {
                $q->where('programs.id', $program->id);
            })->with([
                'levels' => function ($q) use ($program) {
                    $q->wherePivot('program_id', $program->id);
                }
            ]);
        }

        // Eager Load Relationships
        $query->with([
            'state:id,name,is_state,code',
            'institutionType:id,name',
            'category:id,name',
            'programs' => function ($q) use ($programId, $levelSlug) {
                if ($programId) {
                    $q->where('program_id', $programId);
                    if ($levelSlug) {
                        $level = Level::where('slug', $levelSlug)->first();
                        if ($level) {
                            $q->wherePivot('level_id', $level->id);
                        }
                    }
                }
            }
        ]);

        // Sorting
        if ($sortBy) {
            if ($sortBy == "rank") {
                $query->orderByRaw('rank IS NULL, rank');
            } elseif ($sortBy == "za") {
                $query->orderBy('name', 'desc');
            }
        } else {
            $query->orderBy('name', 'asc');
        }

        $institutions = $query->paginate(30);

        $SEOData = new SEOData(
            title: "Search Nigerian Academic Institutions and Programs",
            description: "Use our advanced search to find universities, polytechnics, monotechnics, colleges of education, etc., and course programs in Nigeria that match your criteria. Filter by location, study level, course program, and more."
        );

        return view('search', compact('institutions', 'program', 'state', 'level', 'SEOData'));
    }
}
