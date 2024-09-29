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
					
                      <img  src="{{ Storage::url($examBody->logo) }}" alt="{{$examBody->name}} logo"  style="width: 100px; height: 100px; object-fit: cover;">
                      <link itemprop="logo" href="{{$examBody->logo}}">
                    </div>
                  </div>
                </div>
				@endif
				
                <div class=" @if(!empty($examBody->logo)) col-md-10 @endif d-flex align-items-center pt-3">
					 <div class="w-100 text-center @if(!empty($examBody->logo)) text-md-start @endif">
						<div class="h3 text-white mb-1 "> 
						<span itemprop="name">{{$examBody->name}}</span> 
						@if(!empty($examBody->abbr))
							(<span itemprop="alternateName" class="fw-light">{{$examBody->abbr}}</span>)
						@endif 
						</div>
                          
						  <link itemprop="sameAs" href="{{$examBody->url}}">
						  
						<div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress" class="h4 fs-sm fw-light text-white mb-1">
							<div itemprop="streetAddress"> {{$examBody->address}} </div>
							@if(!empty($examBody->locality)) <span itemprop="addressLocality">{{$examBody->locality}} </span>- @endif  <span itemprop="addressRegion">{{$examBody->state->name}} @if(!empty($examBody->state->is_state)) State @endif </span> 
						  @if(!empty($examBody->postal_code)) <meta itemprop="postalCode" content="{{$examBody->postal_code}}"> @endif
							<meta itemprop="addressCountry" content="NG">
							<div> Nigeria </div>
						
						</div>
						
						<h1 class="h3 text-white mt-3 mb-1">
							 {{$syllabus->name}}
						</h1>
						
					 </div>
						
                </div>
              </div>
            </div>
          </div>
		  
		  <div class="d-flex justify-content-end py-1">		
		   <!-- Social Actions -->
				
				<div class="btn-group me-1" role="group">
					<button type="button" class="btn btn-sm btn-alt-primary dropdown-toggle" id="dropdown-blog-news" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-share-alt opacity-50 me-1"></i> Share Syllabus
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

	<div class="content content-boxed ">
			<meta itemprop="name" content="{{$syllabus->name}} Syllabus for {{$syllabus->subject->name}}">
			<p class="bg-white p-3" itemprop="description"> {{$syllabus->description}} </p>
				
			

			<object data="{{Storage::url($syllabus->attachment)}}" type="application/pdf" width="100%" height="500px" >
				<p class="bg-white p-3 text-center"> It appears you don't have a PDF Plugin for this browser. <a class="btn btn-primary" href="{{Storage::url($syllabus->attachment)}}" download> Download the {{$examBody->abbr}} Syllabus for {{$syllabus->subject->name}} </a> instead.
				
				
			</object>

	</div>

</span>

@endsection