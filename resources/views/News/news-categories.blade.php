@extends('layouts.backend')

@section('js_after')
<script src="{{ asset('js/plugins/masonry.pkgd.min.js') }}"></script>
@endsection

@section('content')

<!-- Hero -->
        <div class="bg-image" style="background-image: url('assets/media/photos/photo21@2x.jpg');">
          <div class="bg-black-50">
            <div class="content content-top content-full text-center">
              <h1 class="fw-bold text-white mt-5 mb-2">
              All StudyNexus News Categories
              </h1>
				
            </div>
          </div>
        </div>
        <!-- END Hero -->

		<!-- Breadcrumbs -->
		  {{Breadcrumbs::render()}}
		 <!-- End Breadcrumbs -->

		<!-- Page Content -->
        <div class="content">
          

         <!-- News Categories -->
        <div class="row" data-masonry='{"percentPosition": true }'>
		  @foreach( $newsCategories as $alphabet => $newsCategories )
            <div class="col-md-6">
              <div class="block block-rounded">
                <div class="block-header block-header-default">
                  <h3 class="block-title">{{$alphabet}} <small>Subtitle</small></h3>
                </div>
                <div class="block-content">
				
				@foreach( $newsCategories as $newsCategory )
				<a class="btn btn-sm btn-outline-dark rounded-0 mb-1" href="{{route('news.newsCategory', ['newsCategory' => $newsCategory] )}}">
					<i class="fa fa-tag text-dark"></i> {{$newsCategory->name}}
				</a>
				@endforeach
                </div>
              </div>
            </div>
          @endforeach  
          </div>
          <!-- News Categories -->
          
          

        </div>
        <!-- END Page Content -->

@endsection