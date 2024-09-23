@extends('layouts.backend')


@section('content')
@php 
use Illuminate\Support\Str;
@endphp


<span itemscope itemtype="https://schema.org/CollectionPage">
<link itemprop="url" content="{{ url()->current() }}" >
 <!-- Hero -->
        <div class="bg-image bg-studynexus-hero" >
          <div class="bg-black-75">
            <div class="content content-top content-full text-center">
			
			<div class="display-6 text-white mt-5">Study<span class="text-info">Nexus</span>.<span class="text-success fs-2">ng</span> News</div>>
            
				<div class="d-flex justify-content-center mt-3"> 
					@if(!empty($institution))
					 <i class="fa fa-tag text-white display-6 me-2"></i> 
					 <h1 itemprop="alternativeHeadline" itemprop="headline" class="h3 text-white my-auto">
							{{$institution->name}} News
					 </h1>
					@elseif(!empty($newsCategory))
					
					<i class="fa fa-tag text-white display-6 me-2"></i> 
					 <h1 itemprop="alternativeHeadline" class="h3 text-white my-auto">
							{{$newsCategory->name}} News
					 </h1>
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
			
			
			  
			 `` @php
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
			  
			  
			  <!-- News Highlight -->
              <div class="block block-rounded" itemprop="itemListElement" itemscope itemtype="https://schema.org/NewsArticle">
                <div class="block-content p-0 overflow-hidden">
                   
				  <div class="row g-0">
				  
				   <div class="col-md-4 col-lg-5 overflow-hidden d-flex align-items-center">
                      <a href="{{ route($routeName, $routeParameters) }}">
                        <img class="img-fluid img-link" src="{{Storage::url('test.jpg')}}" alt="$story->title">
                      </a>
                    </div>
				   
				   
                   <div class="col-md-8 col-lg-7 d-flex align-items-center">
				   
                      <div class="px-4 py-3">
                        <h4 class="mb-1">
                        
						<a  class="text-primary-dark" href="{{ route($routeName, $routeParameters) }}">
							<span itemprop="headline"> {{ $story->title }} </span>
						</a>
						  
						    <link itemprop="url" content="{{ route($routeName, $routeParameters) }}" >
							<link itemprop="image" content="{{Storage::url($story->cover_image)}}" > 

                        </h4>
                        <div class="fs-sm mb-2">
                          <span itemprop="author" itemscope itemtype="https://schema.org/Person" class="text-muted">
								<span itemprop="name"> Study Nexus </span>
								<link itemprop="url" href="{{route('about')}}"> 
						  </span> 
						  
							on <span itemprop="datePublished" content="{{$story->created_at->format('Y-m-d\TH:i:sO');}}">{{$story->created_at->format('F d, Y')}}  </span> · <em class="text-muted">{{$story->readTime}} min</em>
							@if($story->updated_at->gt($story->created_at))  <meta itemprop="dateModified" content="{{$story->updated_at->format('Y-m-d\TH:i:sO');}}" > @endif
						</div>
                       
                           <p itemprop="description" class="mb-1">
							
							{{Str::limit($story->excerpt, 150, ' . . .')}}
							
								<a href="{{ route($routeName, $routeParameters) }}" class="">Read more</a>
							</p>
							
					    <div class="mt-0" >
						
				
						@if($story->institution)
						 <span itemprop="keywords" class="badge bg-black rounded-0"> <i class="fa fa-building-columns me-1"></i> {{$story->institution->abbr}}</span>
						@endif
						
						@foreach($story->newsCategories as $storyCategory)
						  <span itemprop="keywords" class="badge bg-black rounded-0"><i class="fa fa-tag me-1"></i>{{$storyCategory->name}}</span>
						  
						@endforeach
				       </div>
					
                      </div>
					  
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
                  <h3 class="block-title text-center">News Categories</h3>
                </div>
                <div class="block-content block-content-full">
				@foreach($newsCategories as $newsCategory)
				    <a class="btn btn-sm btn-outline-dark rounded-0 mb-1" href="{{route('news.newsCategory', ['newsCategory' => $newsCategory ])}}" >
						<i class="fa fa-tag  me-1"></i> <span itemprop="keywords">{{$newsCategory->name}}</span> 
				    </a>
                @endforeach
				 
					<span class="fw-bold">. . .</span>
                </div>
				
				<div class="block-header block-header-default bg-light">
                  <a class="btn btn-sm btn-primary rounded-0 mb-1 w-100" href="{{route('news.newsCategories')}}" >
						<i class="fa fa-eye text-white me-2"></i> View All News Categories
				    </a>
                </div>
				
              </div>
              <!-- END News Categories -->
           
            </div>
          </div>
        </div>
        <!-- END Page Content -->

</span>



@endsection