<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institution;
use App\Models\State;
use App\Models\Region;
use App\Models\Program;
use App\Models\Level;
use App\Models\Category;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Illuminate\Support\Facades\DB;

class InstitutionController extends Controller {
	

	

    public function index() {
         
           $institutions = Institution::with(['state','institutionType','category'])->orderBy('name')->paginate(60);
           $categories = Category::all();
           $SEOData = new SEOData(
                                    title: 'Academic Institutions in Nigeria',
                                    description: 'Browse a comprehensive list of universities, polytechnics, monotechnics, and colleges of education. Find the best institution for your needs.',
                                       );
           
        return view('institution.index', compact('institutions','categories','SEOData'));
    }

    public function category(Category $category) {
        $institutions = $category->institutions()->with(['state','institutionType','category'])->orderBy('name')->paginate(60);
          $categories = Category::all();            
                   $SEOData = new SEOData(
                                    title:  $category->name_plural. ' in Nigeria',
                                    description: ' Browse a comprehensive list of ' .$category->name_plural.'. Find the best ' .$category->name.' for your needs.',
                                       );
        return view('institution.index', compact('institutions', 'category','categories','SEOData'));
    }


  

    public function location() {
       
          
                $regions = Region::with(['institutions','states.institutions'])->get();
                $categories = Category::all();

           $SEOData = new SEOData(
                                    title: 'Academic Institutions in Nigeria by Location',
                                    description: 'Discover academic institutions in your preferred location. Find the best educational institutions near you.
',
                                       );

              return view('institution.location', compact('regions','categories','SEOData'));
    }


         public function categoryLocation(Category $category){


          $regions = Region::with([
                 
                  'institutions' => function($query) use ($category) {
                                         $query->where('category_id',$category->id);
                                        },
                     
                                       'states'  => function($query) use ($category) {

                                               $query->with([
                                                      'institutions' => function($query) use ($category) {
                                                           $query->where('category_id',$category->id);
                                                           }
                                                       ]);  
                                              }
                                     ])->get();
			 $categories = Category::all();

            $SEOData = new SEOData(
                                    title: $category->name_plural. ' in Nigeria by Location',
                                    description: 'Discover '.$category->name_plural.' in your preferred location. Find the best educational institutions near you.',
                                       );

            return view('institution.location', compact('regions', 'category','categories','SEOData'));
         }


                   public function showLocation(State $state) {

                        
                   $institutions = $state->institutions()->with('category','institutionType','state')->orderBy('name')->get();
                   $categories = Category::all();
                   $SEOData = new SEOData(
                                    title: 'All Institutions in '.$state->name,
                                    description: 'Explore top institutions in '. $state->name.'. Compare programs and find the best fit for your education needs.
',
                                       );
                            
                   return view('institution.show-location', compact( 'state','institutions','categories','SEOData'));
                 }




        public function showCategoryLocation(Category $category, State $state) {

              $institutions = $state->institutions()->where('category_id', $category->id)->with('category','institutionType','state')->orderBy('name')->get();
              $categories = Category::all();


              $SEOData = new SEOData(
                                    title: $category->name_plural.' in '.$state->name.', Nigeria',
                                    description: 'Explore '.$category->name_plural.' in '.$state->name.', Nigeria. Compare programs and find the best fit for your education needs.',
                                       );
                          
              return view('institution.show-location', compact( 'state','institutions','category','categories', 'SEOData'));
          }



    //ranking

        public function institutionRanking(Category $category) {



              $institutions = Institution::where('category_id', $category->id)->with(['state.region','category','state.institutions','state.region.institutions'])->orderByRaw('rank IS NULL, rank')->paginate(100); 
              $categories = Category::all();
			
				if($institutions->isNotEmpty()){
              foreach($institutions as $institution) {
              
                $computedRank = $this->computeRank($institution, $institutions);
             
                $rank[$institution->id] = 
                              [
                                'institution' => $computedRank['institution'],
                                'region' => $computedRank['region'],
                                'state' =>$computedRank['state']
                                ];
                           }
				}else 
                {    

					$rank = null; 

				}			
						   
						   
                           
                     $SEOData = new SEOData(
                                    title: $category->name.' Rankings in Nigeria',
                                    description: 'Discover the top-ranked '.$category->name_plural.' in Nigeria. Compare rankings and find the best schools in the country.',
                                       );


        return view('institution.ranking', compact('institutions','rank', 'category','categories','SEOData'));
    }


