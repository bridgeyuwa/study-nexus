@extends('layouts.backend')


@section('content')
@php 
use Illuminate\Support\Number;

$min_tuition = $level_programs->min('pivot.tuition_fee');
$max_tuition = $level_programs->max('pivot.tuition_fee');

@endphp


<span itemscope itemtype="https://schema.org/EducationalOccupationalProgram">
<meta itemprop="name" content="{{$level->name}} in {{$program->name}}" />
<link itemprop="url" content="{{url()->current()}}" />


<!-- Hero -->
<div class="bg-image studynexus-bg-hero" >
    <div class="bg-black-75">
        <div class="content content-full content-top text-center pt-7">
            <div class="row">
                <div class="pt-4 pb-3">
                    <h1 class="h2 text-white mb-1 ">{{$program->name}}</h1>
                    <h2 class="h3 fw-light text-white mt-3">
                     {{$level->name}}
                    </h2>
                    
                </div>
            </div>
        </div>
    </div>
	
	    <div class="d-flex justify-content-end py-1">		
		     <!-- Social Actions -->
				
				<div class="btn-group me-1" role="group">
					<button type="button" class="btn btn-sm btn-alt-primary dropdown-toggle" id="dropdown-blog-news" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-share-alt opacity-50 me-1"></i> Share Programme
					</button>
					<div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="dropdown-blog-news">
						@foreach ($shareLinks as $platform => $link)
							<a class="dropdown-item" href="{{ $link }}" onclick="window.open(this.href, '_blank', 'width=700, height=525, left=250, top=200'); return false;">
								<i class="fab fa-fw fa-{{ $platform }} text-{{ $platform }}  me-1"></i> {{ ucfirst($platform) }}
							</a>
						@endforeach
					</div>
				</div>
			
			<!-- END Social Actions -->	 
		</div>
	
</div>
<!-- END Hero -->


<!-- Breadcrumbs -->
		  {{Breadcrumbs::render()}}
		 <!-- End Breadcrumbs -->
      
        <!-- Page Content -->
