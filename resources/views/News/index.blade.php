@extends('layouts.backend')


@section('content')

 <!-- Hero -->
        <div class="bg-image" style="background-image: url('assets/media/photos/photo21@2x.jpg');">
          <div class="bg-black-50">
            <div class="content content-top content-full text-center">
              <h1 class="fw-bold text-white mt-5 mb-2">
               StudyNexus News
              </h1>
				<div class="d-flex justify-content-center mt-3 bg-success"> 
					@if(!empty($institution))
					 <i class="fa fa-tag text-white display-6 me-2"></i> 
					 <h3 class="fw-normal text-white-75 bg-danger my-auto">
							{{$institution->name}} News
					 </h3>
					@elseif(!empty($newsCategory))
					
					<i class="fa fa-tag text-white display-6 me-2"></i> 
					 <h3 class="fw-normal text-white-75 bg-danger my-auto">
							{{$newsCategory->name}} News
					 </h3>
					  @endif
					 
				</div>
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
			@foreach($news as $story)
			
			
              <!-- News Highlight -->
              <div class="block block-rounded">
                <div class="block-content p-0 overflow-hidden">
                   
                   
                      <div class="px-4 py-3">
                        <h4 class="mb-1">
                         
							  
						@php
						$routeName = 'news.show';
						$routeParameters = ['news' => $story];

						if (!empty($institution)) {
							$routeName = 'institutions.news.show';
							$routeParameters = ['institution' => $institution, 'news' => $story];
						} elseif (!empty($newsCategory)) {
							$routeName = 'news.newsCategory.show';
							$routeParameters = ['newsCategory' => $newsCategory, 'news' => $story];
						}
						@endphp

						<a class="text-info" href="{{ route($routeName, $routeParameters) }}">
							{{ $story->title }}
						</a>
						  
						  

                        </h4>
                        <div class="fs-sm mb-2">
                          Published: {{$story->created_at->format('F d, Y')}} · <em class="text-muted">{{$story->readTime}} min</em>
                        </div>
                        <p class="mb-1">
						
						{{$story->excerpt}}
						
                        </p>
						
						<div>
						@if($story->institution)
						<button class="btn btn-sm btn-outline-dark rounded-0 mb-1 fw-light" disabled >
						 <i class="si si-tag text-black"></i> {{$story->institution->name}}
						  </button>
						  @endif
						
						@foreach($story->newsCategories as $storyCategory)
						  <button class="btn btn-sm btn-outline-dark rounded-0 mb-1 fw-light" disabled >
						 <i class="si si-tag text-black"></i> {{$storyCategory->name}}
						  </button>
						@endforeach
						
						</div>
						
                      </div>
					  
					 
                
                </div>
              </div>
              <!-- END News Highlight -->
			  @endforeach



              <!-- Pagination -->
              {{ $news->links() }} 
              <!-- END Pagination -->
            </div>
            <div class="col-xl-4">
              <!-- Search -->
              <div class="block block-rounded">
                <div class="block-header block-header-default">
                  <h3 class="block-title">Search</h3>
                </div>
                <div class="block-content block-content-full">
                  <form action="be_pages_blog_classic.html" method="POST">
                    <div class="input-group">
                      <input type="text" class="form-control form-control-alt" placeholder="Type and hit enter..">
                      <button type="button" class="btn btn-primary">
                        <i class="fa fa-search"></i>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
              <!-- END Search -->


			<!-- News Categories -->
              <div class="block block-rounded">
                <div class="block-header block-header-default">
                  <h3 class="block-title">All News Categories</h3>
                </div>
                <div class="block-content block-content-full">
				@foreach($newsCategories as $newsCategory)
                  <a class="btn btn-sm btn-info rounded-0 mb-1" href="{{route('news.newsCategory', ['newsCategory' => $newsCategory ])}}" >
				  <i class="fa fa-tag text-white me-2"></i>{{$newsCategory->name}} <span class="fw-light">{{$newsCategory->news_count}}</span>
                  </a>
                 @endforeach
                </div>
              </div>
              <!-- END News Categories -->
             
              <!-- About -->
              <a class="block block-rounded block-link-shadow" href="be_pages_generic_profile.html">
                <div class="block-header block-header-default">
                  <h3 class="block-title">About</h3>
                </div>
                <div class="block-content block-content-full text-center">
                  <div class="mb-3">
                    <img class="img-avatar" src="assets/media/avatars/avatar3.jpg" alt="">
                  </div>
                  <div class="fs-lg fw-semibold">Lori Grant</div>
                  <div class="fs-sm text-muted">Web Developer</div>
                </div>
                <div class="block-content bg-body-light">
                  <div class="row text-center">
                    <div class="col-6">
                      <div class="mb-3">
                        <i class="fa fa-users fa-2x"></i>
                      </div>
                      <p class="fw-semibold text-muted">54k Followers</p>
                    </div>
                    <div class="col-6">
                      <div class="mb-3">
                        <i class="fa fa-pencil-alt fa-2x"></i>
                      </div>
                      <p class="fw-semibold text-muted">56 Stories</p>
                    </div>
                  </div>
                </div>
              </a>
              <!-- END About -->

              
            </div>
          </div>
        </div>
        <!-- END Page Content -->





@endsection