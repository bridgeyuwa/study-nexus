@extends('layouts.backend') 

@section('content') 
@php 
use Illuminate\Support\Str; 
use Illuminate\Support\Number;
@endphp


<span itemscope itemtype="https://schema.org/EducationalOccupationalProgram">
<meta itemprop="name" content="{{$level->name}} in {{$program->name}}" />

		<!-- Hero  -->
        <div itemprop="provider" itemscope itemtype="https://schema.org/CollegeOrUniversity" class="bg-image" style="background-image: url('/media/photos/photo13@2x.jpg');">
			<div  class="bg-black-75">
				<div class="content content-boxed content-full py-5 pt-7">
				    <div class="row">
							@if(!empty($institution->logo))
							
							<div class="col-md-4 d-flex align-items-center">
							  <div class="block block-rounded  block-transparent bg-black-50 text-center mb-0 mx-auto" href="be_pages_jobs_apply.html" style="box-shadow:0 0 2.25rem #d1d8ea;opacity:1">
								<div class="block-content block-content-full px-2 py-2">
								
								  <img  src="{{$institution->logo}}" alt="{{$institution->name}} logo" class="" style="width: 150px; height: 150px; object-fit: cover;"></img>
								  <link itemprop="logo" href="{{$institution->logo}}">
								</div>
							  </div>
							</div>
							@endif
							
						<div class=" @if(!empty($institution->logo)) col-md-8 @endif d-flex align-items-center py-3">
							<div class="w-100 text-center @if(!empty($institution->logo))text-md-start @endif">
									<h1 class="mb-1">  <a class="fw-light text-white link-fx" href="{{route('institutions.show',['institution' => $institution->id])}}"> <span itemprop="name">{{Str::title($institution->name)}} </span> @if(!empty($institution->abbr))<span class="text-white-75">({{Str::upper($institution->abbr)}})</span>@endif </a></h1>
									  
									<link itemprop="url" href="{{url()->current()}}">
									<link itemprop="sameAs" href="{{$institution->url}}">
									  

									<h2 itemprop="address" itemscope itemtype="https://schema.org/PostalAddress" class="h4 fs-md  fw-light text-white-75 mb-1">
										<meta itemprop="streetAddress" content="{{$institution->address}}">
										@if(!empty($institution->locality)) <span itemprop="addressLocality">{{str::title($institution->locality)}} </span>- @endif  <span itemprop="addressRegion">{{str::title($institution->state->name)}} @if(!empty($institution->state->is_state)) State @endif </span> 
										 <meta itemprop="postalCode" content="{{$institution->postal_code}}">
										<meta itemprop="addressCountry" content="NG">
									
									</h2>
									<div class="text-white mb-3">
									@if(!empty($institution->slogan))( <i itemprop="slogan">{{$institution->slogan}}</i> ) @endif
									</div>
									
									<h2> 
									   <a class="h3 fw-light text-white link-fx" href="{{route('programs.show', ['level' => $level->slug, 'program' => $program->id])}}">
											{{Str::title($program->name)}} <span class="h4 fw-light text-white-75" >({{str::title($level->name)}}@if(!empty($level->abbr))({{str::title($level->abbr)}})@endif)</span> 
										</a> 

									 </h2>
							</div>
					    </div>
				    </div>
				</div>
            </div>
        </div>
        <!-- END Hero -->


         <!-- Page Content -->
<div class="content content-boxed">

    <div class="col-md-12 order-md-1">

            <!-- nav -->
            <div class="block block-rounded">
			
                
                    <ul class="nav nav-tabs nav-tabs-block bg-gray-lighter">
					@foreach($program_levels as $program_level)
						
                  <li class="nav-item">
                    <a href="{{route('institutions.program', ['institution' => $institution->id, 'level' => $program_level->slug, 'program' => $program->id])}}"><button
					@if(
					route('institutions.program', ['institution' => $institution->id, 'level' => $program_level->slug, 'program' => $program->id]) == url()->current()
					) 
					class="nav-link active" disabled
					@else
						class="nav-link"
					@endif
					> {{$program_level->name}}
					</button>
					</a>
                  </li>
				  @endforeach
                  
                </ul>
            </div>
            <!-- END nav -->
        </div>
   
   
   
    <div class="row">
		
		
		
		
	
        <div class="col-md-4 order-md-1">

            <!-- Ads -->
            <div class="block block-rounded">
                <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                    <h3 class="block-title">Ads</h3>
                </div>
                <div class="block-content">
                    <ul class="fa-ul list-icons">
					       
							<li class="mb-1">
								<span class="fa-li text-primary">
									<i class="fa fa-university"></i>
								</span>
								<div class="fw-semibold">Duration</div>
								<div class="text-muted">@if(!empty($institution_program->pivot->duration)){{$institution_program->pivot->duration}} Years @else N/A @endif</div>
								<meta itemprop="timeToComplete" content="P{{$institution_program->duration}}Y" />
							</li>
							<li class="mb-1">
								<span class="fa-li text-primary">
									<i class="fa fa-calendar"></i>
								</span>
								<div class="fw-semibold">Program Mode</div>
								<div itemprop="educationalProgramMode" class="text-muted">@if(!empty($institution_program->pivot->programMode)){{$institution_program->pivot->programMode->name}} @else N/A @endif</div>
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
            <!-- END Ads -->
        </div>

        <div  class="col-md-8 order-md-0">
             
			@if(!empty($institution_program->pivot->description))
            <!-- Program Description -->
            <div class="block block-rounded">
                <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                    <h3 class="block-title">Program Overview</h3>
                </div>
                <div class="block-content">

                
                    <span itemprop="description">
                         {!! $institution_program->pivot->description !!}  
                    </span>

                </div>
            </div>
            <!-- END Program Description -->
           @endif
		   
		   
          <!-- Admission Requirements -->
