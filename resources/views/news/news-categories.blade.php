@extends('layouts.backend')

@section('content')

<!-- Hero -->
        <div class="bg-image studynexus-bg-hero">
          <div class="bg-black-75">
            <div class="content content-top content-full text-center">
			
			<div class="display-6 text-white">Study<span class="text-info">Nexus</span>.<span class="text-success fs-2">ng</span> News</div>>
            
			
              <h1 class="h2 text-white mt-3 mb-2">
              All News Categories
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
                
                <div class="block-content pb-3">
				
				@foreach( $newsCategories as $newsCategory )
				<a class="btn btn-sm btn-outline-dark rounded-0 mb-1" href="{{route('news.newsCategory', ['newsCategory' => $newsCategory] )}}">
					<i class="fa fa-tag"></i> {{$newsCategory->name}}
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