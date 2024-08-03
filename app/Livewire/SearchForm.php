<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\State;
use App\Models\Level;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



class SearchForm extends Component
{

   public $allLevels = [];
   public $allPrograms = [];

   public $states = [];
   public $levels = [];
   public $programs = [];
   public $count = 0;
   public $fullSearch;
  

   public $selectedLevel = null;
   
    public $selectedType = '';
    public $selectedCategory = '';
    public $selectedReligion = '';
    public $selectedSort = ''; // Default sort
   
   public $isSearchPage = false;
   
   
   

     public function mount(Request $request)
        {
		    $this->allLevels = Level::with('__programs')->get(); //remove eagerloading in production from this Livewire
		    $this->levels = $this->allLevels;
		   
		    $this->allPrograms = Program::all();
		    $this->programs = $this->allPrograms;

		    $this->states = State::all();
		   
			$this->selectedLevel = $request->query('level', $this->selectedLevel); 
		
		
			$this->selectedType = $request->query('type', $this->selectedType);
			$this->selectedCategory = $request->query('category', $this->selectedCategory);
			$this->selectedReligion = $request->query('religion', $this->selectedReligion);
			$this->selectedSort = $request->query('sort', $this->selectedSort);
			   
		    $this->isSearchPage = Route::is('search');
        }


        public function updatedSelectedLevel($value)
   {
               if($value){

                    $levels = $this->allLevels->where('slug',$value)->first();
					
						if ($levels) {
							 $levels->load('__programs'); // Explicitly load the relationship remove in production
							$this->programs = $levels->__programs;
						} else {
							$this->programs = $this->allPrograms;
						}
					} 
                   else {
                       $this->programs = $this->allPrograms;
                    }
          $this->count = $this->count + 1 ;
		  $this->dispatch('programSelected');  
   }
   
   
	

    public function shouldDisableReligiousAffiliation()
    {
        return in_array($this->selectedType, ['public', 'federal', 'state']);
    }
   


     public function clearFilters()
	{
		$this->selectedType = '';
		$this->selectedCategory = '';
		$this->selectedReligion = '';
		$this->selectedSort = '';
	}



    public function render()
    {
        return view('livewire.search-form');
    }


   




}
