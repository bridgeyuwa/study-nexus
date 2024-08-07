<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institution;
use App\Models\State;
use App\Models\Program;
use App\Models\Level;
use App\Models\CategoryClass;
use App\Models\ReligiousAffiliationCategory;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $stateId = $request->input('location');
        $levelId = $request->input('level');
        $programId = $request->input('program');
        $typeSlug = $request->input('type');
        $categoryClassId = $request->input('category');
        $religionId = $request->input('religion');
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
        $categoryClass = $categoryClassId ? CategoryClass::find($categoryClassId) : null;
        if ($categoryClass) {
            $query->whereHas('category.categoryClass', function ($q) use ($categoryClassId) {
                $q->where('id', $categoryClassId);
            });
        }
		


        // Religious Affiliation Filter
        $religiousAffiliationCategory = $religionId ? ReligiousAffiliationCategory::find($religionId) : null;
        if ($religiousAffiliationCategory) {
            $query->whereHas('religiousAffiliation.religiousAffiliationCategory', function ($q) use ($religionId) {
                $q->where('id', $religionId);
            });
        }

        // State Filter
        $state = $stateId ? State::find($stateId) : null;
        if ($state) {
            $query->where('state_id', $state->id);
        }

        // Level Filter
        $level = $levelId ? Level::find($levelId) : null;
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
            'programs' => function ($q) use ($programId, $levelId) {
                if ($programId) {
                    $q->where('program_id', $programId);
                    if ($levelId) {
                        $level = Level::where('id', $levelId)->first();
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
            description: "Use our advanced search to find universities, polytechnics, monotechnics, colleges of education, etc., and course programs in Nigeria that match your criteria. Filter by location, study level, programme, institution category and more.",
        );

        return view('search', compact('institutions', 'program', 'state', 'level', 'SEOData'));
    }
}
