@extends('layouts.backend')


@section('content')

<!-- Hero -->
        <div class="bg-image" style="background-image: url('assets/media/photos/photo22@2x.jpg');">
          <div class="bg-black-75">
            <div class="content content-top content-full text-center">
              <h1 class="fw-bold text-white mt-5 mb-3">
			  {{$news->title}}
              </h1>
               <p>
                
                <span class="badge rounded-pill bg-primary fs-base px-3 py-2 m-1">
                  <i class="fa fa-clock me-1"></i> {{$news->readTime}} min read
                </span>
              </p>
            </div>
          </div>
        </div>
        <!-- END Hero -->
		<!-- Breadcrumbs -->
		  {{Breadcrumbs::render()}}
		 <!-- End Breadcrumbs -->
		
		 <!-- Page Content -->
        <div class="content">
          <div class="row">
            <div class="col-xl-8">
			
			
              <!-- News Content -->
              <div class="block block-rounded">
                <div class="block-content p-0 overflow-hidden">
                   
                    <div class="  d-flex align-items-center">
                      <div class="px-4 py-3">
                        
                        
                        <p class="lead mb-2">
						{{$news->excerpt}}
                        </p>
						
						{{$news->content}}
						
                      </div>
                    </div>
                
                </div>
					
              </div>
              <!-- END News Content -->

              <!-- Social Actions -->
              <div class="mt-0 d-flex justify-content-between push">
                <div class="btn-group" role="group">
                  <button type="button" class="btn btn-alt-secondary" data-bs-toggle="tooltip" title="Like Story">
                    <i class="fa fa-thumbs-up text-primary"></i>
                  </button>
                  <button type="button" class="btn btn-alt-secondary" data-bs-toggle="tooltip" title="Recommend">
                    <i class="fa fa-heart text-danger"></i>
                  </button>
                </div>
                <div class="btn-group" role="group">
                  <button type="button" class="btn btn-alt-secondary dropdown-toggle" id="dropdown-blog-story" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-share-alt opacity-50 me-1"></i> Share
                  </button>
                  <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="dropdown-blog-story">
                    <a class="dropdown-item" href="javascript:void(0)">
                      <i class="fab fa-fw fa-facebook me-1"></i> Facebook
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)">
                      <i class="fab fa-fw fa-twitter me-1"></i> Twitter
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)">
                      <i class="fab fa-fw fa-linkedin me-1"></i> LinkedIn
                    </a>
                  </div>
                </div>
              </div>
              <!-- END Social Actions -->

            
            </div>
            <div class="col-xl-4">
              

              <!-- News Categories -->
              <div class="block block-rounded">
                <div class="block-header block-header-default">
                  <h3 class="block-title">News Tags</h3>
                </div>
                <div class="block-content block-content-full">
				@if(!empty($institution))
					<a class="btn btn-sm btn-outline-info rounded-0 mb-1 fw-light" href="{{route('institutions.news', ['institution' => $institution ])}}" >
				  {{$institution->name}}
                  </a>
				@endif
				
				
				@foreach($news->newsCategories as $newsCategory)
                  <a class="btn btn-sm btn-outline-info rounded-0 mb-1 fw-light" href="{{route('news.newsCategory', ['newsCategory' => $newsCategory ])}}" >
				  {{$newsCategory->name}}
                  </a>
                 @endforeach
                </div>
              </div>
              <!-- END News Categories -->
            </div>
          </div>
        </div>
        <!-- END Page Content -->








@endsection