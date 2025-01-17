@extends('layouts.backend')


@section('content')


<span itemscope itemtype="https://schema.org/EducationalOrganization">

<!-- Hero  -->
        <div class="bg-image studynexus-bg-hero" >
          <div class="bg-black-75">
            <div class="content content-boxed content-full pt-7">
              <div class="row">
			    @if(!empty($exam->examBody->logo))
				
			    <div class="col-md-2 d-flex align-items-center">
                  <div class="block block-rounded  block-transparent bg-black-50 text-center mb-0 mx-auto"  style="box-shadow:0 0 2.25rem #d1d8ea;opacity:1">
                    <div class="block-content block-content-full px-1 py-1">
					
                      <img  src="{{ Storage::url($exam->examBody->logo) }}" alt="{{$exam->examBody->name}} logo"  style="width: 100px; height: 100px; object-fit: cover;">
                      <link itemprop="logo" href="{{Storage::url($exam->examBody->logo)}}">
                    </div>
                  </div>
                </div>
				@endif
				
                <div class=" @if(!empty($exam->examBody->logo)) col-md-10 @endif d-flex align-items-center py-3">
					 <div class="w-100 text-center @if(!empty($exam->examBody->logo)) text-md-start @endif">
						<div class="h3  text-white mb-1 "> 
						<span itemprop="name">{{$exam->examBody->name}}</span> 
						@if(!empty($exam->examBody->abbr))
							(<span itemprop="alternateName" class="fw-light">{{$exam->examBody->abbr}}</span>)
						@endif 
						</div>
                          
						  <link itemprop="url" href="{{url()->current()}}">
						  <link itemprop="sameAs" href="{{$exam->examBody->url}}">
						  
						<div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress" class="h4 fs-sm  fw-light text-white mb-1">
							<div itemprop="streetAddress"> {{$exam->examBody->address}} </div>
							@if(!empty($exam->examBody->locality)) <span itemprop="addressLocality">{{$exam->examBody->locality}} </span>- @endif  <span itemprop="addressRegion">{{$exam->examBody->state->name}} @if(!empty($exam->examBody->state->is_state)) State @endif </span> 
						  @if(!empty($exam->examBody->postal_code)) <meta itemprop="postalCode" content="{{$exam->examBody->postal_code}}"> @endif
							<meta itemprop="addressCountry" content="NG">
							<div> Nigeria </div>
						
						</div>
						
						<h1 class="h3 text-white mt-3 mb-0">
								Syllabus for {{$exam->examBody->abbr}} Examination
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
						<i class="fa fa-share-alt opacity-50 me-1"></i> Share Syllabi
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


    <div class="row">
        <div class="col-md-4 order-md-1">

            <!-- Ads block -->
            <div class="block block-rounded ">
                <div class="block-header block-header-default studynexus-bg-cubes" >
                    <h3 class="block-title">Ads by Study<span class="text-primary-darker">Nexus</span></h3>
                </div>
                <div class="block-content fs-sm">

                    Advertise with Study<span class="text-primary-darker">Nexus</span>, <a href="{{route('contact')}}"> Contact us here </a>

                </div>
            </div>
            <!-- END Ads block -->
        </div>

        <div class="col-md-8 order-md-0">

            <!-- Programme Levels -->
            <div itemprop="hasOfferCatalog" itemscope itemtype="https://schema.org/OfferCatalog"  class="block block-rounded">
			
			<meta itemprop="name" content="Syllabus for {{$exam->examBody->abbr}} Exam">

			
                <div class="block-content">

                    @foreach($syllabi as $syllabus)
					<div itemprop="itemListElement" itemscope itemtype="https://schema.org/LearningResource" >
						<a class="block block-rounded block-bordered block-link-shadow" href="{{route('syllabus.show',['exam' => $exam, 'syllabus' => $syllabus])}}">
							<div class="block-content block-content-full d-flex align-items-center justify-content-between">
								<div class="me-3">
									<div class=" col fs-lg  mb-0 text-primary">
										<span itemprop="name" >{{$syllabus->name}} </span> 
									</div>   
								<link itemprop="url" href="{{route('syllabus.show',['exam' => $exam, 'syllabus' => $syllabus])}}" />
								  
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