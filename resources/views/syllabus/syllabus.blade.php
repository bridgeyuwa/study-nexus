@extends('layouts.backend')


@section('content')


<span itemscope itemtype="https://schema.org/EducationalOrganization">

<!-- Hero  -->
        <div class="bg-image bg-studynexus-hero" >
          <div class="bg-black-75">
            <div class="content content-boxed content-full py-5 pt-7">
              <div class="row">
			    @if(!empty($examBody->logo))
				
			    <div class="col-md-4 d-flex align-items-center">
                  <div class="block block-rounded  block-transparent bg-black-50 text-center mb-0 mx-auto" href="be_pages_jobs_apply.html" style="box-shadow:0 0 2.25rem #d1d8ea;opacity:1">
                    <div class="block-content block-content-full px-2 py-2">
					
                      <img  src="{{$examBody->logo}}" alt="{{$examBody->name}} logo" class="" style="width: 150px; height: 150px; object-fit: cover;">
                      <link itemprop="logo" href="{{$examBody->logo}}">
                    </div>
                  </div>
                </div>
				@endif
				
                <div class=" @if(!empty($examBody->logo)) col-md-8 @endif d-flex align-items-center py-3">
					 <div class="w-100 text-center @if(!empty($examBody->logo)) text-md-start @endif">
						<div class="h3 fw-light text-white mb-1 "> 
						<span itemprop="name">{{$examBody->name}}</span> 
						@if(!empty($examBody->abbr))
							(<span itemprop="alternateName" class="text-white-75">{{$examBody->abbr}}</span>)
						@endif 
						</div>
                          
						  <link itemprop="url" href="{{url()->current()}}">
						  <link itemprop="sameAs" href="{{$examBody->url}}">
						  
						<div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress" class="h4 fs-sm  fw-light text-white-75 mb-1">
							<div itemprop="streetAddress"> {{$examBody->address}} </div>
							@if(!empty($examBody->locality)) <span itemprop="addressLocality">{{$examBody->locality}} </span>- @endif  <span itemprop="addressRegion">{{$examBody->state->name}} @if(!empty($examBody->state->is_state)) State @endif </span> 
						  @if(!empty($examBody->postal_code)) <meta itemprop="postalCode" content="{{$examBody->postal_code}}"> @endif
							<meta itemprop="addressCountry" content="NG">
							<div> Nigeria </div>
						
						</div>
						
						<h1 class="fw-light text-white mt-5 mb-1">
								List of Syllabi for {{$examBody->abbr}} Exam
						</h1>
						
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


    <div class="row">
        <div class="col-md-4 order-md-1">

            <!-- Ads -->
            <div class="block block-rounded">
                <div class="block-header block-header-default bg-studynexus-cubes" >
                    <h3 class="block-title">Ads</h3>
                </div>
                <div class="block-content">
                    Ads
                </div>
            </div>
            <!-- END Ads -->
        </div>

        <div class="col-md-8 order-md-0">

            <!-- Programme Levels -->
            <div itemprop="hasOfferCatalog" itemscope itemtype="https://schema.org/OfferCatalog"  class="block block-rounded">
			
			<h1 itemprop="name" class="content-heading text-center">  List of Syllabi for {{$examBody->abbr}} Exam  </h1>

			
                <div class="block-content">

                    @foreach($syllabi as $syllabus)
					<div itemprop="itemListElement" itemscope itemtype="https://schema.org/LearningResource" >
						<a class="block block-rounded block-bordered block-link-shadow" href="{{route('syllabus.show',['examBody' => $examBody, 'syllabus' => $syllabus])}}">
							<div class="block-content block-content-full d-flex align-items-center justify-content-between">
								<div class="me-3">
								  <div class=" col fs-lg  mb-0 text-primary">
									<span itemprop="name" >{{$syllabus->name}} </span> 
									<div class="fs-sm text-black">{{$syllabus->subject->name}}</div>
								  </div>   
								<link itemprop="url" href="{{route('syllabus.show',['examBody' => $examBody, 'syllabus' => $syllabus])}}" />
								  
								</div>
								<div>
									<i class="fa fa-circle-right  text-xwork text-primary"></i> 
								</div>
							</div>
						</a> 
					</div>
					@endforeach
                </div>
            </div>
            <!-- END Programme Levels -->

        </div>
    </div>
</div>
<!-- END Page Content -->
		
		
</span>
		
		


@endsection