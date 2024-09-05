@extends('layouts.backend')


@section('content')

<!-- Hero -->
<div class="bg-image bg-studynexus-hero" >
    <div class="bg-black-75">
        <div class="content content-full content-top text-center pt-6">
           
                <div class="pt-4 pb-3">
                    <h1 class="h2 text-white mb-1"> Academic Institutions Offering {{$level->name}} in {{$program->name}} in Nigeria</h1>
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
					@foreach($program_levels as $program_level)
						
                  <li class="nav-item">
                    <a href="{{route('programs.institutions', ['level' => $program_level, 'program' => $program])}}"><button
					@if(
					route('programs.institutions', ['level' => $program_level, 'program' => $program]) == url()->current()
					) 
					class="btn-sm nav-link active" disabled
					@else
						class="btn-sm nav-link"
					@endif
					> {{$program_level->name}}
					</button>
					</a>
                  </li>
				  @endforeach
                  
                </ul>
            </div>
            <!-- END nav -->
        </div>




    <div itemscope itemtype="https://schema.org/ItemList" class="block block-rounded">
	<link itemprop="url"  content="{{url()->current()}}" />
	
        <div class="block-content">
            <h2 itemprop="name" class="content-heading text-center">Academic Institutions Offering {{$level->name}} in {{$program->name}} in Nigeria</h2>
            <div class="row items-push">
                <div class="col-lg-4">
                    <p itemprop="description" class="sticky-top" style="top: 100px;">
                        A list of higher institutions offering {{$level->name}} in {{$program->name}} in Nigeria.
                    </p>
                </div>
                <div class="col-lg-8">
                                {{$institutions->links()}}
                    <div id="programs" role="tablist" aria-multiselectable="true">

                        @foreach( $institutions as $institution )
						
				  
						<div itemprop="itemListElement" itemscope itemtype="https://schema.org/CollegeOrUniversity">
								<a itemprop="url" href="{{route('institutions.program.show', ['institution' => $institution, 'level' => $level, 'program' => $program])}}" class="block block-rounded mb-3">
								@if(!empty($institution->url))  <link itemprop="sameAs" content="{{$institution->url}}" /> @endif
								  <div class="block block-header-default bg-image mb-0 fw-light bg-studynexus-list">
									  <div class="bg-black-75 text-center p-3">
										  <div class="h6 text-white mb-1"> <span itemprop="name">{{$institution->name}}</span>
										   @if(!empty($institution->abbr))<span class="fw-light">({{$institution->abbr}})</span> @endif 
										</div>

									@if(!empty($institution->former_name)) <div class="text-white mb-2 fs-sm"> Formerly: <span itemprop="alternateName" class="text-white">{{$institution->former_name}}</span> </div> @endif  
										  <div class="fs-sm text-white mb-0">
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
                   {{$institutions->links()}}
                </div>
            </div>


        </div>
    </div>
</div>

<!-- END Page Content -->

@endsection