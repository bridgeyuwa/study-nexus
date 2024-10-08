@extends('layouts.backend')


@section('content')
<!-- Hero -->
        <div class="bg-image bg-studynexus-hero">
          <div class="bg-black-50">
            <div class="content content-top content-full text-center">
              <h1 class="h2 text-white mt-5 mb-2">
                 {{ $categoryClass->name_plural ?? 'Higher Institutions' }} in Nigeria
              </h1>
              </div>
          </div>
		  
		  <div class="d-flex justify-content-end py-1">		
		     <!-- Social Actions -->
				
				<div class="btn-group me-1" role="group">
					<button type="button" class="btn btn-sm btn-alt-primary dropdown-toggle" id="dropdown-blog-news" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-share-alt opacity-50 me-1"></i> Share {{ $categoryClass->name_plural ?? 'Institutions' }}
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
					
					
					
					@foreach($categoryClasses as $institution_category)
					
					<li class="nav-item">
                    <a href="{{route('institutions.categories.index', ['categoryClass' => $institution_category])}}"><button
					@if(
					route('institutions.categories.index', ['categoryClass' => $institution_category]) == url()->current()
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
 <span id="results"></span>

    <div class="block block-rounded">
        <div class="block-content">

            <h2 class="content-heading text-center"> List of 
			@if(!empty($categoryClass)) 
               {{$categoryClass->name_plural}}
			@else 
				Academic Institutions of Higher Learning 
			@endif 
			
			in Nigeria.
			
</h2>
			
			
            <div itemscope itemtype="https://schema.org/ItemList" class="row items-push">
			<link itemprop="url"  content="{{url()->current()}}" />
                <div  class="col-lg-4">
                    <div class="sticky-top" style="top: 100px;">
                        <p itemprop="name" class=" ">
                             List of  
							@if(!empty($categoryClass)) 
							    {{$categoryClass->name_plural}} 
							@else 
								Higher Institutions 
							@endif 
							in Nigeria.
                        </p>

                        <p itemprop="description" class="fs-sm">We provide comprehensive information about each of the 
						@if(!empty($categoryClass)) 
							  {{$categoryClass->name_plural}}
							@else 
								Higher Institutions 
							@endif 
							as well as detailed insights into every course offered by these institutions. (eg. description, catchment areas, tuition fees, admission requirements, etc.)</p>

                   
						<div class="d-flex flex-row justify-content-between">
							<a href="{{route('search', $parameters)}}" ><button  type="button" class="btn btn-sm btn-outline-primary fw-light"><i class="fa fa-sliders-h me-1"></i> Filter </button> </a>     

							@if(!empty($categoryClass))
								<a href="{{ route('institutions.categories.ranking',['categoryClass' => $categoryClass]) }}" > <button  type="button" class="btn btn-sm btn-outline-dark fw-light"><i class="fa fa-trophy me-1"></i> Ranking </button> </a>
							@endif
						
						</div>
						

                    </div>
                </div>
				
				
				
                <div class="col-lg-8 border pt-3">

                    {{ $institutions->onEachSide(1)->links() }} 
					
					@foreach($institutions as $institution)
                    <div itemprop="itemListElement" itemscope itemtype="https://schema.org/CollegeOrUniversity">
						<a itemprop="url" href="{{route('institutions.show', ['institution' => $institution])}}" class="block block-rounded mb-3">
						@if(!empty($institution->url))  <link itemprop="sameAs" content="{{$institution->url}}" /> @endif
						  <div class="block block-header-default bg-image mb-0 fw-light bg-studynexus-list">
							  <div class="bg-black-75 text-center p-3">
							  <div class="mb-3">
								  <div class="h5 text-white mb-1"> <span itemprop="name">{{$institution->name}}</span>
								   @if(!empty($institution->abbr))<span class="fw-light">({{$institution->abbr}})</span> @endif 
								   </div>

							     @if(!empty($institution->former_name)) <div class="fs-sm text-white"> Formerly: <span itemprop="alternateName">{{$institution->former_name}}</span> </div> @endif  
							</div>
							
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
					
					{{ $institutions->onEachSide(1)->links() }}

                </div>
            </div>
        </div>



    </div>
</div>

<!-- END Page Content -->

<script>
    window.onload = function() {
        // Check if there is a query string in the URL
        if (window.location.search) {
            // Get the position of the results section from the top of the document
            const resultsSection = document.getElementById('results');
            const offsetTop = resultsSection.getBoundingClientRect().top + window.scrollY;

            // Scroll to the calculated position
            window.scrollTo({
                top: offsetTop - 100,  // Adjust this value to fine-tune the scroll position
                behavior: 'smooth'
            });
        }
    };
</script>



@endsection