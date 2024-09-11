@extends('layouts.backend') 

@section('content')
@php 
use Illuminate\Support\Number;  
@endphp


<span itemscope itemtype="https://schema.org/CollegeOrUniversity">

		
		<!-- Hero  -->
        <div class="bg-image bg-studynexus-hero" >
          <div class="bg-black-75">
            <div class="content content-boxed content-full pt-7">
              <div class="row">
			    @if(!empty($institution->logo))
				
			    <div class="col-md-2 d-flex align-items-center">
                  <div class="block block-rounded  block-transparent bg-black-50 text-center mb-0 mx-auto" style="box-shadow:0 0 2.25rem #d1d8ea;opacity:1">
                    <div class="block-content block-content-full px-1 py-1">
					
                      <img  src="{{$institution->logo}}" alt="{{$institution->name}} logo" style="width: 100px; height: 100px; object-fit: cover;">
                      <link itemprop="logo" href="{{$institution->logo}}">
                    </div>
                  </div>
                </div>
				@endif
				
                <div class=" @if(!empty($institution->logo)) col-md-10 @endif d-flex align-items-center pt-3">
					 <div class="w-100 text-center @if(!empty($institution->logo))text-md-start @endif">
						<h1 class="h2 text-white mb-1">   <span itemprop="name">{{$institution->name}} </span> @if(!empty($institution->abbr))<span class="fw-light">({{$institution->abbr}})</span>@endif </h1>
                         
						  <link itemprop="url" href="{{url()->current()}}">
						  <link itemprop="sameAs" href="{{$institution->url}}">
						  

						<h2 itemprop="address" itemscope itemtype="https://schema.org/PostalAddress" class="h4 fs-md  fw-light text-white mb-1">
							<meta itemprop="streetAddress" content="{{$institution->address}}">
							@if(!empty($institution->locality)) 
<span itemprop="addressLocality">{{$institution->locality}} </span>- @endif  <span itemprop="addressRegion">{{$institution->state->name}} @if(!empty($institution->state->is_state)) State @endif </span> 
						     <meta itemprop="postalCode" content="{{$institution->postal_code}}">
							<meta itemprop="addressCountry" content="NG">
						
						</h2>
						<div class="text-white mb-3">
						@if(!empty($institution->slogan))( <i itemprop="slogan">{{$institution->slogan}}</i> ) @endif
						</div>
						
						<h2 class="h3 text-white mb-0">
                    {{$program->name}} Programmes <span class="fw-light fs-5">(Levels)</span>
                </h2>
					 </div>
                </div>
              </div>
            </div>
          </div>
		  
		   <div class="d-flex justify-content-end py-1">
			
			
			
			@if($institution->news->isNotEmpty())
		  
		  <!-- Notifications Dropdown -->
            <div class="dropdown d-inline-block me-1">
              <button type="button" class="btn btn-sm btn-primary" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="fa fa-fw fa-building-columns"></i> <i class="fa fa-fw fa-rss"></i>
                <span class="badge rounded-pill">Latest {{$institution->abbr}} News</span>
              </button>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                <div class="bg-primary-dark rounded-top fw-semibold text-white text-center p-3">
                  Latest News from {{$institution->abbr}}
                </div>
                <ul class="nav-items my-2">
				
				@foreach($institution->news->take(3) as $news)
                  <li>
                    <a class="d-flex text-dark py-2" href="{{route('institutions.news.show',['institution' => $institution, 'news' => $news])}}">
                      <div class="flex-shrink-0 mx-3">
                        <i class="fa fa-fw fa-coins text-success"></i>
                      </div>
                      <div class="flex-grow-1 fs-sm pe-2">
                        <div class="fw-semibold">{{$news->title}}</div>
                        <div class="text-muted">{{$news->created_at->diffForHumans()}}</div>
                      </div>
                    </a>
                  </li>
				  @endforeach
				  
                  
                </ul>
                <div class="p-2 border-top text-center">
                  <a class="btn btn-alt-primary w-100" href="{{route('institutions.news',['institution' => $institution])}}">
                    <i class="fa fa-fw fa-eye opacity-50 me-1"></i> View All
                  </a>
                </div>
              </div>
            </div>
            <!-- END Notifications Dropdown -->
		  
		  
		  @endif
		  
		  
		   <!-- Social Actions -->
				
				<div class="btn-group me-1" role="group">
					<button type="button" class="btn btn-sm btn-alt-primary dropdown-toggle" id="dropdown-blog-news" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-share-alt opacity-50 me-1"></i> Share
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
            <div itemprop="hasOfferCatalog" itemscope itemtype="https://schema.org/OfferCatalog" class="block block-rounded">
                <div class="block-header block-header-default text-center bg-studynexus-cubes" >
                    <h3 itemprop="name" class="block-title">{{$program->name}} Programme Levels</h3>
                </div>
                <div class="block-content">

                    @foreach($levels as $level)
					<div itemprop="itemListElement" itemscope itemtype="https://schema.org/OfferCatalog">
                    <a  itemscope itemtype="https://schema.org/EducationalOccupationalProgram" class="block block-rounded block-bordered block-link-shadow" href="{{route('institutions.program.show', ['institution' => $institution, 'level' => $level, 'program' => $program])}}">
                  <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                    <div class="me-3">
                      <div class=" col fs-lg  mb-0 text-primary">
                       <span itemprop="name"> {{$level->name}} <span class="">({{$program->name}})</span> </span>
                      </div>                      
                      <p itemprop="offers" itemscope itemtype="https://schema.org/Offer" class=" mb-0">                       
                        @if(!empty($level->programs->where('id', $program->id)->first()->pivot->tuition_fee))
					<span itemprop="priceSpecification" itemscope itemtype="https://schema.org/PriceSpecification">	
				     <span itemprop="priceCurrency" content="NGN">₦</span> <span itemprop="Price">{{ Number::format($level->programs->where('id', $program->id)->first()->pivot->tuition_fee)}} </span>  
				</span>
						@endif
							 
					  </p>
                    </div>
                    <div>
                      <i class="fa fa-circle-right  text-xwork text-primary"></i> 
                    </div>
                  </div>
                </a> @endforeach
                 </div>
                </div>
            </div>
            <!-- END Programme Levels -->

        </div>
    </div>
</div>
<!-- END Page Content -->

</span>


@endsection