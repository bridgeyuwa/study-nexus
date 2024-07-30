@extends('layouts.backend')


@section('content')

@php use Illuminate\Support\Str; @endphp

<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-6">
              <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">Federal Universities Catchments</h1>

                  <h2 class="h4 fs-md  fw-light text-white-75 ">
                     ( Locate Federal Universities by Catchment Area )
                    </h2>

           
            <h2 class="h3 fw-light text-white">Catchment Areas</h2>
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
                <div class="block-header block-header-default" style="background-image: url(/media/patterns/cubes.png)">
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
                <div class="block-header block-header-default" style="background-image: url(/media/patterns/cubes.png)">

                    <h3 class="block-title d-flex justify-content-between align-items-center">{{$region->name}} Catchment Areas

                    </h3>

                </div>
                <div class="block-content">

                    <ul class="list-group list-group-flush pb-2">

                        @foreach( $region->catchments as $catchment )
                        <li class="list-group-item d-flex justify-content-between align-items-center p-1 mt-0">
                            <a href="{{route('institutions.catchments.show', ['catchment' => $catchment->slug])}}" class="fw-normal fs-normal">{{$catchment->name}}</a>

                            <a href="{{route('institutions.catchments.show', ['catchment' => $catchment->slug])}}" class="btn btn-light w-25 text-secondary"> 
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