      public function stateRanking(Category $category, State $state) {
                     

          $institutions = Institution::where('state_id', $state->id)->where('category_id', $category->id)->with([
                     'state.region','category','state.institutions'
                   ])->orderByRaw('rank IS NULL, rank')->paginate(100);          
        
		
		$state->load('institutions.category');
		
        $categories = $state->institutions->pluck('category')->unique('id')->sort();
		//dd($categories);

           if($institutions->isNotEmpty()){
    foreach($institutions as $institution) {
              
                $computedRank = $this->computeRank($institution, $institutions);
             
                $rank[$institution->id] = 
                              [
                                'institution' => $computedRank['institution'],
                                'region' => $computedRank['region'],
                                'state' =>$computedRank['state']
                                ];
                           }
            }else
           {
               $rank = null; 

            }

     
                     $SEOData = new SEOData(
                                    title:  $category->name.' Rankings in '.$state->name.', Nigeria',
                                    description: 'Discover the top-ranked '.$category->name_plural.' in '.$state->name.', Nigeria. Compare rankings and find the best $category->name_plural.',
                                       );

        return view('institution.ranking', compact('institutions','rank', 'category','categories','state','SEOData'));
    }




 public function regionRanking(Category $category, Region $region) {

          $institutions = Institution::where('category_id', $category->id)->whereHas('state.region',

                 function($query) use($region) {
                       $query->where('region_id', $region->id);
                 })->with('state.region','state.institutions','category')->orderByRaw('rank IS NULL, rank')->paginate(100);          

			$region->load('institutions.category');
			$categories = $region->institutions->pluck('category')->unique('id')->sort();
		
		

          if($institutions->isNotEmpty()){
    foreach($institutions as $institution) {
              
                $computedRank = $this->computeRank($institution, $institutions);
             
                $rank[$institution->id] = 
                              [
                                'institution' => $computedRank['institution'],
                                'region' => $computedRank['region'],
                                'state' =>$computedRank['state']
                                ];
                           }
}else {

$rank = null; 

}


                      
                           $SEOData = new SEOData(
                                    title:  $category->name.' Rankings in '.$region->name.', Nigeria',
                                    description: 'Discover the top-ranked '.$category->name_plural.' in '.$region->name.', Nigeria. Compare rankings and find the best $category->name_plural in the region.',
                                       );

        return view('institution.ranking', compact('institutions','rank', 'category','categories','region','SEOData'));
    }





private function computeRank($institution, $allInstitutions) {


  /* Ranking */ 
        if ($institution->rank) {

                     

            $rank['institution'] = 0;
            foreach ($allInstitutions as $school) {
                $rank['institution'] = $rank['institution'] + 1;
                if ($school->id == $institution->id) {
                    break;
                }
            }

            $region_institutions = $institution->state->region->institutions->whereNotNull('rank')->where('category_id',$institution->category->id)->sortBy('rank');
           
            $rank['region'] = 0;

            foreach ($region_institutions as $region_institution) {
                $rank['region'] = $rank['region'] + 1;
                if ($region_institution->id == $institution->id) {
                    break;
                }
            }

            $state_institutions = $institution->state->institutions->whereNotNull('rank')->where('category_id',$institution->category->id)->sortBy('rank');
            
            $rank['state'] = 0;
            foreach ($state_institutions as $state_institution) {
                $rank['state'] = $rank['state'] + 1;

                if ($state_institution->id == $institution->id) {
                    break;
                }
            }
        } else {
            $rank['institution'] = false;
            $rank['region'] = false;
            $rank['state'] = false;
        }
     /*  End Ranking */



        return $rank;
    }





