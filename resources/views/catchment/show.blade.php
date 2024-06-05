@extends('layouts.backend')


@section('content')
@php use Illuminate\Support\Str; @endphp

<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-7">
              <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">Federal Universities in Nigeria with {{str::title($catchment->name)}} as Catchment </h1>

              
              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->



      <!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <h2 class="content-heading text-center">Schools with {{str::title($catchment->name)}} @if($catchment->id != 15) State @endif as Catchment Area</h2>
            <div class="row items-push">
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 100px;">
                        <p class="text-muted ">
                            A comprehensive List of accredited <span class="text-black">Universities</span> in Nigeria which have <span class="text-black">{{str::title($catchment->name)}} @if($catchment->id != 15) State @endif</span> as a Catchment Area.
                        </p>


                        <p class="fs-sm">(In this context, <span class="text-decoration-underline">Catchment Area</span> refers to a designated geographic region or zone which a candidate originates from that receives preferential treatment or consideration in the admission
                            process for a tertiary institution based on cutoff or quotas set by such institution.) </p>
                        <p class="fs-sm">See <a href="{{route('institutions.catchments.policy')}}" class="">Catchment Area Policy</a></p>

                    </div>
                </div>

                <div class="col-lg-8">

                    @foreach($institutions as $institution)

                    <a href="{{route('institutions.show', ['institution' => $institution->id])}}" class="block block-rounded mb-3">
                  <div class="block block-header-default bg-image mb-0"
                      style="background-image: url('/media/photos/photo11.jpg');">
                      <div class="bg-black-75 text-center p-3">
                          <div class="fs-lg fw-normal text-white mb-1">{{Str::upper($institution->name)}}
                           @if(!empty($institution->abbr))<span class="text-white-75 fw-light">({{str::upper($institution->abbr)}})</span> @endif </div>
                          <div class="h6 fw-normal fs-sm text-white-75 mb-0">{{str::title($institution->schooltype->name)}} {{str::title($institution->category->name)}}. <i class="fa fa-map-marker-alt ms-2 me-1 text-primary"></i>Makurdi,
                              {{str::title($institution->state->name)}}, Nigeria</div>
                          
                      </div>
                  </div>
                </a> @endforeach

                </div>
            </div>
        </div>

    </div>
</div>

<!-- END Page Content -->

@endsection