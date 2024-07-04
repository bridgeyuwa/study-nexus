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
                <h1><a class="fw-light text-white mb-1 " href="route('institutions.show', ['institution' => $institution->id])}}">{{Str::title($institution->name)}} @if(!empty($institution->abbr)) <span class="text-white-75">({{str::upper($institution->abbr)}})<span> @endif</a> </h1>

                  <h2 class="h4 fs-md  fw-light text-white-75 ">
                      @if(isset($institution->locality)) {{str::title($institution->locality)}} - @endif  @if($institution->state->id == 15) FCT @else {{str::title($institution->state->name)}} State @endif
                    </h2>

           <h2> 
               <a class="h3 fw-light text-white" href="{{route('programs.show', ['level' => $level->slug, 'program' => $program->id])}}">
                    {{Str::title($program->name)}} <span class="h4 fw-light text-white-75" >({{str::title($level->name)}}@if(isset($level->abbr))({{str::title($level->abbr)}})@endif)</span> 
                </a> 

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
                <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                    <h3 class="block-title">Ads</h3>
                </div>
                <div class="block-content">
                    Ads
                </div>
            </div>
            <!-- END Ads -->
        </div>

        <div class="col-md-8 order-md-0">

            <!-- Program Description -->
            <div class="block block-rounded">
                <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                    <h3 class="block-title">Program Overview</h3>
                </div>
                <div class="block-content">

                    <div class="fw-semibold"> Duration: <span class="fw-normal text-black">{{$institution_program->duration}} YEARS</span> </div>
                    <br>
                    <p>
                        @if(!empty($institution_program)) {!! $institution_program->description !!} @else {!! $program->description !!} @endif
                    </p>

                </div>
            </div>
            <!-- END Program Description -->

            <!--  Admission Requirements -->
            <div class="block block-rounded">
                <div class="block-header block-header-default justify-content-center" style="background-image: url(/media/patterns/cubes.png)">
                    <div>
                        <h3 class="block-title row justify-content-center">Admission Requirement </h3>

                        <div class="fs-sm row text-center">{{Str::title($institution->name)}} Admission Requirement for {{Str::title($level->name)}} in {{Str::title($program->name)}} </div>
                    </div>
                </div>
                <div class="block-content">

                    <!-- UTME Admission Requirements -->
                    <div class="block block-rounded">
                        <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                            <h3 class="block-title">UTME Requirements</h3>
                        </div>
                        <div class="block-content">

                            <table class="table">

                                <tr>
                                    <td class="fs-sm fw-semibold">UTME Cut-Off</td>
                                    <td>{{$institution_program->utme_cutoff}}</td>
                                </tr>

                                <tr>
                                    <td class="fs-sm fw-semibold">UTME Subject Combination</td>
                                    <td>{{$institution_program->utme_subjects}}</td>
                                </tr>

                                <tr>
                                    <td class="fs-sm fw-semibold">O'Level Requirement</td>
                                    <td>{{$institution_program->utme_o_level_req}}</td>
                                </tr>
                            </table>

                        </div>
                    </div>
                    <!-- END UTME Admission Requirements -->

                    <!-- DE Admission Requirements -->
                    <div class="block block-rounded">
                        <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                            <h3 class="block-title">Direct Entry Requirements</h3>
                        </div>
                        <div class="block-content text-center">

                            <div class="ms-2"> {{$institution_program->direct_entry_req}} </div>
                        </div>
                    </div>
                    <!-- END DE Admission Requirements -->
                </div>
            </div>
            <!-- END General Admission Requirements -->

            <!-- Tuition Fee -->
            <div class="block block-rounded">
                <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                    <h3 class="block-title">Tuition Fee</h3>
                </div>
                <div class="block-content text-center text-center">
                    <p class="fs-lg text-muted">
                        @if(!empty($institution_program->tuition_fee)) ₦ {{Number::format($institution_program->tuition_fee, precision: 0)}} <span class="fs-sm">({{Number::forHumans($institution_program->tuition_fee, precision: 0)}} Naira)</span @else Tuition Fee not available! @endif
                    </p>
                    
                </div>
            </div>
            <!-- END Tuition Fee -->

        </div>
    </div>
</div>
<!-- END Page Content -->







@endsection