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
                    @if($category->id == 4) 
                        Colleges Of Education 
                     @else 
                        {{ Str::of($category->name)->plural()->title()}}
                      @endif
                 @else
                    Tertiary Institutions
                 @endif in Nigeria

              </h1>
              
              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->




        <!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-content">

            <h2 class="content-heading text-center"> List of 
			@if(!empty($category)) 
			    @if($category->id === 4)
                    <span class="text-black"> Colleges of Education</span> 
				@else
                <span class="text-black">{{ Str::of($category->name)->plural()->title()}} </span> 
				@endif 
			@else 
				Academic Institutions of Higher Learning 
			@endif 
			
			in Nigeria.
			
</h2>
			
			
            <div itemscope itemtype="https://schema.org/ItemList" class="row items-push">
                <div itemprop="name" class="col-lg-4">
                    <div class="sticky-top" style="top: 100px;">
                        <p class="text-muted ">
                             list of  
							@if(!empty($category)) 
							    @if($category->id === 4)
                                    <span class="text-black"> Colleges of Education</span> 
								@else
                                     <span class="text-black">{{ Str::of($category->name)->plural()->title()}} </span> 
								@endif 
							@else 
								Higher Institutions 
							@endif 
							in Nigeria.
                        </p>

                        <p class="fs-sm">We provide comprehensive information about each of the schools as well as detailed insights into every course offered by these institutions. (eg. description, catchment areas, tuition fees, admission requirements, etc.)</p>

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
								  <div class="fs-4 text-white mb-1"> <span itemprop="name">{{str::title($institution->name)}}</span>
								   @if(!empty($institution->abbr))<span class="text-white-75 ">({{str::upper($institution->abbr)}})</span> @endif 
								</div>

							@if(!empty($institution->former_name)) <div class="text-white mb-2 fs-sm"> Former: <span itemprop="alternateName" class="text-white-75">{{str::title($institution->former_name)}}</span> </div> @endif  
								  <div class="fs-sm text-white-75 mb-0">
								   {{str::title($institution->schooltype->name)}} 
								   {{str::title($institution->category->name)}}. 
										<i class="fa fa-map-marker-alt ms-2 me-1 text-primary"></i> 
								<span itemprop="address" itemscope itemtype="https://schema.org/PostalAddress" >  
								@if(!empty($institution->locality)) <span itemprop="addressLocality">{{str::title($institution->locality)}}</span> - @endif    <span itemprop="addressRegion">{{str::title($institution->state->name)}}</span> 
								
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