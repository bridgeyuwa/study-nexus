<div>


    @if($fullSearch)
<form class="p-2" action="/search" method="GET">


    <div class="row">
        <div wire:ignore class="mb-2 col-12 col-md-4">
            <label class="form-label fw-light text-white" for="location">Study Location</label>
            <select id="location" name="location" class="form-select">
                                  <option value="">Any Location</option>
                                    @foreach( $states as $state)
                                    <option value="{{$state->id}}" @if( $state->id == request()->get('location')
                                        ) {{'selected = "true"'}} @endif >{{$state->name}} </option>
                                    @endforeach
                                </select>
        </div>


        <div wire:ignore class="mb-2 col-12 col-md-4">
            <label class="form-label fw-light text-white" for="level">Study Level </label>
            <select wire:model.live="selectedLevel" id="level" name="level" class="form-select">
                                    <option value="">Any Level</option>
                                      @foreach($levels  as $level)
                                    <option value="{{$level->id}}" @if( $level->id == request()->get('level')
                                        ) {{'selected = "true"'}} @endif >{{$level->name}} @if(!empty($level->abbr)) ({{$level->abbr}}) @endif </option>
                                    @endforeach
                             </select>
        </div>
        
        <div class="mb-2 col-12 col-md-4" >
              
            <label class="form-label fw-light text-white" for="course" >Study Programme</label>
				
			<div wire:key="a4569oh-kjhf-{{$count}}" > 
				<div class="mt-1" >
				   <select wire:model.live="selectedProgram" id="program" name="program" class="form-select">
						<option value="">Any Programme </option>
						@foreach($programs as $program)
						<option value="{{$program->id}}" @if( $program->id ==
							request()->get('program') ) {{'selected = "true"'}} @endif >{{$program->name}} 
						</option>
						@endforeach
					</select>    
			    </div> 
			   
			</div>
        </div>
		
		
		
		@if($isSearchPage)
		<div class="mt-3">
	<div class="text-white text-start mb-2"><i class="fa fa-sliders-h me-1"></i> Filters </div>
	
    <div class="mb-2 col-12 text-start text-white fw-light">
        <div class="bg-white-25 px-2 fs-sm rounded">
            <div class="mb-1 fw-semibold">Type</div>
            <div class="radio d-inline">
                <input type="radio" id="type_all" name="type" value="" wire:model.live="selectedType" >
                <label class="me-1" for="type_all">All</label>
            </div>
            <div class="radio d-inline">
                <input type="radio" id="type_public" name="type" value="public" wire:model.live="selectedType"  >
                <label class="me-1" for="type_public">Public</label>
            </div>
            <div class="radio d-inline">
                <input type="radio" id="type_federal" name="type" value="federal" wire:model.live="selectedType" >
                <label class="me-1" for="type_federal">Federal</label>
            </div>
            <div class="radio d-inline">
                <input type="radio" id="type_state" name="type" value="state" wire:model.live="selectedType" >
                <label class="me-1" for="type_state">State</label>
            </div>
            <div class="radio d-inline">
                <input type="radio" id="type_private" name="type" value="private" wire:model.live="selectedType" >
                <label class="me-1" for="type_private">Private</label>
            </div>
        </div>
    </div>

    <div class="mb-2 col-12 text-start text-white fw-light">
        <div class="bg-white-25 px-2 fs-sm rounded">
            <div class="mb-1 fw-semibold">Category</div>
            <div class="fs-sm">
                <div class="radio d-inline">
                    <input type="radio" id="category_all" name="category" value="" wire:model="selectedCategory" >
                    <label class="me-1" for="category_all">All</label>
                </div>
                <div class="radio d-inline">
                    <input type="radio" id="category_universities" name="category" value="1"  wire:model="selectedCategory" >
                    <label class="me-1" for="category_universities">University</label>
                </div>
                <div class="radio d-inline">
                    <input type="radio" id="category_poly" name="category" value="2" wire:model="selectedCategory" >
                    <label class="me-1" for="category_poly">Polytechnic</label>
                </div>
                <div class="radio d-inline">
                    <input type="radio" id="category_colleges" name="category" value="3" wire:model="selectedCategory" >
                    <label class="me-1" for="category_colleges">College of Education</label>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-2 col-12 text-start text-white fw-light">
        <div class="bg-white-25 px-2 fs-sm rounded">
            <div class="mb-1 fw-semibold">Religious Affiliation</div>
            <div class="fs-sm">
                <div class="radio d-inline">
                    <input type="radio" id="religion_all" name="religion" value="" wire:model="selectedReligion" @if($this->shouldDisableReligiousAffiliation()) disabled @endif>
                    <label class="me-1" for="religion_all">All</label>
                </div>
                <div class="radio d-inline">
                    <input type="radio" id="religion_non_religious" name="religion" value="1" wire:model="selectedReligion" @if($this->shouldDisableReligiousAffiliation()) disabled @endif>
                    <label class="me-1" for="religion_non_religious">Non-Religious</label>
                </div>
                <div class="radio d-inline">
                    <input type="radio" id="religion_christian" name="religion" value="2" wire:model="selectedReligion"  @if($this->shouldDisableReligiousAffiliation()) disabled @endif>
                    <label class="me-1" for="religion_christian">Christian</label>
                </div>
                <div class="radio d-inline">
                    <input type="radio" id="religion_islam" name="religion" value="3"  wire:model="selectedReligion"  @if($this->shouldDisableReligiousAffiliation()) disabled @endif>
                    <label class="me-1" for="religion_islam">Islam</label>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-2 col-12 text-start text-white fw-light">
        <div class="bg-white-25 px-2 fs-sm rounded">
            <div class="mb-1 fw-semibold">Sort By</div>
            <div class="fs-sm">
                <div class="radio d-inline">
                    <input type="radio" id="az" name="sort" value="" wire:model="selectedSort">
                    <label class="me-1" for="az"><i class="fa fa-arrow-down-a-z me-1"></i>A-Z (default)</label>
                </div>
                <div class="radio d-inline">
                    <input type="radio" id="za" name="sort" value="za"  wire:model="selectedSort" >
                    <label class="me-1" for="za"><i class="fa fa-arrow-down-z-a me-1"></i>Z-A</label>
                </div>
                <div class="radio d-inline">
                    <input type="radio" id="rank" name="sort" value="rank"  wire:model="selectedSort">
                    <label class="me-1" for="rank">Rank</label>
                </div>
            </div>
        </div>
    </div>
