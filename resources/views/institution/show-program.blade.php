@extends('layouts.backend') 

@section('content') 
@php 
use Illuminate\Support\Number;
@endphp


<span itemscope itemtype="https://schema.org/EducationalOccupationalProgram">
<meta itemprop="name" content="{{$level->name}} in {{$program->name}}" />

		<!-- Hero  -->
        <div itemprop="provider" itemscope itemtype="https://schema.org/CollegeOrUniversity" class="bg-image bg-studynexus-hero" >
			<div  class="bg-black-75">
				<div class="content content-boxed content-full py-5 pt-7">
				    <div class="row">
							@if(!empty($institution->logo))
							
							<div class="col-md-4 d-flex align-items-center">
							  <div class="block block-rounded  block-transparent bg-black-50 text-center mb-0 mx-auto" href="be_pages_jobs_apply.html" style="box-shadow:0 0 2.25rem #d1d8ea;opacity:1">
								<div class="block-content block-content-full px-2 py-2">
								
								  <img  src="{{$institution->logo}}" alt="{{$institution->name}} logo" class="" style="width: 150px; height: 150px; object-fit: cover;">
								  <link itemprop="logo" href="{{$institution->logo}}">
								</div>
							  </div>
							</div>
							@endif
							
						<div class=" @if(!empty($institution->logo)) col-md-8 @endif d-flex align-items-center py-3">
							<div class="w-100 text-center @if(!empty($institution->logo))text-md-start @endif">
									<h1 class="fw-light text-white mb-1">  <span itemprop="name">{{$institution->name}} </span> @if(!empty($institution->abbr))<span class="text-white-75">({{$institution->abbr}})</span>@endif </h1>
									  
									<link itemprop="url" href="{{url()->current()}}">
									<link itemprop="sameAs" href="{{$institution->url}}">
									  

									<h2 itemprop="address" itemscope itemtype="https://schema.org/PostalAddress" class="h4 fs-md  fw-light text-white-75 mb-1">
										<meta itemprop="streetAddress" content="{{$institution->address}}">
										@if(!empty($institution->locality)) <span itemprop="addressLocality">{{$institution->locality}} </span>- @endif  <span itemprop="addressRegion">{{$institution->state->name}} @if(!empty($institution->state->is_state)) State @endif </span> 
										 <meta itemprop="postalCode" content="{{$institution->postal_code}}">
										<meta itemprop="addressCountry" content="NG">
									
									</h2>
									<div class="text-white mb-3">
									@if(!empty($institution->slogan))( <i itemprop="slogan">{{$institution->slogan}}</i> ) @endif
									</div>
									
									<h2 class="h3 fw-light text-white"> 
											{{$program->name}} <span class="h4 fw-light text-white-75" >({{$level->name}}@if(!empty($level->abbr))({{$level->abbr}})@endif)</span> 
									</h2>
							</div>
					    </div>
				    </div>
					
				</div>
            </div>
        </div>
        <!-- END Hero -->
  
		 <!-- Breadcrumbs -->
		  {{Breadcrumbs::render()}}
		 <!-- End Breadcrumbs -->
  
         <!-- Page Content -->
<div class="content content-boxed">

    <div class="col-md-12">

            <!-- nav -->
            <div class="block block-rounded">
			
                
                    <ul class="nav nav-tabs nav-tabs-block bg-gray-lighter">
					@foreach($program_levels as $program_level)
						
                  <li class="nav-item">
                    <a href="{{route('institutions.program.show', ['institution' => $institution, 'level' => $program_level, 'program' => $program])}}">
					<button
					@if(
					route('institutions.program.show', ['institution' => $institution, 'level' => $program_level, 'program' => $program]) == url()->current()
					) 
					class="btn-sm nav-link active" disabled
					@else
						class="btn-sm nav-link"
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
                <div class="block-header block-header-default text-center bg-studynexus-cubes" >
                    <h3 class="block-title">Ads</h3>
                </div>
                <div class="block-content">
                    <ul class="fa-ul list-icons">
					       
							<li class="mb-1">
								<span class="fa-li text-primary">
									<i class="fa fa-university"></i>
								</span>
								<div class="fw-semibold">Duration</div>
								<div class="">@if(!empty($institution_program->pivot->duration)){{$institution_program->pivot->duration}} Years @else N/A @endif</div>
								<meta itemprop="timeToComplete" content="P{{$institution_program->duration}}Y" />
							</li>
							<li class="mb-1">
								<span class="fa-li text-primary">
									<i class="fa fa-calendar"></i>
								</span>
								<div class="fw-semibold">Programme Mode</div>
								<div itemprop="educationalProgramMode" class="">@if(!empty($institution_program->pivot->programMode)){{$institution_program->pivot->programMode->name}} @else N/A @endif</div>
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
            <!-- END Ads -->
        </div>

        <div  class="col-md-8 order-md-0">
             
			@if(!empty($institution_program->pivot->description))
            <!-- Programme Description -->
            <div class="block block-rounded">
                <div class="block-header block-header-default text-center bg-studynexus-cubes" >
                    <h3 class="block-title">Programme Overview</h3>
                </div>
                <div class="block-content">

                
                    <span itemprop="description">
                         {!! $institution_program->pivot->description !!}  
                    </span>

                </div>
            </div>
            <!-- END Programme Description -->
           @endif
		   
		   
          <!-- Admission Requirements -->