<div class="content content-boxed">

    <div class="col-md-12 order-md-1">

            <!-- nav -->
            <div class="block block-rounded">
			
                
                    <ul class="nav nav-tabs nav-tabs-block bg-gray-lighter">
					@foreach($program_levels as $program_level)
						
                  <li class="nav-item">
				  
				  
					 
					@if(
					route('programs.show', ['level' => $program_level, 'program' => $program]) == url()->current()
					) 
					<button
					class="btn-sm nav-link active" disabled > {{$program_level->name}}
					</button>
					
					@else
						<a href="{{route('programs.show', ['level' => $program_level, 'program' => $program])}}"><button
					class="btn-sm nav-link" > {{$program_level->name}}
					</button>
					</a>
					@endif
				
                  </li>
				  @endforeach
                  
                </ul>
            </div>
            <!-- END nav -->
        </div>


    <div class="row">
        <div class="col-md-4 order-md-1">

            <!-- highlights -->
            <div class="block block-rounded ">
                <div class="block-header block-header-default text-center bg-studynexus-cubes" >
                    <h3 class="block-title">Highlights</h3>
                </div>
                <div class="block-content">
                    <ul class="fa-ul list-icons">
							
							<li class="mb-1">
								<span class="fa-li text-primary">
									<i class="fa fa-university"></i>
								</span>
								<div class="fw-semibold">Average Duration</div>
								<div class=""> @if(!empty($program->pivot->duration)){{$program->pivot->duration}} Years @else N/A @endif</div>
								<meta itemprop="timeToComplete" content="P{{$program->pivot->duration}}Y" />
							</li>
							<li class="mb-1">
								<span class="fa-li text-primary">
									<i class="fa fa-calendar"></i>
								</span>
								<div class="fw-semibold">Programme Mode</div>
								<div itemprop="educationalProgramMode" class="">Full-time</div>
							</li>
							<li itemprop="educationalCredentialAwarded" itemscope itemtype="https://schema.org/EducationalOccupationalCredential" class="mb-1">
								<span class="fa-li text-primary">
									<i class="fa fa-calendar"></i>
								</span>
								<div class="fw-semibold">Credential Awarded</div>
								<div itemprop="credentialCategory" class="">{{$level->name}}</div>
							</li>
							
							
						</ul>
                </div>
            </div>
            <!-- END Ad block -->
        </div>

        <div class="col-md-8 order-md-0">

            <!-- Programme Description -->
            <div class="block block-rounded">
                <div class="block-header block-header-default text-center bg-studynexus-cubes" >
                    <h3 class="block-title">Programme Overview</h3>
                </div>
                <div class="block-content">
                    <p itemprop="description">{{$program->pivot->description}}</p>
                </div>
            </div>
            <!-- END Programme Description -->

            <!-- General Admission Requirements -->
            <div class="block block-rounded">
                <div class="block-header block-header-default text-center bg-studynexus-cubes" >
                    <h3 class="block-title">General Admission Requirements</h3>
                </div>
                <div class="block-content">


                    <!-- UTME Admission Requirements -->
                    <div itemscope itemtype="https://schema.org/EducationalOccupationalProgram" class="block block-rounded">
                        <div class="block-header block-header-default text-center bg-studynexus-cubes" >
                         <h3 class="block-title"> JAMB Unified Tertiary Matriculation Examination (UTME) Requirements </h3>
						    
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
								<p itemprop="description" class="m-0">{{$program->pivot->utme_subjects}} </p>
									</td>
                                </tr>

                                <tr>
                                    <td class="fs-sm fw-semibold">O'Level Requirement</td>
                                    <td itemprop="programPrerequisites" itemscope itemtype="https://schema.org/EducationalOccupationalCredential">
									<p itemprop="description" class="m-0"> {{$program->pivot->o_level}} </p>
									</td>
                                </tr>
								<tr>  
								
								<td class="text-danger fw-light fs-sm" colspan="2" >UTME Requirements for {{$level->name}} in {{$program->name}} may be different for some institutions. Ensure to check the institution of choice for its specific requirements. </td>
								</tr>
                            </table>

                        </div>
                    </div>
                    <!-- END UTME Admission Requirements -->
					
                    <!-- DE Admission Requirements -->
                    @if($level->id == 1)      <!-- use this -->
                    <div class="block block-rounded">
                        <div class="block-header block-header-default text-center bg-studynexus-cubes" >
                            <h3 class="block-title">JAMB Direct Entry Requirements</h3>
                        </div>
                        <div itemprop="programPrerequisites" itemscope itemtype="https://schema.org/EducationalOccupationalCredential" class="block-content text-center pb-2">
							@if(!empty($program->pivot->direct_entry))	<span itemprop="description"> {{$program->pivot->direct_entry}} </span> @else No Direct Entry @endif
								
                        </div>
						<span class="text-danger fw-light d-block px-4 py-2 border-top fs-sm" >Direct Entry Requirements for {{$level->name}} in {{$program->name}} may be different for some institutions, and some may not accept Direct Entry for {{$program->name}}.  Ensure to check the institution of choice for its specific requirements. </span>
								
                    </div>
                    @endif
                    <!-- END DE Admission Requirements -->

                </div>
				
				 </div>
            <!-- END General Admission Requirements -->

			<!-- Tuition Range -->
            <div itemprop="offers" itemscope itemtype="https://schema.org/Offer" class="block block-rounded">
                <div class="block-header block-header-default text-center bg-studynexus-cubes" >
                    <h3 class="block-title"> <span itemprop="name"> Tuition Fee </span> <span class="fw-light">(Range)</span></h3>
                </div>
                <div itemprop="priceSpecification" itemscope itemtype="https://schema.org/PriceSpecification" class="block-content text-center">
                    <p class="fs-lg">
                       @if(!empty($min_tuition))<span itemprop="priceCurrency" content="NGN">₦</span> <span itemprop="minPrice">  {{Number::format($min_tuition)}} </span> - <span itemprop="priceCurrency" content="NGN">₦</span> <span itemprop="maxPrice">  {{Number::format($max_tuition)}} </span> @else <span class="fs-5"> Tuition fee not available.</span> @endif
                    </p>
                </div>
            </div>
            <!-- END Tuition Range -->
             
            <!-- Instititions Offering Program -->
            <div class="block block-rounded">
                <div class="block-header block-header-default text-center bg-studynexus-cubes" >
                    <h3 class="block-title">Institutions Offering {{$level->name}} in {{$program->name}}</h3>
                </div>
                <div class="block-content">
                    <a class="bg-info  block block-bordered block-link-shadow py-2 px-4 mb-3 text-center text-white fw-semibold" href="{{route('programs.institutions', ['level' => $level, 'program'=> $program])}}">
						View Institutions  <span class="fw-light">({{$program->institutions_count}}) <span>
					</a>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->

</span>

@endsection