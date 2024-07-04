@extends('layouts.backend') 

@section('content')
@php 
use Illuminate\Support\Str; 
use Illuminate\Support\Number;  
@endphp

<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-6">
              <div class="pt-4 pb-3">
                <h1> 
                   <a class="fw-light text-white mb-1" href="{{route('institutions.show', ['institution' => $institution->id])}}">
                     {{Str::title($institution->name)}} @if(!empty($institution->abbr)) <span class="text-white-75">({{str::upper($institution->abbr)}})<span> @endif
                   </a> 
               </h1>

                  <h2 class="h4 fs-md  fw-light text-white-75 ">
                      @if(isset($institution->locality)) {{str::title($institution->locality)}} - @endif  @if($institution->state->id == 15) FCT @else {{str::title($institution->state->name)}} State @endif
                    </h2>

                <h2 class="h3 fw-light text-white">
                    {{Str::title($program->name)}} Programs <span class="text-white-75">(Levels)</span>
                </h2> 

              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->



         <!-- Page Content -->
<div class="content content-boxed">
    <div class="row">
        <div class="col-md-4 order-md-1">

            <!-- Ads -->
            <div class="block block-rounded">
                <div class="block-header block-header-default" style="background-image: url(/media/patterns/cubes.png)">
                    <h3 class="block-title">Ads</h3>
                </div>
                <div class="block-content">
                    Ads
                </div>
            </div>
            <!-- END Ads -->
        </div>

        <div class="col-md-8 order-md-0">

            <!-- Program Levels -->
            <div class="block block-rounded">
                <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                    <h3 class="block-title">Program Levels</h3>
                </div>
                <div class="block-content">

                    @foreach($levels as $level)
                    <a class="block block-rounded block-bordered block-link-shadow" href="{{route('institutions.program', ['institution' => $institution->id, 'level' => $level->slug, 'program' => $program->id])}}">
                  <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                    <div class="me-3">
                      <div class=" col fs-lg  mb-0 text-primary">
                        {{$level->name}} <span class="text-muted">({{Str::of($program->name)->title()}})</span>
                      </div>                      
                      <p class="text-muted mb-0">                       
                        @isset($level->programs->first()->pivot->tuition_fee) ₦ {{ Number::format($level->programs->first()->pivot->tuition_fee)}} <span class="fs-sm">({{ Number::forHumans($level->programs->first()->pivot->tuition_fee)}} Naira) </span> @endisset
                      </p>
                    </div>
                    <div>
                      <i class="fa fa-circle-right  text-xwork text-primary"></i> 
                    </div>
                  </div>
                </a> @endforeach

                </div>
            </div>
            <!-- END Program Levels -->

        </div>
    </div>
</div>
<!-- END Page Content -->




@endsection