<div class="block block-rounded">
    <div class="block-header block-header-default justify-content-center bg-studynexus-cubes" >
        <div>
            <h3 class="block-title row justify-content-center">Admission Requirement</h3>
            <div class="fs-sm row text-center">{{$institution->name}} Admission Requirement for {{$level->name}} in {{$program->name}}</div>
        </div>
    </div>
    <div class="block-content">

        <!-- UTME Admission Requirements -->
        <div itemscope itemtype="https://schema.org/EducationalOccupationalProgram" class="block block-rounded" >
            <div class="block-header block-header-default text-center bg-studynexus-cubes" >
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
            <div class="block-header block-header-default text-center bg-studynexus-cubes" >
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
	       
</div>
<!-- END Admission Requirements -->


			@if(!empty($institution_program->pivot->remarks))
			<div class="block block-rounded">
                <div class="block-header block-header-default text-center bg-studynexus-cubes" >
                    <h3 class="block-title">Special Remarks</h3>
                </div>
                <div class="block-content">
                    <p> {{$institution_program->pivot->remarks}} </p>
				</div>
            </div>
			@endif

			
			<!-- Accreditation -->
            <div class="block block-rounded">
                <div class="block-header block-header-default text-center bg-studynexus-cubes" >
                    <h3 class="block-title">Accreditation</h3>
                </div>
                <div class="block-content">
                    
					<table class="table">

                                <tr>
                                    <td class="fs-sm fw-semibold">Accreditation Body</td>
                                    <td><a class="link-fx link-dark" href="{{$institution_program->pivot->accreditationBody->url}}">{{$institution_program->pivot->accreditationBody->name}} @if(!empty($institution_program->pivot->accreditationBody->abbr)) <span>({{$institution_program->pivot->accreditationBody->abbr}})</span> @endif </a> </td>
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
                <div class="block-header block-header-default text-center bg-studynexus-cubes" >
                    <h3 class="block-title">Tuition Fee</h3>
                </div>
                <div itemprop="priceSpecification" itemscope itemtype="https://schema.org/PriceSpecification" class="block-content text-center text-center">
                    <p class="fs-lg">
                        @if(!empty($institution_program->pivot->tuition_fee)) <span itemprop="priceCurrency" content="NGN">₦</span> <span itemprop="Price"> {{Number::format($institution_program->pivot->tuition_fee, precision: 0)}}</span>  @else <span class="fs-5">Tuition Fee not available</span> @endif
                    </p>
                    
                </div>
            </div>
            <!-- END Tuition Fee -->
			
			
			<!-- All Instititions Offering Programme -->
            <div class="block block-rounded">
                <div class="block-header block-header-default text-center bg-studynexus-cubes" >
                    <h3 class="block-title">All Institutions Offering {{$level->name}} in {{$program->name}}</h3>
                </div>
                <div class="block-content">
                    <a class="bg-info  block block-bordered block-link-shadow py-2 px-4 mb-3 text-center text-white fw-semibold" href="{{route('programs.institutions', ['level' => $level, 'program' => $program])}}">
               View Institutions
            </a>

                </div>
            </div>
            <!-- END Other Instititions Offering Programme -->

        </div>
    </div>
</div>
<!-- END Page Content -->



</span>



@endsection