    public function show(Institution $institution) {
                 $allInstitutions = Institution::whereNotNull('rank')->where('category_id',$institution->category->id)->orderBy('rank')->get();  // get all institutions 
				 
                 $institution->load(['institutionType','category.institutions','term','catchments','state.institutions','state.region.institutions','socials',
                 
                                      'levels.programs' => function($query) use($institution) {

                                                   $query->wherePivot('institution_id', $institution->id);
                                                      }
                                   ]);	
								   
					//dd($institution);
				
            
					
              
             $rank = $this->computeRank($institution, $allInstitutions);
             $levels = $institution->levels->unique();
			 
			 $description = 'Discover ' .$institution->name. ' with detailed information on its academic offerings, including highlights, overview, course programs, tuition fees, ranking, and more.';
			
			$SEOData = new SEOData(
                                          title: $institution->name,
                                          description: $description,
                                          

                                       );
		
		
		$institution['description_alt']= $description;
		
		//dd($institution->description_alt);
		
		//dd($institution->religiousAffiliation->religiousAffiliationCategory->name, $institution->religiousAffiliation->name, $institution->institutionType->institutionTypeCategory->name, $institution->institutionType->name);
		  
         dd($institution->parent);		

		 
          return view('institution.show', compact('institution', 'rank', 'levels', 'SEOData'));
    }


    // list of programs offered by an institution at a Level /institutions/{institution}/levels/{level}/programs
  
    public function programs(Institution $institution, Level $level) {
        $programs = $institution->programs()->wherePivot('level_id', $level->id)->with('college')->get()->groupBy(function ($program) {
        return $program->college->name;
    })->sortKeys()->map(function ($group) {
                return $group->sortBy(fn($program) => $program->name);  // Sort the programs within each college by name
            });
			
		
     $program_levels = $institution->levels->unique();
		
       $description = 'Explore ' .$level->name. ' programs offered at '.$institution->name.'. Compare and choose the best program for your academic journey.';
        $SEOData = new SEOData(
                                    title:  $institution->name.' '.$level->name. ' Programs',
                                    description: $description,
                                       );

						   
									    
        return view('institution.programs', compact('institution', 'level', 'programs','program_levels','SEOData'));
    }





    // show single institution program data
    public function showProgram(Institution $institution, Level $level = null, Program $program) {
        $institution_program = $institution->programs()->where('program_id', $program->id)->wherePivot('level_id', $level->id)->first();
        
		if(!$institution_program)
		{
			abort(404);
		}
											  
			$program_levels = $institution->levels()->wherePivot('program_id', $program->id)->get();										  
		
            $SEOData = new SEOData(
                                    title: $level->name.' in ' .$program->name. ' offered at '.$institution->name,
                                    description: 'Detailed information about '.$level->name.' in ' .$program->name. ' offered at '.$institution->name.'. program highlights and overview ',
                                       );
					
     



        return view('institution.show-program', compact('institution', 'program', 'institution_program', 'level','program_levels','SEOData'));
    }
	
	
	
	
	  /* list  levels available for a single program (eg degree in accounting, diploma in accounting) */

    public function programLevels(Institution $institution, Program $program) {
        $levels = $institution->levels()->wherePivot('program_id', $program->id)->with([

         'programs'=> function($query) use ($institution){

           $query->wherePivot('institution_id', $institution->id);

          }])->get();
		  
		  
		$institution = $institution->load('state');  

            $SEOData = new SEOData(
                                    title: 'Available Levels for '.$program->name.' offered at '.$institution->name,
                                    description: 'Explore the available study levels for '.$program->name.' offered at '.$institution->name.'.',
                                       );

        return view('institution.program-levels', compact('institution', 'program', 'levels','SEOData'));
    }
	
	
	
}
