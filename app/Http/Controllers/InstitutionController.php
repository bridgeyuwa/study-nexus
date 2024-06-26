<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institution;
use App\Models\State;
use App\Models\Region;
use App\Models\Program;
use App\Models\Level;
use App\Models\Category;

class InstitutionController extends Controller {

    public function index() {
         
           $institutions = Institution::with(['state','schooltype','category'])->orderBy('name')->paginate(60);
           
           
        return view('institution.index', compact('institutions'));
    }

    public function category(Category $category) {
        $institutions = $category->institutions()->with(['state','schooltype','category'])->orderBy('name')->paginate(60);
        return view('institution.index', compact('institutions', 'category'));
    }

    

    public function programs(Institution $institution, Level $level) {
        $programs = $institution->programs()->wherePivot('level_id', $level->id)->with('college')->get()->groupBy('college.name');
        return view('institution.programs', compact('institution', 'level', 'programs'));
    }

    /* list single program levels available (eg degree in accounting, diploma in accounting) */

    public function programLevels(Institution $institution, Program $program) {
        $levels = $institution->levels()->wherePivot('program_id', $program->id)->with([

         'programs'=> function($query) use ($institution){

           $query->wherePivot('institution_id', $institution->id);

          }])->get();



        return view('institution.program-levels', compact('institution', 'program', 'levels'));
    }

    public function location() {
       
          
                $regions = Region::with(['institutions','states.institutions'])->get();

              return view('institution.location', compact('regions'));
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


            return view('institution.location', compact('regions', 'category'));
         }


                   public function showLocation(State $state) {

                        
                   $institutions = $state->institutions()->with('category','schooltype')->get();
                            
                   return view('institution.show-location', compact( 'state','institutions'));
                 }




        public function showCategoryLocation(Category $category, State $state) {

              $institutions = $state->institutions()->where('category_id', $category->id)->with('category','schooltype')->get();
                          
              return view('institution.show-location', compact( 'state','institutions','category'));
          }



    //ranking

        public function institutionRanking(Category $category) {


            /*  $institutions = Institution::whereHas('category', function ( $query) use ($category) {
                $query->where('categories.id', $category->id);
            })->with(['state.region','category','state.institutions','state.region.institutions'])->orderByRaw('rank IS NULL, rank')->get();          

          */

              $institutions = Institution::where('category_id', $category->id)->with(['state.region','category','state.institutions','state.region.institutions'])->orderByRaw('rank IS NULL, rank')->paginate(100); 


              foreach($institutions as $institution) {
              
                $computedRank = $this->computeRank($institution, $institutions);
             
                $rank[$institution->id] = 
                              [
                                'institution' => $computedRank['institution'],
                                'region' => $computedRank['region'],
                                'state' =>$computedRank['state']
                                ];
                           }
                           
        return view('institution.ranking', compact('institutions','rank', 'category'));
    }


      public function stateRanking(Category $category, State $state) {


          $institutions = Institution::where('state_id', $state->id)->where('category_id', $category->id)->with([
                     'state.region','category','state.institutions'
                   ])->orderByRaw('rank IS NULL, rank')->paginate(100);          

   

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


        return view('institution.ranking', compact('institutions','rank', 'category','state'));
    }




 public function regionRanking(Category $category, Region $region) {

          $institutions = Institution::where('category_id', $category->id)->whereHas('state.region',

                 function($query) use($region) {
                       $query->where('region_id', $region->id);
                 })->with('state.region')->orderByRaw('rank IS NULL, rank')->paginate(100);          



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
              

        return view('institution.ranking', compact('institutions','rank', 'category','region'));
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
                 $institution->load(['schooltype','category.institutions','term','catchments','state.institutions','state.region.institutions',

                                      'levels.programs' => function($query) use($institution) {

                                                   $query->wherePivot('institution_id', $institution->id);
                                                      }
                                   ]);
              
             $rank = $this->computeRank($institution, $allInstitutions);
             $levels = $institution->levels->unique();
       
          return view('institution.show', compact('institution', 'rank', 'levels'));
    }

    // show single institution program data
    public function program(Institution $institution, Level $level = null, Program $program) {
        $institution_program = $institution->programs()->where('program_id', $program->id)->wherePivot('level_id', $level->id)->first()->pivot;
        return view('institution.program', compact('institution', 'program', 'institution_program', 'level'));
    }
}
