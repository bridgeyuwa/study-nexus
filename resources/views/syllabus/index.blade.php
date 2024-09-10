@extends('layouts.backend')


@section('content')
<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-7">
              <div class="pt-4 pb-3">
                <h1 class="text-white mb-1">

                 Syllabi

              </h1>
              
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

            <!-- Ads -->
            <div class="block block-rounded">
                <div class="block-header block-header-default bg-studynexus-cubes" >
                    <h3 class="block-title">Ads</h3>
                </div>
                <div class="block-content">
                    Ads
                </div>
            </div>
            <!-- END Ads -->
        </div>

        <div class="col-md-8 order-md-0">

            <!-- Programme Levels -->
            <div itemscope itemtype="https://schema.org/ItemList" class="block block-rounded">
                <div class="block-header block-header-default text-center bg-studynexus-cubes" >
                    <h3 itemprop="name"  class="block-title">list of Syllabi (Syllabuses)</h3>
                </div>
                <div class="block-content">

                    @foreach($examBodies as $examBody)
					<div itemprop="itemListElement" itemscope itemtype="https://schema.org/ItemList" >
                    <a  class="block block-rounded block-bordered block-link-shadow" href="{{route('syllabus.subjects',['examBody' => $examBody])}}">
                  <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                    <div class="me-3">
                      <div class=" col fs-lg  mb-0 text-primary">
						@if(!empty($examBody->logo))<img  src="{{$examBody->logo}}" alt="{{$examBody->name}} logo"  style="width: 40px; height: 40px; object-fit: cover;"> @endif
						<span itemprop="name"> {{$examBody->abbr}} Syllabus</span>
                      </div>                      
                      
                    </div>
                    <div>
                      <i class="fa fa-circle-right  text-xwork text-primary"></i> 
                    </div>
                  </div>
                </a> 
				@endforeach
                 </div>
                </div>
            </div>
            <!-- END Programme Levels -->

        </div>
    </div>
</div>
<!-- END Page Content -->



@endsection