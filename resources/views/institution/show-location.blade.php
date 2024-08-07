@extends('layouts.backend') 

@section('content') 

@php 
use Illuminate\Support\Str; 
use Illuminate\Support\Number; 
@endphp


      <!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-7">
              <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">

                     @if(!empty($categoryClass)) 
						{{$categoryClass->name_plural}}
					@else 
						Tertiary Institutions                      
					@endif in {{$state->name}} @if(!empty($state->is_state)) State @endif  - Nigeria
             </h1>
              
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

      <div class="col-md-12 order-md-1">

            <!-- nav -->
            <div class="block block-rounded">
			
					 <ul class="nav nav-tabs nav-tabs-block bg-gray-lighter">
					
					<li class="nav-item">
                    <a href="{{route('institutions.location.show', $state )}}"><button
					@if(
					route('institutions.location.show', $state) == url()->current()
					) 
					class="btn-sm nav-link active" disabled
					@else
						class="btn-sm nav-link"
					@endif
					> All Institutions in {{$state->name}} @if(!empty($state->is_state)) State @endif
					</button>
					</a>
                  </li>
					
					
					
					@foreach($categoryClasses as $institution_category)
					
					<li class="nav-item">
                    <a href="{{route('institutions.categories.location.show', ['categoryClass' => $institution_category, 'state' => $state])}}"><button
					@if(
					route('institutions.categories.location.show', [$institution_category, $state]) == url()->current()
					) 
					class="btn-sm nav-link active" disabled
					@else
						class="btn-sm nav-link"
					@endif
					> {{$institution_category->name_plural}} in {{$state->name}} @if(!empty($state->is_state)) State @endif
					
					</button>
					</a>
                  </li>
				  @endforeach
                  
                </ul>
            </div>
            <!-- END nav -->
        </div>


    <div class="block block-rounded">

        <div itemscope itemtype="https://schema.org/ItemList" class="block-content">

          <link itemprop="url"  content="{{url()->current()}}" />

            <!-- Introduction -->
            <h2 itemprop="name" class="content-heading text-center"> @if(!empty($categoryClass)) {{$categoryClass->name_plural}} </span> @else All Tertiary Institutions @endif in <span class="text-black">{{$state->name}} @if(!empty($state->is_state)) State @endif </span>,
                Nigeria
            </h2>
            <div class="row items-push">
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 100px;">
                        <p itemprop="description" class="text-muted ">
                            A List of accredited @if(!empty($categoryClass)) <span class="text-black"> {{$categoryClass->name_plural}} </span> @else <span class="text-black">Universities</span>,
                            <span class="text-black">Polytechnics</span>, <span class="text-black">Monotechnics</span>, <span class="text-black">Colleges of Education</span> and <span class="text-black">Innovation Enterprise Institutions</span>@endif
                            in <span class="text-black">{{$state->name}} @if(!empty($institution->state->is_state)) State @endif </span>, Nigeria.
                        </p>
						
						<div class="d-flex flex-row justify-content-between">
							<a href="{{route('search', $parameters)}}" ><button  type="button" class="btn btn-sm btn-outline-primary fw-light"><i class="fa fa-sliders-h me-1"></i> Filter </button> </a> 
							
							
							@if(!empty($categoryClass))
							<a href="
							
							@if(!empty($state))
							{{route('institutions.categories.ranking.state', ['categoryClass' => $categoryClass, 'state' => $state])}}
							@else
							{{route('institutions.categories.ranking', ['categoryClass' => $categoryClass])}} 
							@endif
							
							
							" > 
							<button  type="button" class="btn btn-sm btn-outline-dark fw-light"><i class="fa fa-trophy me-1"></i> Ranking </button> </a>
						@endif
						</div>
						
                    </div>
                </div>

                <div class="col-lg-8">

                    @foreach($institutions as $institution)
                    <div itemprop="itemListElement" itemscope itemtype="https://schema.org/CollegeOrUniversity">
                    <a itemprop="url" href="{{route('institutions.show', ['institution' => $institution])}}" class="block block-rounded mb-3">
                    @if(!empty($institution->url))  <link itemprop="sameAs" content="{{$institution->url}}" /> @endif
					  <div class="block block-header-default bg-image mb-0 fw-light"
                          style="background-image: url('/media/photos/photo11.jpg');">
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
							@if(!empty($institution->locality)) <span itemprop="addressLocality">{{$institution->locality}}</span> - @endif    <span itemprop="addressRegion">{{$institution->state->name}} @if(!empty($institution->state->is_state)) State @endif</span> 
							
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