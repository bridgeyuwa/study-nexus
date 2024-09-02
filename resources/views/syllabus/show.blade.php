@extends('layouts.backend')


@section('content')

<span itemscope itemtype="https://schema.org/Syllabus" >
  <link itemprop="url" href="{{url()->current()}}" >
<!-- Hero  -->
        <div itemprop="provider"  itemscope itemtype="https://schema.org/EducationalOrganization" class="bg-image bg-studynexus-hero" >
          <div class="bg-black-75">
            <div class="content content-boxed content-full pt-7">
              <div class="row">
			    @if(!empty($examBody->logo))
				
			    <div class="col-md-2 d-flex align-items-center">
                  <div class="block block-rounded  block-transparent bg-black-50 text-center mb-0 mx-auto" style="box-shadow:0 0 2.25rem #d1d8ea;opacity:1">
                    <div class="block-content block-content-full px-1 py-1">
					
                      <img  src="{{$examBody->logo}}" alt="{{$examBody->name}} logo"  style="width: 100px; height: 100px; object-fit: cover;">
                      <link itemprop="logo" href="{{$examBody->logo}}">
                    </div>
                  </div>
                </div>
				@endif
				
                <div class=" @if(!empty($examBody->logo)) col-md-10 @endif d-flex align-items-center pt-3">
					 <div class="w-100 text-center @if(!empty($examBody->logo)) text-md-start @endif">
						<div class="h3 fw-light text-white mb-1 "> 
						<span itemprop="name">{{$examBody->name}}</span> 
						@if(!empty($examBody->abbr))
							(<span itemprop="alternateName" class="text-white-75">{{$examBody->abbr}}</span>)
						@endif 
						</div>
                          
						  <link itemprop="sameAs" href="{{$examBody->url}}">
						  
						<div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress" class="h4 fs-sm  fw-light text-white-75 mb-1">
							<div itemprop="streetAddress"> {{$examBody->address}} </div>
							@if(!empty($examBody->locality)) <span itemprop="addressLocality">{{$examBody->locality}} </span>- @endif  <span itemprop="addressRegion">{{$examBody->state->name}} @if(!empty($examBody->state->is_state)) State @endif </span> 
						  @if(!empty($examBody->postal_code)) <meta itemprop="postalCode" content="{{$examBody->postal_code}}"> @endif
							<meta itemprop="addressCountry" content="NG">
							<div> Nigeria </div>
						
						</div>
						
						<h1 class="h3 fw-light text-white mt-3 mb-1">
							 {{$syllabus->name}}
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

	<div class="content content-boxed ">
			<meta itemprop="name" content="{{$syllabus->name}} Syllabus for {{$syllabus->subject->name}}">
			<p class="bg-white p-3" itemprop="description"> {{$syllabus->description}} </p>
				
			

			<object data="{{$syllabus->url}}" type="application/pdf" width="100%" height="500px" >
				<p class="bg-white p-3 text-center"> It appears you don't have a PDF Plugin for this browser. <a class="btn btn-primary" href="{{$syllabus->url}}" download> Download the {{$examBody->abbr}} Syllabus for {{$syllabus->subject->name}} </a> instead.
				
				
			</object>

	</div>

</span>

@endsection