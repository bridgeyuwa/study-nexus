@extends('layouts.backend')


@section('content')
@php 
use Illuminate\Support\Str;
use Illuminate\Support\Number;
@endphp


<span itemscope itemtype="https://schema.org/EducationalOccupationalProgram">
<meta itemprop="name" content="{{$level->name}} in {{$program->name}}" />
<link itemprop="url" content="{{url()->current()}}" />


<!-- Hero -->
<div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
    <div class="bg-black-75">
        <div class="content content-full content-top text-center pt-7">
            <div class="row">
                <div class="col-md-8 pt-4 pb-3">
                    <h1 class="fw-light text-white mb-1 ">{{Str::title($program->name)}}</h1>
                    <h2 class="h4 fs-md  fw-light text-white-75 ">
                     {{Str::title($level->name)}}
                    </h2>
                    
                </div>

                <div class="col-md-4 d-flex align-items-center">
                    <div class="block block-rounded block-transparent bg-black-50 text-center mb-0 mx-auto">
                        <div class="block-content block-content-full px-4 py-4">
                            <div class="fs-2 fw-semibold text-white">
                                


                               @php  
                               $min_tuition = $level->programs->min('pivot.tuition_fee');
                               $max_tuition = $level->programs->max('pivot.tuition_fee');
                          @endphp




                               @if(isset($min_tuition)) 
                         @if($min_tuition == $max_tuition)
                                 @if($min_tuition >= 1010000) 
                                 ₦ {{Number::abbreviate($min_tuition, precision: 2)}}  
                                 @else 
                                 ₦ {{Number::abbreviate($min_tuition)}} 
                                 @endif
                         @else 
                                 @if($min_tuition >= 1010000) 
                                  ₦ {{Number::abbreviate($min_tuition, precision: 2)}} 
                                  @else 
                                  ₦ {{Number::abbreviate($min_tuition)}} 
                                 @endif

                                   <span class="fw-semibold">-</span> 

                                @if($max_tuition >= 1010000)   
                                   ₦ {{Number::abbreviate($max_tuition, precision: 2)}} 
                                @else 
                                   ₦ {{Number::abbreviate($max_tuition)}} 
                                @endif
                        @endif 
                                 
                  @endif


                            </div>
                            <div class="fs-sm fw-semibold text-uppercase text-white-50 mt-1 push">Annual Tuition</div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- END Hero -->

      
        <!-- Page Content -->
<div class="content content-boxed">
    <div class="row">
        <div class="col-md-4 order-md-1">

            <!-- highlights -->
            <div class="block block-rounded ">
                <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                    <h3 class="block-title">Ads</h3>
                </div>
                <div class="block-content">
                    <ul class="fa-ul list-icons">
							@isset($program->duration)
							<li class="mb-1">
								<span class="fa-li text-primary">
									<i class="fa fa-university"></i>
								</span>
								<div class="fw-semibold">Duration</div>
								<div class="text-muted">{{$program->duration}} Years</div>
								<meta itemprop="timeToComplete" content="P{{$program->duration}}Y" />
							</li>
							 @endisset
							<li class="mb-1">
								<span class="fa-li text-primary">
									<i class="fa fa-calendar"></i>
								</span>
								<div class="fw-semibold">Program Mode</div>
								<div itemprop="educationalProgramMode" class="text-muted">Full-time</div>
							</li>
							<li itemprop="educationalCredentialAwarded" itemscope itemtype="https://schema.org/EducationalOccupationalCredential" class="mb-1">
								<span class="fa-li text-primary">
									<i class="fa fa-calendar"></i>
								</span>
								<div class="fw-semibold">Credential Awarded</div>
								<div itemprop="credentialCategory" class="text-muted">{{$level->name}}</div>
							</li>
							
							
						</ul>
                </div>
            </div>
            <!-- END Ad block -->
        </div>

        <div class="col-md-8 order-md-0">

            <!-- Program Description -->
            <div class="block block-rounded">
                <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                    <h3 class="block-title">Course Overview</h3>
                </div>
                <div class="block-content">
                    <p itemprop="description">{!!$program->pivot->description!!}</p>
                </div>
            </div>
            <!-- END Program Description -->

            <!-- General Admission Requirements -->
            <div class="block block-rounded">
                <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                    <h3 class="block-title">General Admission Requirements</h3>
                </div>
                <div class="block-content">


                    <!-- UTME Admission Requirements -->
                    <div itemscope itemtype="https://schema.org/EducationalOccupationalProgram" class="block block-rounded">
                        <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                            <a class="link-dark link-fx" href="https://jamb.gov.ng">Unified Tertiary Matriculation Examination (UTME)</a>  - JAMB Requirement
						</div>
                        <div class="block-content">

                            <table class="table">

                                <tr>
                                    <td class="fs-sm fw-semibold">UTME Cut-off</td>
                                    <td>{{$level->utme_cutoff}}</td>
                                </tr>

                                <tr>
                                    <td class="fs-sm fw-semibold">UTME Subject Combination</td>
                                    <td itemprop="programPrerequisites" itemscope itemtype="https://schema.org/EducationalOccupationalCredential">
								<p itemprop="description" class="m-0"> asdhhhh	{{$program->pivot->utme_subjects}} </p>
									</td>
                                </tr>

                                <tr>
                                    <td class="fs-sm fw-semibold">O'Level Requirement</td>
                                    <td itemprop="programPrerequisites" itemscope itemtype="https://schema.org/EducationalOccupationalCredential">
									<p itemprop="description"> zzzzzz {{$program->pivot->utme_o_level_req}} </p>
									</td>
                                </tr>
                            </table>

                        </div>
                    </div>
                    <!-- END UTME Admission Requirements -->

                    <!-- DE Admission Requirements -->
                    @if($level->id == 'bachelor')      <!-- fix this -->
                    <div class="block block-rounded">
                        <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                            <h3 class="block-title">Direct Entry Requirements</h3>
                        </div>
                        <div itemprop="programPrerequisites" itemscope itemtype="https://schema.org/EducationalOccupationalCredential" class="block-content text-center">
								<span itemprop="description" class="m-0"> asdfghgfd {{$program->pivot->direct_entry_req}} </span>
                        </div>
                    </div>
                    @endif
                    <!-- END DE Admission Requirements -->

                </div>
            </div>
            <!-- END General Admission Requirements -->




            <!-- Tuition Range -->
            <div itemprop="offers" itemscope itemtype="https://schema.org/Offer" class="block block-rounded">
                <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                    <h3 class="block-title">Tuition Fee <span class="fw-light">(Range)</span></h3>
                </div>
                <div itemprop="priceSpecification" itemscope itemtype="https://schema.org/PriceSpecification" class="block-content text-center">
                    <p class="fs-lg text-muted">
                       <span itemprop="priceCurrency" content="NGN">₦</span> <span itemprop="minPrice">  {{Number::format($min_tuition)}} </span> - <span itemprop="priceCurrency" content="NGN">₦</span> <span itemprop="maxPrice">  {{Number::format($max_tuition)}} </span>
                    </p>
                </div>
            </div>
            <!-- END Tuition Range -->

            <!-- Instititions Offering Program -->
            <div class="block block-rounded">
                <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                    <h3 class="block-title">Institutions Offering {{str::title($level->name)}} in {{Str::title($program->name)}}</h3>
                </div>
                <div class="block-content">
                    <a class="bg-info  block block-bordered block-link-shadow py-2 px-4 mb-3 text-center text-white fw-semibold" href="{{route('programs.institutions', ['level' => $level->slug, 'program' => $program->id])}}">
               View Institutions
            </a>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->

</span>

@endsection