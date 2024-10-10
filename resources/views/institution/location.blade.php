@extends('layouts.backend')


@section('content')

<!-- Hero -->
        <div class="bg-image studynexus-bg-hero" >
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-6">
              <div class="pt-4 pb-3">
				@php
					$categoryName = $categoryClass->name_plural ?? 'Higher Institutions';
				@endphp

				<h1 class="h2 text-white mb-1">
					{{ $categoryName }} in Nigeria
				</h1>			
           
            <h2 class="h3 text-white fw-light mt-3"> by Regions/States</h2>
              </div>
            </div>
          </div>
		  
		  <div class="d-flex justify-content-end py-1">		
		     <!-- Social Actions -->
				
				<div class="btn-group me-1" role="group">
					<button type="button" class="btn btn-sm btn-alt-primary dropdown-toggle" id="dropdown-blog-news" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-share-alt opacity-50 me-1"></i> Share {{ $categoryClass->name_plural ?? 'Institutions' }} Locations
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


 <div class="col-md-12">

            <!-- nav -->
            <div class="block block-rounded">
			
					 <ul class="nav nav-tabs nav-tabs-block bg-gray-lighter">
					
					<li class="nav-item">
                    <a href="{{route('institutions.location')}}"><button
					@if(
					route('institutions.location') == url()->current()
					) 
					class="btn-sm nav-link active" disabled
					@else
						class="btn-sm nav-link"
					@endif
					> All Institution Locations
					</button>
					</a>
                  </li>
					
					
					
					@php
						$isCurrent = function($route) {
							return $route == url()->current();
						};
					@endphp

					@foreach($categoryClasses as $institution_category)
						<li class="nav-item">
							<a href="{{ route('institutions.categories.location', ['categoryClass' => $institution_category]) }}">
								<button class="btn-sm nav-link {{ $isCurrent(route('institutions.categories.location', $institution_category)) ? 'active' : '' }}" {{ $isCurrent(route('institutions.categories.location', $institution_category)) ? 'disabled' : '' }}>
									{{ $institution_category->name }} Locations
								</button>
							</a>
						</li>
					@endforeach

                  
                </ul>
            </div>
            <!-- END nav -->
        </div>



    <div class="row">
        <div class="col-md-4 order-md-1 order-2"> 

            <!-- Ads  -->
            <div class="block block-rounded">
                <div class="block-header block-header-default studynexus-bg-cubes" >
                    <h3 class="block-title">Ads</h3>
                </div>
                <div class="block-content">

                    Ads

                </div>
            </div>
            <!-- END Ads -->
        </div>

        <div class="col-md-8 order-md-0">
		<!-- Region Block -->
           @foreach($regions as $region)
				@php
					$stateRoute = function($state) use ($categoryClass) {
						return $categoryClass 
							? route('institutions.categories.location.show', ['categoryClass' => $categoryClass, 'state' => $state])
							: route('institutions.location.show', ['state' => $state]);
					};
				@endphp

				<div class="block block-rounded">
					<div class="block-header block-header-default studynexus-bg-cubes" >
						<h3 class="block-title d-flex justify-content-between align-items-center">
							{{ $region->name }} <span >{{ $region->institutions->count() }} Schools</span>
						</h3>
					</div>
					<div class="block-content">
						<ul class="list-group list-group-flush">
							@foreach($region->states as $state)
								<li class="list-group-item d-flex justify-content-between align-items-center p-1 mt-0">
									<a href="{{ $stateRoute($state) }}" class="fw-normal fs-normal">{{ $state->name }} @if($state->is_state) State @endif</a>
									<a href="{{ $stateRoute($state) }}" class="btn btn-light w-25 text-secondary">
										<span class="badge rounded-pill bg-info">{{ $state->institutions->count() }}</span> Schools
									</a>
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			@endforeach
		<!-- End Region Block -->


        </div>
    </div>
</div>
<!-- END Page Content -->








@endsection