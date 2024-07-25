@extends('layouts.backend') 

@section('content')
@php 
use Illuminate\Support\Str; 
use Illuminate\Support\Number;  
@endphp


<span itemscope itemtype="https://schema.org/CollegeOrUniversity">


		
		<!-- Hero  -->
        <div class="bg-image" style="background-image: url('/media/photos/photo13@2x.jpg');">
          <div class="bg-black-75">
            <div class="content content-boxed content-full py-5 pt-7">
              <div class="row">
			    @isset($institution->logo)
				
			    <div class="col-md-4 d-flex align-items-center">
                  <div class="block block-rounded  block-transparent bg-black-50 text-center mb-0 mx-auto" href="be_pages_jobs_apply.html" style="box-shadow:0 0 2.25rem #d1d8ea;opacity:1">
                    <div class="block-content block-content-full px-2 py-2">
					
                      <img  src="{{$institution->logo}}" alt="{{$institution->name}} logo" class="" style="width: 150px; height: 150px; object-fit: cover;"></img>
                      <link itemprop="logo" href="{{$institution->logo}}">
                    </div>
                  </div>
                </div>
				@endisset
				
                <div class=" @isset($institution->logo) col-md-8 @endisset d-flex align-items-center py-3">
					 <div class="w-100 text-center @isset($institution->logo)text-md-start @endisset">
						<h1 class="mb-1">  <a itemprop="url" class="fw-light text-white link-fx" href="{{route('institutions.show',['institution' => $institution->id])}}"> <span itemprop="name">{{Str::title($institution->name)}} </span> @if(!empty($institution->abbr))<span class="text-white-75">({{Str::upper($institution->abbr)}})</span>@endif </a></h1>
                          <link itemprop="sameAs" href="{{$institution->url}}">
						  

						<h2 itemprop="address" itemscope itemtype="https://schema.org/PostalAddress" class="h4 fs-md  fw-light text-white-75 mb-1">
							<meta itemprop="streetAddress" content="{{$institution->address}}">
							@isset($institution->locality) <span itemprop="addressLocality">{{str::title($institution->locality)}} </span>- @endisset  <span itemprop="addressRegion">{{str::title($institution->state->name)}} @isset($institution->state->type) State @endisset </span> 
						     <meta itemprop="postalCode" content="{{$institution->postal_code}}">
							<meta itemprop="addressCountry" content="NG">
						
						</h2>
						<div class="text-white mb-3">
						@isset($institution->slogan)( <i itemprop="slogan">{{$institution->slogan}}</i> ) @endisset
						</div>
						
						<h2 class="h3 fw-light text-white">{{str::title($level->name)}} Programs</h2>
					 </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->


        <!-- Page Content -->
<div class="content">
    <div class="block block-rounded">

        <div class="block-content">
           
            <h2  class="content-heading text-center">Accredited Courses Offered at {{Str::title($institution->name)}}</h2>
            <div itemprop="hasOfferCatalog" itemscope itemtype="https://schema.org/OfferCatalog" class="row items-push">
                <div class="col-lg-4">
                    <p class="text-muted sticky-top" style="top: 100px;">
                        Explore the official list of accredited <span itemprop="name" class="text-black-75">{{str::title($level->name)}} programmes </span> grouped by their various disciplines offered at <span class="text-black-75">{{Str::title($institution->name)}}</span>.
                    </p>
                </div>
                
                <div  class="col-lg-8">
                    <div id="programs" role="tablist" aria-multiselectable="true">

                        @foreach( $programs as $collegeName => $programs)
                        <div itemprop="itemListElement" itemscope itemtype="https://schema.org/OfferCatalog" class="block block-rounded mb-1">
                            <a class="fs-lg link-primary fw-semibold" data-bs-toggle="collapse" data-bs-parent="#programs" href="#programs_q{{$loop->iteration}}" aria-expanded="false" aria-controls="programs_q{{$loop->iteration}}">
								<div class="block-header block-header-default fs-5" role="tab" id="programs_h{{$loop->iteration}}">
								     <div itemprop="name">{{str::title($collegeName)}}</div>  <span class="toggle-icon fw-light fs-2 "></span>
								</div>
                            </a>
                            <div id="programs_q{{$loop->iteration}}" class="collapse" role="tabpanel" aria-labelledby="programs_h{{$loop->iteration}}" data-bs-parent="#programs">
                                <div class="block-content">

                                    @foreach($programs as $program)
                                    <div itemprop="itemListElement" itemscope itemtype="https://schema.org/OfferCatalog" class="block block-rounded mb-1">
                                        <a  itemscope itemtype="https://schema.org/EducationalOccupationalProgram" class="fw-normal" href="{{route('institutions.program', ['institution' => $institution->id, 'level' => $level->slug, 'program' => $program->id])}}">
											<div class="block-header block-header-default fs-6">
											 <span itemprop="name"> {{Str::title($program->name)}} </span>
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

</span>


@endsection