</div>

	<div class="d-flex flex-row">
		<button wire:click="clearFilters" type="button" class="btn btn-sm btn-outline-light fw-light"><i class="fa fa-times me-1"></i> Clear filters </button>
	</div>
@endif

</div>
  
	


    <div class=" pt-2">
        <div class="d-flex  justify-content-center justify-content-md-end me-md-5 ">
            <button type="submit" wire:loading.attr="disabled" class="btn btn-hero btn-primary"> @if($isSearchPage) Apply Filters @else Search @endif </button>
        </div>
    </div>

</form>

@else

 <!-- include Livewire search form here -->
                         <form class="p-2" action="{{url("/search")}}" method="GET">
                       
                       <div wire:ignore class="mb-2 col-12 text-white">
                         <label class="me-1" class="form-label" for="location">Study Location</label>
                         <select id="location-m" name="location" class="form-select"> 
                                   <option value="">Any Location</option>
                                    @foreach( $states as $state)
                                    <option value="{{$state->id}}" @if( $state->id == request()->get('location')
                                        ) {{'selected = "true"'}} @endif >{{$state->name}} </option>
                                    @endforeach
                         
                         </select>
                         </div>
                        
                         <div wire:ignore class="mb-2 col-12 text-white">
                         <label class="me-1" class="form-label" for="level">Study Level</label>
                        <select id="level-m" wire:model.live="selectedLevel"  name="level" class="form-select"> 
                                     <option value="">Any Level</option>
                                      @foreach($levels  as $level)
                                    <option value="{{$level->id}}" @if( $level->id == request()->get('level')
                                        ) {{'selected = "true"'}} @endif >{{$level->name}} @if(!empty($level->abbr)) ({{$level->abbr}}) @endif </option>
                                    @endforeach
                      
                         </select>
                         </div>

                          <div class="mb-2 col-12 text-white" >
                         <label class="me-1" class="form-label" for="program"> Study Programme</label>
						 
						 <div  wire:key="a4569oh-kjhf-{{$count}}" >
                        <div class="mt-1" wire:ignore>
                        <select id="program-m" name="program" class="form-select"> 
                         <option value="">Any Programme </option>
                                    @foreach($programs as $program)
                                    <option value="{{$program->id}}" @if( $program->id ==
                                        request()->get('program') ) {{'selected = "true"'}} @endif >{{\Illuminate\Support\Str::title($program->name)}} 
                                    </option>
                                    @endforeach
                      
                         </select>
                         </div>
						 </div>
						 
                         </div>

                       <div class="mt-4">  <button type="submit" wire:loading.attr="disabled" class="btn btn-hero btn-primary w-100">Search</button> </div>
                     </form>
                      <!-- End livewire search form -->

