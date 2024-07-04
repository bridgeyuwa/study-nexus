@extends('layouts.backend') 

@section('content')

<!-- Hero -->
<div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
    <div class="bg-black-75">
        <div class="content content-full content-top text-center pt-7">
            <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">Catchment Area Policy</h1>

            </div>
        </div>
    </div>
</div>
<!-- END Hero -->


<!-- Page Content -->
<div class="content content-boxed">

    <div class="row">
        <div class="col-md-4 order-md-1">

            <!-- Ad block -->
            <div class="block block-rounded d-none d-lg-block sticky-top" style="top: 100px;">
                <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                    <h3 class="block-title">Ads</h3>
                </div>
                <div class="block-content">

                    Ads

                </div>
            </div>
            <!-- END Ad block -->
        </div>

        <div class="col-md-8 order-md-0">
           <div class="block block-rounded">
                          
                    <h2 class="content-heading text-center">Nigerian Universities Catchment Policy</h2>

                           <p class="p-3">    policy   </p>
 
                  </div>

            

        </div>
    </div>
</div>
<!-- END Page Content -->

@endsection