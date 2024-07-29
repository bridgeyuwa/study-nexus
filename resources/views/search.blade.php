@extends('layouts.backend')

@section('content')
@php 
use Illuminate\Support\Number; 
use Illuminate\Support\Str;
@endphp

<!-- Hero -->
<div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
    <div class="bg-black-75">
        <div class="content content-full content-top text-center pt-6 pb-0">
            <div id="search" class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">Search</h1>

                <h2 class="h4 fs-md  fw-light text-white-75 ">
                    Discover Academic Institutions and Programmes
                </h2>

                <livewire:search-form fullSearch /> 

            </div>
        </div>
    </div>
</div>
<!-- END Hero -->



<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-content">

            <!-- Introduction -->
            <h2 class="content-heading text-center">Academic Institutions @if(!empty($level) || !empty($program)) offering @endif @if(!empty($level)) {{str::title($level->name)}}  @endif @if(!empty($program)) in {{Str::of($program->name)->title()}} @endif in @if(!is_null($state)) {{str::title($state->name)}} @if(!empty($state->is_state)) State @endif @endif - Nigeria</h2>
            <div class="row items-push">
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 100px;">
                        <p class="text-muted  mb-2">
                            Search Results of academic institutions @if(!empty($level) || !empty($program)) offering @endif @if(!empty($level)) <span class="text-black">{{str::title($level->name)}}</span> in @endif @if(!empty($program)) <span class="text-black">{{Str::of($program->name)->title()}}</span>   @endif in @if(!is_null($state)) <span class="text-black">{{str::title($state->name)}} @if(!empty($state->is_state)) State @endif</span>, @endif Nigeria
                        </p>
                        <p class="text-muted fs-sm">
                            We provide comprehensive information about each of the academic institutions as well as detailed insights into every course offered by these institutions. (eg. description, catchment areas, tuition fees, admission requirements, etc.)
                        </p>
                        <div class="d-none d-lg-block d-flex justify-content-center">
                            <a class="btn btn-sm btn-hero btn-info" href="{{url("#search")}}">
                                <i class="fa fa-fw fa-arrow-up me-1"></i> back to search
                            </a>
                        </div>
                    </div>
                </div>

                <!-- start col-lg-8 -->
                <div class="col-lg-8 border px-lg-4 pt-3">

                    @if($institutions->isEmpty())

                    <div class="content content-full mb-3">
                        <p class="h3 text-center">No results found.</p>
                        <p class="mb-0 fs-sm text-center">There is no result for the combination of your search.</p>
                        <p class="mb-0 fs-sm text-center">Try Refining your search</p>
                        <div class="d-flex justify-content-center">
                            <ul>
                                <li class="mb-0 fs-sm">Change the location</li>
                                <li class="mb-0 fs-sm">Change the level of study</li>
                                <li class="mb-0 fs-sm">Change the course</li>
                            </ul>
                        </div>
                        <div class="d-flex justify-content-center">
                            <a href="{{url("#search")}}" class="btn btn-sm btn-hero btn-info me-1 mb-3 ">
                                <i class="fa fa-fw fa-arrow-up me-1"></i> back to search
                            </a>
                        </div>
                    </div>

                    @else 

                    {{ $institutions->onEachSide(1)->links() }} 

                    @foreach ($institutions as $institution)
					<!-- institution/program item -->
                    <a href="
                       @if(!empty($program) && !empty($level))  
                       {{route('institutions.program', ['institution' => $institution->id, 'level' => $level->slug, 'program' => $program->id])}} 
                       @elseif(!empty($program))
                       {{route('institutions.program.levels', ['institution' => $institution->id, 'program' => $program->id])}}
                       @else  
                       {{route('institutions.show', ['institution' => $institution->id])}}    
                       @endif 
                       " 
                       class="block block-rounded bg-dark">
                        <div class="block block-header-default bg-image mb-0 fw-light"
                             style="background-image: url('media/photos/photo11.jpg');">
                            <div class="bg-black-75 text-center pt-3 pb-1">
                                <div class="fs-5 fw-light text-white mb-0">{{str::title($institution->name)}}
                                    @if(!empty($institution->abbr))({{str::upper($institution->abbr)}}) @endif 
                                </div>

                                @if(!empty($institution->former_name)) <div class="text-white mb-2 fs-sm"> Formerly: <span class="text-white-75 fw-light">{{str::title($institution->former_name)}}</span> </div> @endif 

                                <div class=" text-white-75 mb-2 fs-sm">{{str::title($institution->schooltype->name)}}
                                    {{str::title($institution->category->name)}}. <i
                                        class="fa fa-map-marker-alt ms-2 me-1 text-primary"></i>

                                    @if(!empty($institution->locality)) {{str::title($institution->locality)}} - @endif   {{str::title($institution->state->name)}}  @if(!empty($institution->state->is_state)) State @endif

                                </div>
                                @if(!empty($program)) <div class="h6 mb-2 text-white"> {{str::title($program->name)}} 
									@if(!empty($level))
										<span class="fs-sm fw-light">({{str::title($level->name)}})</span>
									@endif
                                </div> @endif
                            </div>
                        </div>


                        @if(empty($level) && !empty($program))
                        <div class="py-0 bg-secondary d-flex justify-content-center">
                            <table class="mx-auto text-white">
                                <tr>
                                    <td class=" text-center fs-sm fw-semibold">Available Study Level(s)</td>
                                </tr>

                                @foreach($institution->levels as $program_level)
                                <tr>
                                    <td class="text-center fs-sm mb-0">
                                        <i class="fa fa-certificate me-2"></i>{{str::title($program_level->name)}} @if(!empty($program_level->abbr))  ({{str::upper($program_level->abbr)}}) @endif 
                                    </td> 
                                </tr>
                                @endforeach 
                            </table>
                        </div>
                        @endif



                        @php
                        $min_tuition = $institution->programs->min(function ($program){ return $program->pivot->tuition_fee;});
                        $max_tuition = $institution->programs->max(function ($program){ return $program->pivot->tuition_fee;});
                        @endphp


                        <!-- card footer -->
                        <div class="block block-header-default  pt-1 border-bottom ">
                            <div class="row justify-content-center">


                                <div class=" text-center mb-1 fs-sm">


                                    <span>
                                        @if(!empty($min_tuition)) 
											@if($min_tuition == $max_tuition)
												@if($min_tuition >= 1010000) 
												<i class="far fa-money-bill-1 text-success"></i>    {{Number::abbreviate($min_tuition, precision: 2)}} Naira(₦) 
												@else 
												<i class="far fa-money-bill-1 text-success"></i>   {{Number::abbreviate($min_tuition)}} Naira(₦) 
												@endif
											@else 
												@if($min_tuition >= 1010000) 
												<i class="far fa-money-bill-1 text-success"></i>  {{Number::abbreviate($min_tuition, precision: 2)}} 
												@else 
												<i class="far fa-money-bill-1 text-success"></i> {{Number::abbreviate($min_tuition)}} 
												@endif

												<span class="fw-semibold">-</span> 

												@if($max_tuition >= 1010000)   
												{{Number::abbreviate($max_tuition, precision: 2)}} Naira(₦) 
												@else 
												{{Number::abbreviate($max_tuition)}} Naira(₦) 
												@endif
											@endif 

                                        @endif 
                                    </span> 
                                </div>


                            </div>
                        </div>
                        <!-- End card footer -->
                    </a>
					<!-- END institution/program item -->
                    @endforeach {{ $institutions->links() }} @endif

                </div>
                <!-- End col-lg-8  -->

            </div>
            <div class="d-flex justify-content-end d-lg-none mb-2">
                <a class="btn btn-sm btn-hero btn-info" href="{{url("#search")}}">
                    <i class="fa fa-fw fa-arrow-up me-1"></i> back to search
                </a>
            </div>
        </div>



    </div>
</div>




<!-- END Page Content -->



@endsection