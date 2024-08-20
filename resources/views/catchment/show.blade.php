@extends('layouts.backend')


@section('content')

<!-- Hero -->
        <div class="bg-image bg-studynexus-hero">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-7">
              <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">Universities in Nigeria with {{$catchment->name}} as Catchment </h1>

              
              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->

<!-- Breadcrumbs -->
		  {{Breadcrumbs::render()}}
		 <!-- End Breadcrumbs -->

      <!-- Page Content -->
<div class="content">
    <div itemscope itemtype="https://schema.org/ItemList" class="block block-rounded">
        <div class="block-content">
            <h2 itemprop="name"  class="content-heading text-center">Universities with {{$catchment->name}} @if(!empty($catchment->is_state)) State @endif as Catchment Area</h2>
            <div class="row items-push">
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 100px;">
                        <p  itemprop="description" class=" ">
                             List of <span class="text-black">Universities</span> in Nigeria which have <span class="text-black">{{$catchment->name}} @if(!empty($catchment->is_state)) State @endif</span> as a Catchment Area.
                        </p>


                        <p class="fs-sm">(In this context, <span class="text-decoration-underline">Catchment Area</span> refers to a designated geographic region or zone which a candidate originates from that receives preferential treatment or consideration in the admission
                            process for a tertiary institution based on cutoff or quotas set by such institution.) </p>
                        <p class="fs-sm">See <a href="{{route('institutions.catchments.policy')}}" class="">Catchment Area Policy</a></p>

                    </div>
                </div>

                <div class="col-lg-8">

                    @foreach($institutions as $institution)

					<div itemprop="itemListElement" itemscope itemtype="https://schema.org/CollegeOrUniversity">
                    <a itemprop="url" href="{{route('institutions.show', ['institution' => $institution])}}" class="block block-rounded mb-3">
                    @if(!empty($institution->url))  <link itemprop="sameAs" content="{{$institution->url}}" /> @endif
					  <div class="block block-header-default bg-image mb-0 fw-light bg-studynexus-list">
                          <div class="bg-black-75 text-center p-3">
                              <div class="fs-5 text-white mb-1"> <span itemprop="name">{{$institution->name}}</span>
                               @if(!empty($institution->abbr))<span class="text-white-75 ">({{$institution->abbr}})</span> @endif 
                            </div>

                        @if(!empty($institution->former_name)) <div class="text-white mb-2 fs-sm"> Formerly: <span itemprop="alternateName" class="text-white-75">{{$institution->former_name}}</span> </div> @endif  
                              <div class="fs-sm text-white-75 mb-0">
                               {{$institution->institutionType->name}} 
                               {{$institution->category->name}}. 
                                    <i class="fa fa-map-marker-alt ms-2 me-1 text-primary"></i> 
                            <span itemprop="address" itemscope itemtype="https://schema.org/PostalAddress" >  
							@if(!empty($institution->locality)) <span itemprop="addressLocality">{{$institution->locality}}</span> - @endif    <span itemprop="addressRegion">{{$institution->state->name}}</span> 
							
							@if(!empty($institution->address)) <meta itemprop="streetAddress" content="{{$institution->address}}" /> @endif
							@if(!empty($institution->postal_code)) <meta itemprop="postalCode" content="{{$institution->postal_code}}" /> @endif
							<meta itemprop="addressCountry" content="NG" />
							</span>
                            </div>
                              
                          </div>
                      </div>
                    </a> 
					</div>
				
				
				@endforeach

                </div>
            </div>
        </div>

    </div>
</div>

<!-- END Page Content -->

@endsection