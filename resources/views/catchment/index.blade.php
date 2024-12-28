@extends('layouts.backend')


@section('content')


<!-- Hero -->
        <div class="bg-image studynexus-bg-hero" >
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-6">
              <div class="pt-4 pb-3">
                <h1 class="h2 text-white mb-1">Federal Universities Catchments</h1>

                  <h2 class="h4 fw-light text-white ">
                      Locate Federal Universities by Catchment Area
                   </h2>

           
            <h2 class="h3 text-white">Catchment Areas</h2>
              </div>
            </div>
          </div>
		  
		  <div class="d-flex justify-content-end py-1">		
		     <!-- Social Actions -->
				
				<div class="btn-group me-1" role="group">
					<button type="button" class="btn btn-sm btn-alt-primary dropdown-toggle" id="dropdown-blog-news" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-share-alt opacity-50 me-1"></i> Share Catchment Areas
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

    <div class="row">
        <div class="col-md-4 order-md-1 order-2">

            <!-- Ads block -->
            <div class="block block-rounded ">
                <div class="block-header block-header-default studynexus-bg-cubes" >
                    <h3 class="block-title">Ads by Study<span class="text-primary-darker">Nexus</span></h3>
                </div>
                <div class="block-content fs-sm">

                    Advertise with Study<span class="text-primary-darker">Nexus</span>, <a href="{{route('contact')}}"> Contact us here </a>

                </div>
            </div>
            <!-- END Ads block -->
        </div>

        <div class="col-md-8 order-md-0">

            @foreach($regions as $region)

            <!-- Region Block -->
            <div class="block block-rounded">
                <div class="block-header block-header-default studynexus-bg-cubes" >

                    <h3 class="block-title d-flex justify-content-between align-items-center">{{$region->name}} Catchment Areas

                    </h3>

                </div>
                <div class="block-content">

                    <ul class="list-group list-group-flush pb-2">

                        @foreach( $region->catchments as $catchment )
						@php $catchmentUrl = route('institutions.catchments.show', ['catchment' => $catchment]); @endphp
						
                        <li class="list-group-item d-flex justify-content-between align-items-center p-1 mt-0">
                            <a href="{{$catchmentUrl}}" class="fw-normal fs-normal">{{$catchment->name}}</a>

                            <a href="{{$catchmentUrl}}" class="btn btn-light w-25 text-secondary"> 
                                <span class="badge rounded-pill bg-info"> {{ $catchment->institutions->count()}}</span> <span style="font-size: 13px">Schools<span>
                               </a>
                        </li>
                        @endforeach
                    </ul>

                </div>
            </div>
            <!-- END Region Block -->
            @endforeach

        </div>
    </div>
</div>
<!-- END Page Content -->

@endsection