@endif


</div>



@script

<script> 


$('#location').select2({
    theme: 'bootstrap-5',
    width: '100%',
    minimumResultsForSearch: 0,
    placeholder: {},
    allowClear: true,
    searchInputPlaceholder: 'Search State...',
    language: {
        removeAllItems: function() {
            return "Clear Selection";
        }
    }
     

});



$('#level').select2({
    theme: 'bootstrap-5',
    width: '100%',
    minimumResultsForSearch: Infinity,
    placeholder: {},
    allowClear: true,
    language: {
        removeAllItems: function() {
            return "Clear Selection";
        }
    }

});

$('#level').on('change', function(event){


    console.log(event.target.value);
    $wire.set('selectedLevel', event.target.value);


});

$(document).on('change', '#program', function(event){
    console.log(event.target.value);
    $wire.set('selectedProgram', event.target.value);
});




$('#program').select2({
    theme: 'bootstrap-5',
    width: '100%',
    minimumResultsForSearch: 0,
    placeholder: {},
    allowClear: true,
    searchInputPlaceholder: 'Search Course...',
    language: {
        removeAllItems: function() {
            return "Clear Selection";
        }
    }

});



Livewire.on('refreshPrograms', () => {
  console.log("Event triggered successfully");    

jQuery(document).ready(function() {
$('#program').select2({
    theme: 'bootstrap-5',
    width: '100%',
    minimumResultsForSearch: 30,
    placeholder: {},
    allowClear: true,
    searchInputPlaceholder: 'Search Course...',
    language: {
        removeAllItems: function() {
            return "Clear Selection";
        }
    }

}); 

});

 });










$('#location-m').select2({
    
    dropdownParent: $('#search-dropdown'),
    theme: 'bootstrap-5',
    width: '100%',
    minimumResultsForSearch: 0,
    placeholder: {},
    allowClear: true,
    searchInputPlaceholder: 'Search State...',
    language: {
        removeAllItems: function() {
            return "Clear Selection";
        }
    }
     

});



$('#level-m').select2({
    dropdownParent: $('#search-dropdown'),
    theme: 'bootstrap-5',
    width: '100%',
    minimumResultsForSearch: Infinity,
    placeholder: {},
    allowClear: true,
    language: {
        removeAllItems: function() {
            return "Clear Selection";
        }
    }

});

$('#level-m').on('change', function(event){


    console.log(event.target.value);
    $wire.set('selectedLevel', event.target.value);


});




$('#program-m').select2({
    dropdownParent: $('#search-dropdown'),
    theme: 'bootstrap-5',
    width: '100%',
    minimumResultsForSearch: 0,
    placeholder: {},
    allowClear: true,
    searchInputPlaceholder: 'Search Course...',
    language: {
        removeAllItems: function() {
            return "Clear Selection";
        }
    }

});



Livewire.on('refreshPrograms', () => {
  console.log("Event triggered successfully");    

jQuery(document).ready(function() {
$('#program-m').select2({
    dropdownParent: $('#search-dropdown'),
    theme: 'bootstrap-5',
    width: '100%',
    minimumResultsForSearch: 30,
    placeholder: {},
    allowClear: true,
    searchInputPlaceholder: 'Search Course...',
    language: {
        removeAllItems: function() {
            return "Clear Selection";
        }
    }

}); 

});

 });



</script>
@endscript