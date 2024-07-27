@extends('layouts.backend')


@section('content')
@php use Illuminate\Support\Str; @endphp

<!-- Hero -->
<div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
    <div class="bg-black-75">
        <div class="content content-full content-top text-center pt-6">
            <div class="row">
                <div class="col-md-8 pt-4 pb-3">
                    <h1 class="fw-light text-white mb-1 h2"> Academic Institutions Offering {{Str::title($level->name)}} in {{Str::title($program->name)}} in Nigeria</h1>

                    
                </div>

                <div class="col-md-4 d-flex align-items-center">
                    <div class="block block-rounded block-transparent bg-black-50 text-center mb-0 mx-auto">
                        <div class="block-content block-content-full px-4 py-4">
                            <div class="fs-2 fw-semibold text-white">
                                

                                @php  
                               $min_tuition = $level->programs->min('pivot.tuition_fee');
                               $max_tuition = $level->programs->max('pivot.tuition_fee');
                          @endphp




                               @if(!empty($min_tuition)) 
                         @if($min_tuition == $max_tuition)
                                 @if($min_tuition >= 1010000) 
                                 ₦ {{Number::abbreviate($min_tuition, precision: 2)}}  
                                 @else 
                                 ₦ {{Number::abbreviate($min_tuition)}} 
                                 @endif
                         @else 
                                 @if($min_tuition >= 1010000) 
                                  ₦ {{Number::abbreviate($min_tuition, precision: 2)}} 
                                  @else 
                                  ₦ {{Number::abbreviate($min_tuition)}} 
                                 @endif

                                   <span class="fw-semibold">-</span> 

                                @if($max_tuition >= 1010000)   
                                   ₦ {{Number::abbreviate($max_tuition, precision: 2)}} 
                                @else 
                                   ₦ {{Number::abbreviate($max_tuition)}} 
                                @endif
                        @endif 
                                 
                  @endif



                            </div>
                            <div class="fs-sm fw-semibold text-uppercase text-white-50 mt-1 push">Annual Tuition</div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- END Hero -->


<!-- Page Content -->
<div class="content">
    <div itemscope itemtype="https://schema.org/ItemList" class="block block-rounded">
	<link itemprop="url"  content="{{url()->current()}}" />
	
        <div class="block-content">
            <h2 itemprop="name" class="content-heading text-center">Academic Institutions Offering {{str::title($level->name)}} in {{Str::title($program->name)}} in Nigeria</h2>
            <div class="row items-push">
                <div class="col-lg-4">
                    <p itemprop="description" class="text-muted sticky-top" style="top: 100px;">
                        A list of higher institutions offering <span class="text-black">{{str::title($level->name)}}</span> in <span class="text-black">{{str::title($program->name)}}</span> in Nigeria.
                    </p>
                </div>
                <div class="col-lg-8">
                                {{$institutions->links()}}
                    <div id="programs" role="tablist" aria-multiselectable="true">

                        @foreach( $institutions as $institution )
						
				  
						<div itemprop="itemListElement" itemscope itemtype="https://schema.org/CollegeOrUniversity">
								<a itemprop="url" href="{{route('institutions.program', ['institution' => $institution->id, 'level' => $level->slug, 'program' => $program->id])}}" class="block block-rounded mb-3">
								@if(!empty($institution->url))  <link itemprop="sameAs" content="{{$institution->url}}" /> @endif
								  <div class="block block-header-default bg-image mb-0 fw-light"
									  style="background-image: url('/media/photos/photo11.jpg');">
									  <div class="bg-black-75 text-center p-3">
										  <div class="fs-5 text-white mb-1"> <span itemprop="name">{{str::title($institution->name)}}</span>
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
                   {{$institutions->links()}}
                </div>
            </div>


        </div>
    </div>
</div>

<!-- END Page Content -->

@endsection