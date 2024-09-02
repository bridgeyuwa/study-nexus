@extends('layouts.backend')


@section('content')
<span itemscope itemtype="https://schema.org/NewsArticle">
<!-- Hero -->
        <div class="bg-image" style="background-image: url('assets/media/photos/photo22@2x.jpg');">
          <div class="bg-black-75">
            <div class="content content-top content-full text-center">
				<h1 class="fw-bold text-white mt-5 mb-2">
					<span itemprop="headline"> {{$news->title}} </span>
				</h1>
				 
				<link itemprop="url" content="{{ url()->current() }}" >
				 @if( url()->current() !== route('news.show',['news' => $news])  )	<link itemprop="sameAs" content="{{route('news.show',['news'=> $news])}}">   @endif
				
				<span itemprop="author" itemscope itemtype="https://schema.org/Person" >
					   <meta itemprop="name" content="Study Nexus">
					  <link itemprop="url" href="{{route('about')}}"> 
				</span>   
				   
				   
					<span class="badge rounded-pill bg-dark fs-base px-3 py-2 m-1">
					  <i class="fa fa-clock me-1"></i> {{$news->readTime}} min read
					</span>
                
					
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
			  
				<div class="block-header block-header-default fs-sm py-3  bg-studynexus-cubes">
                    <span>  
						Published: 
						<span itemprop="datePublished" content="{{$news->created_at->format('Y-m-d\TH:i:sO')}}">
							{{$news->created_at->format('F d, Y')}}  
						</span> 
					</span>
					
                    @if($news->updated_at->gt($news->created_at)) 
					<span>  
						Updated: 	
						<span itemprop="dateModified" content="{{$news->updated_at->format('Y-m-d\TH:i:sO')}}" > 
							{{$news->updated_at->format('F d, Y')}}
						</span> 
					</span> 
					@endif
                	  
				</div>
			  
			  
                <div class="block-content p-0 overflow-hidden">
                   
                    <div class="  d-flex align-items-center">
                      <div  itemprop="description" class="px-4 py-3">
					  
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
                  <button type="button" class="btn btn-alt-secondary dropdown-toggle" id="dropdown-blog-news" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-share-alt opacity-50 me-1"></i> Share
                  </button>
                  <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="dropdown-blog-news">
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
                <div class="block-header block-header-default bg-studynexus-cubes">
                  <h3 class="block-title text-center">News Tags</h3>
                </div>
                <div class="block-content block-content-full">
				@if(!empty($news->institution))
					<a class="btn btn-sm btn-info rounded-0 mb-1" href="{{route('institutions.news', ['institution' => $news->institution ])}}" >
							<span itemprop="keywords"> {{$news->institution->name}} </span>
					</a>
				@endif
				
				
				@foreach($news->newsCategories as $newsCategory)
                  <a class="btn btn-sm btn-info rounded-0 mb-1" href="{{route('news.newsCategory', ['newsCategory' => $newsCategory ])}}" >
					 <i class="fa fa-tag text-white me-2"></i>	<span itemprop="keywords">  {{$newsCategory->name}} </span>
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