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

                     @isset($category) @if($category->id == 4) Colleges of Education @else {{str::of($category->name)->title()->plural}} @endif @else Tertiary Institutions                      @endisset in {{str::title($state->name)}} @if($state->id != 15) State @endif  - Nigeria
             </h1>
              
              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->


          <!-- Page Content -->
<div class="content">
    <div class="block block-rounded">

        <div itemscope itemtype="https://schema.org/ItemList" class="block-content">



            <!-- Introduction -->
            <h2 itemprop="name" class="content-heading text-center"> @isset($category) <span class="text-black">  @if($category->id == 4) Colleges of Education @else {{str::of($category->name)->title()->plural}} @endif   </span> @else All Tertiary Institutions @endisset in <span class="text-black">{{str::title($state->name)}} @if($state->id != 15) State @endif </span>,
                Nigeria
            </h2>
            <div class="row items-push">
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 100px;">
                        <p itemprop="description" class="text-muted ">
                            A List of accredited @isset($category) <span class="text-black"> @if($category->id == 4) Colleges of Education @else {{str::of($category->name)->title()->plural}} @endif </span> @else <span class="text-black">Universities</span>,
                            <span class="text-black">Polytechnics</span>, <span class="text-black">Monotechnics</span>, <span class="text-black">Colleges of Education</span> and <span class="text-black">Innovation Enterprise Institutions</span>@endisset
                            in <span class="text-black">{{str::title($state->name)}} @if($state->id != 15) State, @endif </span> Nigeria.
                        </p>
                    </div>
                </div>

                <div class="col-lg-8">

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

                </div>
            </div>
        </div>

    </div>
</div>

<!-- END Page Content -->


@endsection