<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institution;
use App\Models\State;
use App\Models\Program;
use App\Models\Level;
use App\Models\Category;
use App\Models\ReligiousAffiliationCategory;

use Illuminate\Database\Eloquent\Builder;
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
		$religionSlug =$request->input('religion');
		
		$sortBy = $request->input('sort');
		

        $query = Institution::query();
		
		
		//Institution Type filter
		if($typeSlug)
		{
			if($typeSlug == "public")
			{ 
				$query->whereHas('institutionType', function ($q) use ($typeSlug) {
					$q->whereHas('institutionTypeCategory', function ($q) use ($typeSlug) {
				$q->where('slug', $typeSlug);
					});
				});	
				//dd($query->get());
			}
			else
			{
				$query->whereHas('institutionType', function ($q) use ($typeSlug) {
					$q->where('slug', $typeSlug);
                });
				//dd($query->get());
			}
		}
		
        
		//categories Filter
		
		$category = $categorySlug ? Category::where('slug',$categorySlug)->first() : null;
		if($category)
		{
			$query->whereHas('category', function ($q) use ($categorySlug) {
					$q->where('slug', $categorySlug);
            });
			 // dd($query->get());
		}
		
		
		// Religious Affiliation Filter
		
		$religiousAffiliationCategory =  $religionSlug ? ReligiousAffiliationCategory::where('slug', 'islam')->first() : null;
		if($religiousAffiliationCategory)
		{
			$query->whereHas('religiousAffiliation', function ($q) use ($religionSlug) {
				$q->whereHas('religiousAffiliationCategory', function ($q) use ($religionSlug) {
					$q->where('slug', $religionSlug);
				});
            });
				//dd($query->get());
		}
		
        
		
    
		
		
		
		

        $state = $stateSlug ? State::where('slug', $stateSlug)->first() : null;
        if ($state) {
            $query->where('state_id', $state->id);
        }

        $level = $levelSlug ? Level::where('slug', $levelSlug)->first() : null;
        if ($level) {
            $query->whereHas('levels', function (Builder $query) use ($level) {
                $query->where('levels.id', $level->id);
            });
        }

        $program = $programId ? Program::find($programId) : null;
        if ($program) {
            $query->whereHas('programs', function (Builder $query) use ($program) {
                $query->where('programs.id', $program->id);
            });

            $query->with([
                'levels' => function ($query) use ($program) {
                    $query->wherePivot('program_id', $program->id);
                }
            ]);
        }

        $query->with([
            'state:id,name,is_state,code',
            'institutionType:id,name',
            'category:id,name'
        ]);

        if ($program) {
            $query->with([
                'programs' => function ($query) use ($program, $level) {
                    if ($level) {
                        $query->where('program_id', $program->id)->wherePivot('level_id', $level->id);
                    } else {
                        $query->where('program_id', $program->id);
                    }
                }
            ]);
        } else {
            $query->with('programs');
        }
		
		
		if($sortBy)
		{
			if($sortBy == "rank")
			{
		    $query->orderByRaw('rank IS NULL, rank');
				
			}
			
		}
		
		
		

        $institutions = $query->paginate(30);
       
	   
        $SEOData = new SEOData(
            title: 'Search Nigerian Academic Institutions and Programs',
            description: 'Use our advanced search to find universities, polytechnics, monotechnics, colleges of education, etc and course programs in Nigeria that match your criteria. Filter by location, study level, course program and more.',
        );

        return view('search', compact('institutions', 'program', 'state', 'level', 'SEOData'));
    }
}
