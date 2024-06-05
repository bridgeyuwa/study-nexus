<div>


    @if($fullSearch)
<form class="p-2" action="/search" method="GET">


    <div class="row">
        <div wire:ignore class="mb-2 col-12 col-md-4">
            <label class="form-label fw-light text-white" for="location">Location</label>
            <select id="location" name="location" class="form-select">
                                  <option value="">Any Location</option>
                                    @foreach( $states as $state)
                                    <option value="{{$state->slug}}" @if( $state->slug == request()->get('location')
                                        ) {{'selected = "true"'}} @endif >{{$state->name}} </option>
                                    @endforeach
                                </select>
        </div>


        <div wire:ignore class="mb-2 col-12 col-md-4">
            <label class="form-label fw-light text-white" for="level">Level </label>
            <select wire:model.live="selectedLevel" id="level" name="level" class="form-select">
                                    <option value="">Any Level</option>
                                      @foreach($levels  as $level)
                                    <option value="{{$level->slug}}" @if( $level->slug == request()->get('level')
                                        ) {{'selected = "true"'}} @endif >{{$level->name}} @if(!empty($level->abbr)) ({{$level->abbr}}) @endif </option>
                                    @endforeach
                             </select>
        </div>
        
        <div class="mb-2 col-12 col-md-4 text-white" wire:key="a4569oh-kjhf-{{$count}}>
              
                <label class="form-label fw-light text-white" for="course" >Course</label>
                    <div class="mt-1" wire:ignore>
                               <select  id="program" name="program" class="form-select">
                                    <option value="">Any Course </option>
                                    @foreach($programs as $program)
                                    <option value="{{$program->id}}" @if( $program->id ==
                                        request()->get('program') ) {{'selected = "true"'}} @endif >{{\Illuminate\Support\Str::title($program->name)}} 
                                    </option>
                                    @endforeach
                                </select>    
                   </div> 
        </div>

  </div>


    <div class=" pt-2">
        <div class="d-flex  justify-content-center justify-content-md-end me-md-5 ">
            <button type="submit" wire:loading.attr="disabled" class="btn btn-hero btn-primary">Search</button>
        </div>
    </div>

</form>

@else

 <!-- include Livewire search form here -->
                         <form class="p-2 bg-light" action="{{url("/search")}}" method="GET">
                       
                       <div wire:ignore class="mb-2 col-12">
                         <label class="form-label" for="location">Location</label>
                         <select id="location-m" name="location" class="form-select"> 
                                   <option value="">Any Location</option>
                                    @foreach( $states as $state)
                                    <option value="{{$state->slug}}" @if( $state->slug == request()->get('location')
                                        ) {{'selected = "true"'}} @endif >{{$state->name}} </option>
                                    @endforeach
                         
                         </select>
                         </div>
                        
                         <div wire:ignore class="mb-2 col-12">
                         <label class="form-label" for="level">Level</label>
                        <select id="level-m" wire:model.live="selectedLevel"  name="level" class="form-select"> 
                                     <option value="">Any Level</option>
                                      @foreach($levels  as $level)
                                    <option value="{{$level->slug}}" @if( $level->slug == request()->get('level')
                                        ) {{'selected = "true"'}} @endif >{{$level->name}} @if(!empty($level->abbr)) ({{$level->abbr}}) @endif </option>
                                    @endforeach
                      
                         </select>
                         </div>

                          <div class="mb-2 col-12 fw-semibold" wire:key="a4569oh-kjhf-{{$count}}>
                         <label class="form-label " for="program">Program</label>
                        <div class="mt-1" wire:ignore>
                        <select id="program-m" name="program" class="form-select"> 
                         <option value="">Any Course </option>
                                    @foreach($programs as $program)
                                    <option value="{{$program->id}}" @if( $program->id ==
                                        request()->get('program') ) {{'selected = "true"'}} @endif >{{\Illuminate\Support\Str::title($program->name)}} 
                                    </option>
                                    @endforeach
                      
                         </select>
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



Livewire.on('programSelected', () => {
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



Livewire.on('programSelected', () => {
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