<div class="block block-rounded">
    <div class="block-header block-header-default justify-content-center" style="background-image: url(/media/patterns/cubes.png)">
        <div>
            <h3 class="block-title row justify-content-center">Admission Requirement</h3>
            <div class="fs-sm row text-center">{{Str::title($institution->name)}} Admission Requirement for {{Str::title($level->name)}} in {{Str::title($program->name)}}</div>
        </div>
    </div>
    <div class="block-content">

        <!-- UTME Admission Requirements -->
        <div itemscope itemtype="https://schema.org/EducationalOccupationalProgram" class="block block-rounded" >
            <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                <h3 class="block-title">
                    JAMB Unified Tertiary Matriculation Examination (UTME) Requirement
					 </h3>
            </div>
            <div class="block-content">
                <table class="table">
                    <tr>
                        <td class="fs-sm fw-semibold">Cut-Off</td>
                        <td >
                            <p class="m-0">{{ $institution_program->pivot->utme_cutoff }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="fs-sm fw-semibold">Subject Combination</td>
                        <td itemprop="programPrerequisites" itemscope itemtype="https://schema.org/EducationalOccupationalCredential">
                            <p itemprop="description" class="m-0">{{ $institution_program->pivot->requirements->utme_subjects }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="fs-sm fw-semibold">O'Level Requirement</td>
                        <td itemprop="programPrerequisites" itemscope itemtype="https://schema.org/EducationalOccupationalCredential">
                            <p itemprop="description" class="m-0">{{ $institution_program->pivot->requirements->o_level }}</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- END UTME Admission Requirements -->

		@if($level->id == 1)
        <!-- DE Admission Requirements -->
        <div class="block block-rounded" itemscope itemtype="https://schema.org/EducationalOccupationalProgram">
            <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                <h3 class="block-title">JAMB Direct Entry Requirements</h3>
            </div>
            <div class="block-content text-center">
                <div class="ms-2" itemprop="programPrerequisites" itemscope itemtype="https://schema.org/EducationalOccupationalCredential">
                    @if(!empty($institution_program->pivot->requirements->direct_entry))<p itemprop="description" class="m-0">{{ $institution_program->pivot->requirements->direct_entry }}</p> @else <span>No Direct Entry</span>  @endif
                </div>
            </div>
        </div>
        <!-- END DE Admission Requirements -->
         @endif
		 
    </div>
	<div class="d-flex justify-content-center fs-sm"> <span class="text-black"> Source: <a class="text-gray-dark" href="https://jamb.gov.ng/ibass">Jamb Integrated Brochure and Syllabus System</a> </span> </div>
            
</div>
<!-- END Admission Requirements -->

			
			<!-- Accreditation -->
            <div class="block block-rounded">
                <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                    <h3 class="block-title">Accreditation</h3>
                </div>
                <div class="block-content">
                    
					<table class="table">

                                <tr>
                                    <td class="fs-sm fw-semibold">Accreditation Body</td>
                                    <td><a class="link-fx link-dark" href="{{$institution_program->pivot->accreditationBody->url}}">{{$institution_program->pivot->accreditationBody->name}} @if(!empty($institution_program->pivot->accreditationBody->abbr)) <span>({{str::upper($institution_program->pivot->accreditationBody->abbr)}})</span> @endif </a> </td>
                                </tr>

                                <tr>
                                    <td class="fs-sm fw-semibold">Course Accreditation Status</td>
                                    <td>  
									@if(!empty($institution_program->pivot->accreditationStatus))
									<button type="button" class="btn btn-{{$institution_program->pivot->accreditationStatus->class}} rounded-0" disabled>
									{{$institution_program->pivot->accreditationStatus->name}}
									</button>
									@else
										Not Available
									@endif
					                </td>
                                  
								</tr>

                               
                            </table>
					
                </div>
            </div>
            <!-- END Accreditation -->

            <!-- Tuition Fee -->
            <div itemprop="offers" itemscope itemtype="https://schema.org/Offer" class="block block-rounded">
                <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                    <h3 class="block-title">Tuition Fee</h3>
                </div>
                <div itemprop="priceSpecification" itemscope itemtype="https://schema.org/PriceSpecification" class="block-content text-center text-center">
                    <p class="fs-lg">
                        @if(!empty($institution_program->pivot->tuition_fee)) <span itemprop="priceCurrency" content="NGN">₦</span> <span itemprop="Price"> {{Number::format($institution_program->pivot->tuition_fee, precision: 0)}}</span>  @else <span class="fs-5">Tuition Fee not available</span> @endif
                    </p>
                    
                </div>
            </div>
            <!-- END Tuition Fee -->
			
			
			<!-- All Instititions Offering Program -->
            <div class="block block-rounded">
                <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                    <h3 class="block-title">All Institutions Offering {{str::title($level->name)}} in {{Str::title($program->name)}}</h3>
                </div>
                <div class="block-content">
                    <a class="bg-info  block block-bordered block-link-shadow py-2 px-4 mb-3 text-center text-white fw-semibold" href="{{route('programs.institutions', ['level' => $level->slug, 'program' => $program->id])}}">
               View Institutions
            </a>

                </div>
            </div>
            <!-- END Other Instititions Offering Program -->

        </div>
    </div>
</div>
<!-- END Page Content -->



</span>



@endsection