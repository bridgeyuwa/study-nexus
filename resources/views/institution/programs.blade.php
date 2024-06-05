@extends('layouts.backend') 

@section('content')
@php 
use Illuminate\Support\Str; 
use Illuminate\Support\Number;  
@endphp

<style>
    /* Hide the plus and minus signs by default */
    .toggle-icon::after {
        content: '+';
    }
    /* Show the minus sign when the collapse is open */
    [aria-expanded="true"] .toggle-icon::after {
        content: '-';         
    }
</style>


<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-5">
              <div class="pt-4 pb-3">
              <h1>
                  <a class="fw-light text-white mb-1" href="{{route('institutions.show', ['institution' => $institution->id])}}">
                      {{str::title($institution->name)}} <span class="text-white-75">@if(!empty($institution->abbr)) ({{str::upper($institution->abbr)}})
                          @endif </span>
                  </a> 
              </h1>

                  <h2 class="h4 fs-md  fw-light text-white-75 ">
                      @if(isset($institution->locality)) {{str::title($institution->locality)}}, @endif {{str::title($institution->lga->name)}} - @if($institution->state->id == 15) FCT @else {{str::title($institution->state->name)}} State @endif
                    </h2>

            <h2 class="h3 fw-light text-white">{{str::title($level->name)}} Programs</h2>

              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->


        <!-- Page Content -->
<div class="content">
    <div class="block block-rounded">

        <div class="block-content">
           
            <h2 class="content-heading text-center">Accredited Courses Offered at {{Str::title($institution->name)}}</h2>
            <div class="row items-push">
                <div class="col-lg-4">
                    <p class="text-muted sticky-top" style="top: 100px;">
                        Explore the official list of accredited <span class="text-black-75">{{str::title($level->name)}}</span> courses grouped by their various disciplines offered at <span class="text-black-75">{{Str::title($institution->name)}}</span>.
                    </p>
                </div>
                
                <div class="col-lg-8">
                    <div id="programs" role="tablist" aria-multiselectable="true">

                        @foreach( $programs as $collegeName => $programs)
                        <div class="block block-rounded mb-1">
                            <a class="fs-lg link-primary fw-semibold" data-bs-toggle="collapse" data-bs-parent="#programs" href="#programs_q{{$loop->iteration}}" aria-expanded="false" aria-controls="programs_q{{$loop->iteration}}">
                <div class="block-header block-header-default fs-5" role="tab" id="programs_h{{$loop->iteration}}">
                <div>{{str::title($collegeName)}}</div>  <span class="toggle-icon fw-light fs-2 "></span>
                </div>
                 </a>
                            <div id="programs_q{{$loop->iteration}}" class="collapse" role="tabpanel" aria-labelledby="programs_h{{$loop->iteration}}" data-bs-parent="#programs">
                                <div class="block-content">

                                    @foreach($programs as $program)
                                    <div class="block block-rounded mb-1">
                                        <a class="fw-normal" href="{{route('institutions.program', ['institution' => $institution->id, 'level' => $level->slug, 'program' => $program->id])}}">
                <div class="block-header block-header-default fs-6">
                  {{Str::title($program->name)}}  
                </div>
             </a>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
          
        </div>
    </div>
</div>
<!-- END Page Content -->




@endsection