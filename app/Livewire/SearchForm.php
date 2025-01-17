<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\State;
use App\Models\Level;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;



class SearchForm extends Component
{

   public $allLevels = [];
   public $allPrograms = [];

   public $states = [];
   public $levels = [];
   public $programs = [];
   public $count = 0;
   public $fullSearch;
  

   public $selectedLevel = '';
   public $selectedProgram = null;
   
    public $selectedType = '';
    public $selectedCategory = '';
    public $selectedReligion = '';
    public $selectedSort = ''; // Default sort
   
    public $isSearchPage = false;
   
   
   

     public function mount(Request $request)
        {
		   
			$this->allLevels = Cache::remember('all_levels', 60 * 60, function() {
				return Level::with('__programs')->get(); // remove eager loading in production
			});
			
			$this->levels = $this->allLevels;

			$this->allPrograms = Cache::remember('all_programs', 60 * 60 , function() {
				return Program::all();
			});
			
			
			if(!empty($request->query('level'))){
				//dd('Level selected ');
				$level = $this->allLevels->where('id', $request->query('level'))->first();
				
				$this->programs = $level->__programs->sortBy('name');
            }
			else{
				// dd('Level NOT Selected');
				$this->programs = $this->allPrograms;
				
			}


			$this->states = Cache::remember('states', 24 * 60 * 60 , function() {
				return State::all();
			});
			
			
			
		   
			$this->selectedLevel = $request->query('level', $this->selectedLevel); 
			$this->selectedProgram = $request->query('program', $this->selectedProgram); 
		
		
			$this->selectedType = $request->query('type', $this->selectedType);
			$this->selectedCategory = $request->query('category', $this->selectedCategory);
			$this->selectedReligion = $request->query('religion', $this->selectedReligion);
			$this->selectedSort = $request->query('sort', $this->selectedSort);
			   
		    $this->isSearchPage = Route::is('search');
        }


        public function updatedSelectedLevel($value)
		   {
			   
				$this->selectedLevel = $value === "" ? null : $value; 
				
					   if($value){

							$level = $this->allLevels->where('id',$value)->first();
							
								if ($level) {
									 $level->load('__programs'); // Explicitly load the relationship remove in production
									$this->programs = $level->__programs->sortBy('name');
									
									if($this->selectedProgram && $this->programs->contains('id', $this->selectedProgram)){
										
										//do nothing if it contains the id
									}else{
										
										if(!empty($this->selectedProgram)){
										$newLevelName = $level->name;
										$previousProgramName = $this->allPrograms->where('id', $this->selectedProgram)->first()->name ?? 'The selected program'; //previous program name
										session()->flash('programReset', "<strong>{$previousProgramName}</strong> is unavailable for <strong>{$newLevelName}</strong>. The Study Programme field has been reset to the default <strong>'Any Programme'</strong>.");
										
										}
										
										$this->selectedProgram = null;
										
									
									}
									
								} else {
									$this->programs = $this->allPrograms;
								}
							} 
						   else {
							   $this->programs = $this->allPrograms;
							}
				  $this->count = $this->count + 1 ;
				  $this->dispatch('refreshPrograms');  
		   }
		   
		   
		   public function updatedSelectedProgram($value){
					  $this->selectedProgram = $value === "" ? null : $value; 
					 
					  
					  $this->dispatch('refreshPrograms');
		   }
   
   
	

    public function shouldDisableReligiousAffiliation()
    {
		$this->dispatch('refreshPrograms'); // Refresh program to retain select2 functionality
        return in_array($this->selectedType, ['public', 'federal', 'state']);
		
    }
   


     public function clearFilters()
	{
		$this->selectedType = '';
		$this->selectedCategory = '';
		$this->selectedReligion = '';
		$this->selectedSort = '';
		
		// Retain the current selected  program if they exist
		$this->selectedProgram = $this->selectedProgram ?? null;
		$this->dispatch('refreshPrograms'); // Refresh program to retain select2 functionality
  
  
	}



    public function render()
    {
        return view('livewire.search-form');
    }


   




}
