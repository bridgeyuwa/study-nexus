@extends('layouts.backend')


@section('content')
<span itemscope itemtype="https://schema.org/CollectionPage">
<link itemprop="url" content="{{ url()->current() }}" >
 <!-- Hero -->
        <div class="bg-image" style="background-image: url('assets/media/photos/photo21@2x.jpg');">
          <div class="bg-black-50">
            <div class="content content-top content-full text-center">
              <h1 class="fw-bold text-white mt-5 mb-2">
               StudyNexus News
              </h1>
				<div class="d-flex justify-content-center mt-3"> 
					@if(!empty($institution))
					 <i class="fa fa-tag text-white display-6 me-2"></i> 
					 <h3 itemprop="alternativeHeadline" itemprop="headline" class="fw-normal text-white-75 my-auto">
							{{$institution->name}} News
					 </h3>
					@elseif(!empty($newsCategory))
					
					<i class="fa fa-tag text-white display-6 me-2"></i> 
					 <h3 itemprop="alternativeHeadline" class="fw-normal text-white-75 bg-danger my-auto">
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
        <div class="content"  itemprop="mainEntity" itemscope itemtype="https://schema.org/ItemList">
          <div class="row">
            <div class="col-xl-8">
			@foreach($news as $story)
			
			
              <!-- News Highlight -->
              <div class="block block-rounded" itemprop="itemListElement" itemscope itemtype="https://schema.org/NewsArticle">
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

						<a  class="text-info" href="{{ route($routeName, $routeParameters) }}">
							<span itemprop="headline"> {{ $story->title }} </span>
						</a>
						  
						  <link itemprop="url" content="{{ route($routeName, $routeParameters) }}" >

                        </h4>
                        <div class="fs-sm mb-2">
                          <span itemprop="author" itemscope itemtype="https://schema.org/Person" class="text-muted">
								<span itemprop="name"> StudyNexus </span>
								<link itemprop="url" href="{{route('about')}}"> 
						  </span> 
						  
							on <span itemprop="datePublished" content="{{$story->created_at->format('Y-m-d\TH:i:sO');}}">{{$story->created_at->format('F d, Y')}}  </span> · <em class="text-muted">{{$story->readTime}} min</em>
							@if($story->updated_at->gt($story->created_at))  <meta itemprop="dateModified" content="{{$story->updated_at->format('Y-m-d\TH:i:sO');}}" > @endif
						</div>
                        <p itemprop="description" class="mb-1">
						
						{{$story->excerpt}}
						
                        </p>
						
						<div>
						@if($story->institution)
						<button class="btn btn-sm btn-outline-dark rounded-0 mb-1 fw-light" disabled >
						 <span itemprop="keywords"> {{$story->institution->name}}</span>
						  </button>
						  @endif
						
						@foreach($story->newsCategories as $storyCategory)
						  <button class="btn btn-sm btn-outline-dark rounded-0 mb-1 fw-light" disabled >
						 <i class="si si-tag text-black"></i> <span itemprop="keywords">{{$storyCategory->name}}</span>
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
                <div class="block-header block-header-default bg-studynexus-cubes">
                  <h3 class="block-title text-center">Search</h3>
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
                <div class="block-header block-header-default bg-studynexus-cubes">
                  <h3 class="block-title text-center">All News Categories</h3>
                </div>
                <div class="block-content block-content-full">
				@foreach($newsCategories as $newsCategory)
                  <a class="btn btn-sm btn-info rounded-0 mb-1" href="{{route('news.newsCategory', ['newsCategory' => $newsCategory ])}}" >
				  <i class="fa fa-tag text-white me-2"></i> <span itemprop="keywords">{{$newsCategory->name}}</span> <span class="fw-light">{{$newsCategory->news_count}}</span>
                  </a>
                 @endforeach
                </div>
              </div>
              <!-- END News Categories -->
           
            </div>
          </div>
        </div>
        <!-- END Page Content -->

</span>



@endsection