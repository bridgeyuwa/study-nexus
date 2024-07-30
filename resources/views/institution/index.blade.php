@extends('layouts.backend')


@section('content')
@php use Illuminate\Support\Str; @endphp


<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-7">
              <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">

                 @if(!empty($category))
                   
                        {{$category->name_plural}}
                      
                 @else
                    Tertiary Institutions
                 @endif in Nigeria

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
                    <a href="{{route('institutions.index')}}"><button
					@if(
					route('institutions.index') == url()->current()
					) 
					class="btn-sm nav-link active" disabled
					@else
						class="btn-sm nav-link"
					@endif
					> All Institutions
					</button>
					</a>
                  </li>
					
					
					
					@foreach($categories as $institution_category)
					
					<li class="nav-item">
                    <a href="{{route('institutions.categories.index', ['category' => $institution_category->slug])}}"><button
					@if(
					route('institutions.categories.index', ['category' => $institution_category->slug]) == url()->current()
					) 
					class="btn-sm nav-link active" disabled
					@else
						class="btn-sm nav-link"
					@endif
					> {{$institution_category->name_plural}}
					</button>
					</a>
                  </li>
				  @endforeach
                  
                </ul>
            </div>
            <!-- END nav -->
        </div>


    <div class="block block-rounded">
        <div class="block-content">

            <h2 class="content-heading text-center"> List of 
			@if(!empty($category)) 
               {{$category->name_plural}}
			@else 
				Academic Institutions of Higher Learning 
			@endif 
			
			in Nigeria.
			
</h2>
			
			
            <div itemscope itemtype="https://schema.org/ItemList" class="row items-push">
			<link itemprop="url"  content="{{url()->current()}}" />
                <div  class="col-lg-4">
                    <div class="sticky-top" style="top: 100px;">
                        <p itemprop="name" class="text-muted ">
                             List of  
							@if(!empty($category)) 
							    {{$category->name_plural}} 
							@else 
								Higher Institutions 
							@endif 
							in Nigeria.
                        </p>

                        <p itemprop="description" class="fs-sm">We provide comprehensive information about each of the 
						@if(!empty($category)) 
							  {{$category->name_plural}}
							@else 
								Higher Institutions 
							@endif 
							as well as detailed insights into every course offered by these institutions. (eg. description, catchment areas, tuition fees, admission requirements, etc.)</p>

                    </div>
                </div>

                <div class="col-lg-8">

                    {{ $institutions->onEachSide(1)->links() }} 
					
					@foreach($institutions as $institution)
                    <div itemprop="itemListElement" itemscope itemtype="https://schema.org/CollegeOrUniversity">
						<a itemprop="url" href="{{route('institutions.show', ['institution' => $institution->id])}}" class="block block-rounded mb-3">
						@if(!empty($institution->url))  <link itemprop="sameAs" content="{{$institution->url}}" /> @endif
						  <div class="block block-header-default bg-image mb-0 fw-light"
							  style="background-image: url('/media/photos/photo11.jpg');">
							  <div class="bg-black-75 text-center p-3">
								  <div class="fs-5 text-white mb-1"> <span itemprop="name">{{$institution->name}}</span>
								   @if(!empty($institution->abbr))<span class="text-white-75 ">({{$institution->abbr}})</span> @endif 
								</div>

							@if(!empty($institution->former_name)) <div class="text-white mb-2 fs-sm"> Formerly: <span itemprop="alternateName" class="text-white-75">{{$institution->former_name}}</span> </div> @endif  
								  <div class="fs-sm text-white-75 mb-0">
								   {{$institution->schooltype->name}} 
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
					
					{{ $institutions->onEachSide(1)->links() }}

                </div>
            </div>
        </div>



    </div>
</div>

<!-- END Page Content -->


@endsection