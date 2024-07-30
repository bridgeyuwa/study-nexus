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
						<h1 class="mb-1">  <a  class="fw-light text-white link-fx" href="{{route('institutions.show',['institution' => $institution->id])}}"> <span itemprop="name">{{$institution->name}} </span> @if(!empty($institution->abbr))<span class="text-white-75">({{$institution->abbr}})</span>@endif </a></h1>
                         
						  <link itemprop="url" href="{{url()->current()}}">
						  <link itemprop="sameAs" href="{{$institution->url}}">
						  

						<h2 itemprop="address" itemscope itemtype="https://schema.org/PostalAddress" class="h4 fs-md  fw-light text-white-75 mb-1">
							<meta itemprop="streetAddress" content="{{$institution->address}}">
							@if(!empty($institution->locality)) 
<span itemprop="addressLocality">{{$institution->locality}} </span>- @endif  <span itemprop="addressRegion">{{$institution->state->name}} @if(!empty($institution->state->is_state)) State @endif </span> 
						     <meta itemprop="postalCode" content="{{$institution->postal_code}}">
							<meta itemprop="addressCountry" content="NG">
						
						</h2>
						<div class="text-white mb-3">
						@if(!empty($institution->slogan))( <i itemprop="slogan">{{$institution->slogan}}</i> ) @endif
						</div>
						
						<h2 class="h3 fw-light text-white">
                    {{$program->name}} Programs <span class="text-white-75">(Levels)</span>
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
    <div class="row">
        <div class="col-md-4 order-md-1">

            <!-- Ads -->
            <div class="block block-rounded">
                <div class="block-header block-header-default" style="background-image: url(/media/patterns/cubes.png)">
                    <h3 class="block-title">Ads</h3>
                </div>
                <div class="block-content">
                    Ads
                </div>
            </div>
            <!-- END Ads -->
        </div>

        <div class="col-md-8 order-md-0">

            <!-- Program Levels -->
            <div itemprop="hasOfferCatalog" itemscope itemtype="https://schema.org/OfferCatalog" class="block block-rounded">
                <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                    <h3 itemprop="name" class="block-title">{{$program->name}} Program Levels</h3>
                </div>
                <div class="block-content">

                    @foreach($levels as $level)
					<div itemprop="itemListElement" itemscope itemtype="https://schema.org/OfferCatalog">
                    <a  itemscope itemtype="https://schema.org/EducationalOccupationalProgram" class="block block-rounded block-bordered block-link-shadow" href="{{route('institutions.program.show', ['institution' => $institution->id, 'level' => $level->slug, 'program' => $program->id])}}">
                  <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                    <div class="me-3">
                      <div class=" col fs-lg  mb-0 text-primary">
                       <span itemprop="name"> {{$level->name}} <span class="text-muted">({{$program->name}})</span> </span>
                      </div>                      
                      <p itemprop="offers" itemscope itemtype="https://schema.org/Offer" class="text-muted mb-0">                       
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
            <!-- END Program Levels -->

        </div>
    </div>
</div>
<!-- END Page Content -->

</span>


@endsection