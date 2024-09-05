@extends('layouts.backend')


@section('content')


<!-- Hero -->
        <div class="bg-image bg-studynexus-hero" >
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
        </div>
        <!-- END Hero -->

		<!-- Breadcrumbs -->
		  {{Breadcrumbs::render()}}
		 <!-- End Breadcrumbs -->


        <!-- Page Content -->
<div class="content content-boxed">

    <div class="row">
        <div class="col-md-4 order-md-1">

            <!-- Ad block -->
            <div class="block block-rounded d-none d-lg-block sticky-top" style="top: 100px;">
                <div class="block-header block-header-default bg-studynexus-cubes" >
                    <h3 class="block-title">Ads</h3>
                </div>
                <div class="block-content">

                    Ads

                </div>
            </div>
            <!-- END Ad block -->
        </div>

        <div class="col-md-8 order-md-0">

            @foreach($regions as $region)

            <!-- Region Block -->
            <div class="block block-rounded">
                <div class="block-header block-header-default bg-studynexus-cubes" >

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
                                <span class="badge rounded-pill bg-info"> {{ $catchment->institutions->count()}}</span> Schools
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