<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institution;
use App\Models\State;
use App\Models\Region;
use App\Models\Program;
use App\Models\Level;
use App\Models\CategoryClass;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class InstitutionController extends Controller {
	
	public function index() {
	
        	
		$institutions = Cache::remember('institutions_page_' . request('page', 1), 60 * 60, function() {
			return Institution::with(['state', 'institutionType', 'category'])
					->orderBy('name')
					->paginate(60);
		});	
			
		$categoryClasses = Cache::rememberForever('categoryClasses', function() {
			return CategoryClass::all();
		});
		
		$SEOData = new SEOData(
            title: "Academic Institutions in Nigeria",
            description: "Browse a comprehensive list of universities, polytechnics, monotechnics, and colleges of education. Find the best institution for your needs.",
        );
		
		$parameters = ['location' => '', 'level' => '', 'program' => '', 'category' => '' ];
		
        return view('institution.index', compact('institutions','categoryClasses','SEOData','parameters'));
    }

    public function category(CategoryClass $categoryClass) {
        
		$institutions = Cache::remember('institutions_category_' . $categoryClass->id . '_page_' . request('page', 1), 60 * 60, function() use ($categoryClass) {
			return $categoryClass->institutions()
				->with(['state', 'institutionType', 'category'])
				->orderBy('name')
				->paginate(60);
		});
			
        $categoryClasses = Cache::rememberForever('categoryClasses', function() {
			return CategoryClass::all();
		});
		
		
        $SEOData = new SEOData(
			title: "{$categoryClass->name_plural} in Nigeria",
            description: "Browse a comprehensive list of {$categoryClass->name_plural}. Find the best {$categoryClass->name} for your needs.",
        );
		
		$parameters = ['location' => '', 'level' => '', 'program' => '', 'category' => $categoryClass->id ];
        
        return view('institution.index', compact('institutions', 'categoryClass','categoryClasses','SEOData','parameters'));
    }

    public function location() {
		
		
		$regions = Cache::rememberForever('regions_with_institutions', 60 * 60 * 24, function() {
			return Region::with(['institutions', 'states.institutions'])->get();
		});
		
        $categoryClasses = Cache::rememberForever('categoryClasses', function() {
			return CategoryClass::all();
		});
		
        $SEOData = new SEOData(
            title: "Academic Institutions in Nigeria by Location",
            description: "Discover academic institutions in your preferred location. Find the best educational institutions near you.",
        );

        return view('institution.location', compact('regions','categoryClasses','SEOData'));
    }


	public function categoryLocation(CategoryClass $categoryClass){
		// Get the category IDs associated with the CategoryClass
		$categoryIds = $categoryClass->categories->pluck('id');

		$regions = Cache::remember("regions_with_institutions_for_category_{$categoryClass->id}", now()->addDays(7), function() use ($categoryIds) {
			return Region::with([
				'institutions' => function($query) use ($categoryIds) {
					$query->whereIn('category_id', $categoryIds);
				},
				'states.institutions' => function($query) use ($categoryIds) {
					$query->whereIn('category_id', $categoryIds);
				}
			])->get();
		});
		
        $categoryClasses = Cache::rememberForever('categoryClasses', function() {
			return CategoryClass::all();
		});
		
        
		$SEOData = new SEOData(
			title: "{$categoryClass->name_plural} in Nigeria by Location",
			description: "Discover {$categoryClass->name_plural} in your preferred location. Find the best educational institutions near you.",
		);
		
		
		
        return view('institution.location', compact('regions', 'categoryClass','categoryClasses','SEOData'));
    }

    public function showLocation(State $state) {
		
		
		$institutions = Cache::remember("institutions_in_{$state->id}", 60 * 60 * 24, function() use ($state) {
			return $state->institutions()
				->with('category','institutionType','state')
				->orderBy('name')
				->get();
		});
		
        $categoryClasses = Cache::rememberForever('categoryClasses', function() {
			return CategoryClass::all();
		});
		
        $SEOData = new SEOData(
            title: "All Institutions in {$state->name}",
			description: "Explore top institutions in {$state->name} Compare programmes and find the best fit for your education needs.",
        );
           
         $parameters = ['location' => $state->id, 'level' => '', 'program' => '', 'category' => '' ];
        
		   
        return view('institution.show-location', compact( 'state','institutions','categoryClasses','SEOData','parameters'));
	}

	public function showCategoryLocation(CategoryClass $categoryClass, State $state) {
		// Get the category IDs associated with the CategoryClass
		$categoryIds = $categoryClass->categories->pluck('id');

		// Get institutions in the state that belong to the categories in the CategoryClass
		$institutions = Cache::remember("institutions_in_state_{$state->id}_for_category_{$categoryClass->id}", now()->addHours(12), function() use ($state, $categoryIds) {
			return $state->institutions()
				->whereIn('category_id', $categoryIds)
				->with(['category', 'institutionType', 'state'])
				->orderBy('name')
				->get();
		});

		 $categoryClasses = Cache::rememberForever('categoryClasses', function() {
			return CategoryClass::all();
		});
		
		$SEOData = new SEOData(
				title: "{$categoryClass->name_plural} in {$state->name}, Nigeria",
				description: "Explore {$categoryClass->name_plural} in {$state->name}, Nigeria. Compare programs and find the best fit for your education needs.",
			);
		
		
		$parameters = ['location' => $state->id, 'level' => '', 'program' => '', 'category' => $categoryClass->id ];
        
		
		return view('institution.show-location', compact('state', 'institutions', 'categoryClass', 'categoryClasses', 'SEOData','parameters'));
	}

    public function institutionRanking(CategoryClass $categoryClass) {
		
			
		$institutions = Cache::remember("institution_ranking_for_category_{$categoryClass->id}", now()->addHours(6), function() use ($categoryClass) {
			return Institution::whereIn('category_id', $categoryClass->categories->pluck('id'))
				->with(['state.region', 'category.categoryClass', 'state.institutions', 'state.region.institutions'])
				->orderByRaw('rank IS NULL, rank')
				->paginate(100);
		});

		$categoryClasses = Cache::rememberForever('categoryClasses', function() {
			return CategoryClass::all();
		});
		
		$rank = $institutions->isNotEmpty() ? $this->computeRankings($institutions) : null;

		$SEOData = new SEOData(
				title: "{$categoryClass->name_plural} Rankings in Nigeria",
				description: "Discover the top-ranked {$categoryClass->name_plural} in Nigeria. Compare rankings and find the best schools in the country.",
			);
		
		return view('institution.ranking', compact('institutions', 'rank', 'categoryClass', 'categoryClasses', 'SEOData'));
	}


	public function stateRanking(CategoryClass $categoryClass, State $state) {
			
		$institutions = Cache::remember("state_ranking_for_category_{$categoryClass->id}_state_{$state->id}", now()->addHours(6), function() use ($categoryClass, $state) {
			return Institution::where('state_id', $state->id)
				->whereIn('category_id', $categoryClass->categories->pluck('id'))
				->with(['state.region', 'category.categoryClass', 'state.institutions', 'state.region.institutions'])
				->orderByRaw('rank IS NULL, rank')
				->paginate(100);
		});

		
		$categoryClasses = Cache::rememberForever('categoryClasses', function() {
			return CategoryClass::all();
		});
		
		$rank = $institutions->isNotEmpty() ? $this->computeRankings($institutions) : null;

		$SEOData =  new SEOData(
			title: "{$categoryClass->name_plural} Rankings in {$state->name}, Nigeria",
			description: "Discover the top-ranked {$categoryClass->name_plural} in {$state->name}, Nigeria. Compare rankings and find the best schools in the state.",
		);
		

		return view('institution.ranking', compact('institutions', 'rank', 'categoryClass', 'categoryClasses', 'state', 'SEOData'));
}


	public function regionRanking(CategoryClass $categoryClass, Region $region) {
		
		$institutions = Cache::remember("region_ranking_for_category_{$categoryClass->id}_region_{$region->id}", now()->addHours(6), function() use ($categoryClass, $region) {
		
		return Institution::whereIn('category_id', $categoryClass->categories->pluck('id'))
			->whereHas('state.region', function($query) use ($region) {
				$query->where('region_id', $region->id);
			})
			->with(['state.region', 'state.institutions', 'category.categoryClass'])
			->orderByRaw('rank IS NULL, rank')
			->paginate(100);
			
      });
	  
		
		$categoryClasses = Cache::rememberForever('categoryClasses', function() {
			return CategoryClass::all();
		});
		
		$rank = $institutions->isNotEmpty() ? $this->computeRankings($institutions) : null;

	     
		$SEOData = new SEOData(
				title: "{$categoryClass->name_plural} Rankings in {$region->name}, Nigeria",
				description: "Discover the top-ranked {$categoryClass->name_plural} in {$region->name}, Nigeria. Compare rankings and find the best {$categoryClass->name_plural} in the region.",
		);
		

		return view('institution.ranking', compact('institutions', 'rank', 'categoryClass', 'categoryClasses', 'region', 'SEOData'));
	}


	private function computeRankings($institutions) {
        $rank = [];
        foreach ($institutions as $institution) {
            $computedRank = $this->computeRank($institution, $institutions);
            $rank[$institution->id] = [
                'institution' => $computedRank['institution'],
                'region' => $computedRank['region'],
                'state' => $computedRank['state']
            ];
        }
        return $rank;
    }

	private function computeRank($institution, $allInstitutions) {
        $rank = ['institution' => 0, 'region' => 0, 'state' => 0];

        if ($institution->rank) {
            foreach ($allInstitutions as $school) {
                $rank['institution']++;
                if ($school->id == $institution->id) break;
            }

            $regionInstitutions = $institution->state->region->institutions
                ->whereNotNull('rank')
                ->where('category_id', $institution->category->id)
                ->sortBy('rank');

            foreach ($regionInstitutions as $regionInstitution) {
                $rank['region']++;
                if ($regionInstitution->id == $institution->id) break;
            }

            $stateInstitutions = $institution->state->institutions
                ->whereNotNull('rank')
                ->where('category_id', $institution->category->id)
                ->sortBy('rank');

            foreach ($stateInstitutions as $stateInstitution) {
                $rank['state']++;
                if ($stateInstitution->id == $institution->id) break;
            }
        } else {
            $rank = ['institution' => false, 'region' => false, 'state' => false];
        }

        return $rank;
    }

	public function show(Institution $institution) {
		 
       $institution = Cache::remember("institution_{$institution->id}", 60 * 60 * 24, function() use ($institution) {
			$institution->load([
				'institutionType','category.institutions','term','catchments',
				'state.institutions','state.region.institutions','religiousAffiliation','institutionHead','accreditationBody','accreditationStatus','parentInstitution','childInstitutions','affiliatedInstitutions','phoneNumbers','socials.socialType',
				'levels.programs' => function($query) use($institution) {
					$query->wherePivot('institution_id', $institution->id);
				}
			]);
			return $institution;
		});
	   
	   
	   $allInstitutions = Cache::remember("all_institutions_rank_{$institution->category->id}", 60 * 60 * 24, function() use ($institution) {
			return Institution::whereNotNull('rank')
				->where('category_id', $institution->category->id)
				->orderBy('rank')
				->get();
		});
		
		
		$rank = Cache::remember("institution_rank_{$institution->id}", 60 * 60 * 24, function() use ($institution, $allInstitutions) {
			return $this->computeRank($institution, $allInstitutions);
		});
		
		
        $levels = $institution->levels->unique();
		
		 $SEOData = new SEOData(
			title: "{$institution->name}",
			description: "Discover {$institution->name} with detailed information on its academic offerings, including highlights, overview, course programs, tuition fees, ranking, and more.",
           // image: $institution->getFirstMediaUrl('profile', 'main'),                           

        );
		
		$institution['description_alt']= "Discover {$institution->name} with detailed information on its academic offerings, including highlights, overview, course programs, tuition fees, ranking, and more.";
            // to be fixed
	     //   dd($institution->head);
        return view('institution.show', compact('institution', 'rank', 'levels', 'SEOData'));
    }

    public function programs(Institution $institution, Level $level) {
       
			
		$programs = Cache::remember("institution_{$institution->id}_level_{$level->id}_programs", 60 * 60, function () use ($institution, $level) {
			return $institution->programs()
				->wherePivot('level_id', $level->id)
				->with('college')
				->get()
				->groupBy(fn($program) => $program->college->name)
				->sortKeys()
				->map(fn($group) => $group->sortBy(fn($program) => $program->name));
		});	
			
			
		
		$program_levels = Cache::remember("institution_{$institution->id}_unique_program_levels", 60 * 60, function () use ($institution) {
			return $institution->levels->unique();
		});
		
		$SEOData = new SEOData(
			title: "{$institution->name} {$level->name} Programmes",
			description: "Explore {$level->name} programs offered at {$institution->name}. Compare and choose the best program for your academic journey.",
		);				   
									    
        return view('institution.programs', compact('institution', 'level', 'programs','program_levels','SEOData'));
    }

    public function showProgram(Institution $institution, Level $level, Program $program) {
      
			
		$institution_program = Cache::remember("institution_{$institution->id}_program_{$program->id}_level_{$level->id}_show", 60 * 60, function () use ($institution, $level, $program) {
			return $institution->programs()
				->where('program_id', $program->id)
				->wherePivot('level_id', $level->id)
				->first();
		});
        
		if(!$institution_program)
		{
			abort(404);
		}
											  
		

		$program_levels = Cache::remember("institution_{$institution->id}_program_{$program->id}_levels", 60 * 60, function () use ($institution, $program) {
			return $institution->levels()
				->wherePivot('program_id', $program->id)
				->get();
		});
		
		$SEOData = new SEOData(
			title: "{$level->name} in {$program->name} offered at {$institution->name}",
			description: "Detailed information about {$level->name} in {$program->name} offered at {$institution->name}. Program highlights and overview",
		);

        return view('institution.show-program', compact('institution', 'program', 'institution_program', 'level','program_levels','SEOData'));
    }
	
	public function programLevels(Institution $institution, Program $program) {
		// Eager load 'levels' with 'programs' and 'state' for the institution
		
		/*
		$institution->load([
			'state',
			'levels' => function ($query) use ($program, $institution) {
				$query->wherePivot('program_id', $program->id)
					->with(['programs' => function ($query) use ($institution) {
						$query->wherePivot('institution_id', $institution->id);
					}]);
			}
		]);

		// Extract levels with associated programs
		$levels = $institution->levels;
		
		*/
		
		
	$levels = Cache::remember($programLevelsCacheKey, 60 * 60, function () use ($institution, $program) {
        $institution->load([
            'state',
            'levels' => function ($query) use ($program, $institution) {
                $query->wherePivot('program_id', $program->id)
                    ->with(['programs' => function ($query) use ($institution) {
                        $query->wherePivot('institution_id', $institution->id);
                    }]);
            }
        ]);

        return $institution->levels;
    });	
		
		
		
		
		
		

		// Prepare SEO data
		$SEOData = new SEOData(
			title: "Available Levels for {$program->name} offered at {$institution->name}",
			description: "Explore the available study levels for {$program->name} offered at {$institution->name}.",
		);

		return view('institution.program-levels', compact('institution', 'program', 'levels', 'SEOData'));
	}
	
	
	
}