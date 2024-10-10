@extends('layouts.backend')


@section('content')
<span itemscope itemtype="https://schema.org/NewsArticle">
<!-- Hero -->
        <div class="bg-image studynexus-bg-hero" >
          <div class="bg-black-75">
            <div class="content content-top content-full text-center">
			
			<div class="display-6 text-white">Study<span class="text-info">Nexus</span>.<span class="text-success fs-2">ng</span> News</div>>
            
			
				<h1 class="h2 text-white mt-3 mb-2">
					<span itemprop="name"> {{$news->title}}</span>
				</h1>
			@if(!empty($news->cover_image))	<link itemprop="image" href="{{Storage::url($news->cover_image)}}">  @endif
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
						  
							<div class="block-header block-header-default fs-sm py-3  studynexus-bg-cubes">
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
						  
						  
							
							<br>
							
							<div class="block-content p-0 overflow-hidden">
								<div class="d-flex align-items-center">
									<div itemprop="description" class="px-4 py-3" style="max-width: 100%;">
										<p class="lead mb-2">
											{{ $news->excerpt }}
										</p>

										{!! \Illuminate\Support\Str::markdown($news->content) !!}
									</div>
								</div>
							</div>

							
							
								
						</div>
						  <!-- END News Content -->

						  
						  
						  <!-- Social Actions -->
						<div class="mt-0 d-flex justify-content-end push">
							
							<div class="btn-group" role="group">
								<button type="button" class="btn btn-alt-primary dropdown-toggle" id="dropdown-blog-news" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fa fa-share-alt opacity-50 me-1"></i> Share News
								</button>
								<div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="dropdown-blog-news">
									@foreach ($shareLinks as $platform => $link)
										<a class="dropdown-item" href="{{ $link }}" onclick="window.open(this.href, '_blank', 'width=700, height=525, left=250, top=200'); return false;">
											<i class="fab fa-fw fa-{{ $platform }} text-{{ $platform }}  me-1"></i> {{ ucfirst($platform) }}
										</a>
									@endforeach
								</div>
							</div>
						 </div>
						<!-- END Social Actions -->
						
						
				
			</div>
		
		
		
		
			<div class="col-xl-4">
				  

				  <!-- News Categories -->
				<div class="block block-rounded">
					<div class="block-header block-header-default studynexus-bg-cubes">
					  <h3 class="block-title text-center">News Tags</h3>
					</div>
					<div class="block-content block-content-full">
					@if(!empty($news->institution))
						<a class="btn btn-sm btn-info rounded-0 mb-1" href="{{route('institutions.news', ['institution' => $news->institution ])}}" >
							<i class="fa fa-building-columns me-1"></i>	<span itemprop="keywords"> {{$news->institution->name}} </span>
						</a>
					@endif
					
					
					@foreach($news->newsCategories as $newsCategory)
					  <a class="btn btn-sm btn-info rounded-0 mb-1" href="{{route('news.newsCategory', ['newsCategory' => $newsCategory ])}}" >
						 <i class="fa fa-tag me-1"></i>	<span itemprop="keywords">  {{$newsCategory->name}} </span>
					  </a>
					 @endforeach
					</div>
				</div>
				  <!-- END News Categories -->
				  
				  
				  
				<!-- Similar News -->
				<div class="block block-rounded">
					<div class="block-header block-header-default studynexus-bg-cubes">
					  <h3 class="block-title text-center">Similar News</h3>
					</div>
					<div class="block-content block-content-full bg-info-light">
					
						
					   @foreach($similarNews as $similarStory)
					   
					    @php
							$routeName = 'news.show';
							$routeParameters = ['news' => $similarStory];
						@endphp
					   
					   <!-- Story -->
						<a class="block block-rounded block-link-pop" href="{{ route($routeName, $routeParameters) }}">
							<div class="block-content">
							  <h6 class="mb-1 text-primary-dark">{{$similarStory->title}}</h6>
							  <p class="fs-sm mb-0">
								 on {{$similarStory->created_at->format('F d, Y')}}
							  </p>
							  
							  <div class="fs-sm mb-1" style="font-size: 0.75rem !important;">
								@if(!empty($similarStory->institution))
									<span><i class="fa fa-building-columns"></i> {{$similarStory->institution->abbr}}</span>,
								@endif
						
								@foreach($similarStory->newsCategories as $similarStoryNewsCategory)
								  <span ><i class="fa fa-tag"></i>  {{$similarStoryNewsCategory->name}} </span> @if(!$loop->last), @endif
								@endforeach
							</div>
							  
							</div>
							
						</a>
						<!-- END Story -->
					    @endforeach
						
					</div>
				  
				</div>  
				  
				  
				  
				  
				  
				  
				  
				  
			</div>
		</div>
	</div>
        <!-- END Page Content -->

</span>

@endsection