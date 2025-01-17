@extends('layouts.backend') 

@section('content')
@php 
use Illuminate\Support\Number;  
@endphp


<span itemscope itemtype="https://schema.org/CollegeOrUniversity">


		
		<!-- Hero  -->
        <div class="bg-image studynexus-bg-hero">
          <div class="bg-black-75">
            <div class="content content-boxed content-full pt-7">
              <div class="row">
			    @if(!empty($institution->logo))
				
			    <div class="col-md-2 d-flex align-items-center">
                  <div class="block block-rounded  block-transparent bg-black-50 text-center mb-0 mx-auto" style="box-shadow:0 0 2.25rem #d1d8ea;opacity:1">
                    <div class="block-content block-content-full px-1 py-1">
					
                      <img  src="{{ Storage::url($institution->logo) }}" alt="{{$institution->name}} logo" style="width: 100px; height: 100px; object-fit: cover;">
                      <link itemprop="logo" href="{{Storage::url($institution->logo)}}">
                    </div>
                  </div>
                </div>
				@endif
				
                <div class=" @if(!empty($institution->logo)) col-md-10 @endif d-flex align-items-center pt-3">
					 <div class="w-100 text-center @if(!empty($institution->logo)) text-md-start @endif">
						<h1  class="h2 text-white mb-1">  <span itemprop="name">{{$institution->name}} </span> @if(!empty($institution->abbr))<span class="fw-light">({{$institution->abbr}})</span>@endif </h1>
                          
						  <link itemprop="url" href="{{url()->current()}}">
						  <link itemprop="sameAs" href="{{$institution->url}}">

						<h2 itemprop="address" itemscope itemtype="https://schema.org/PostalAddress" class="h4 fw-light text-white mb-1">
							<meta itemprop="streetAddress" content="{{$institution->address}}">
							@if(!empty($institution->locality)) <span itemprop="addressLocality">{{$institution->locality}} </span>- @endif  <span itemprop="addressRegion">{{$institution->state->name}} @if(!empty($institution->state->is_state)) State @endif </span> 
						     <meta itemprop="postalCode" content="{{$institution->postal_code}}">
							<meta itemprop="addressCountry" content="NG">
						
						</h2>
						<div class="text-white mb-3">
						@if(!empty($institution->slogan)) ( <i itemprop="slogan">{{$institution->slogan}}</i> ) @endif
						</div>
						
						<h2 class="h3 text-white mb-0">{{$level->name}} Programmes</h2>
					 </div>
                </div>
              </div>
            </div>
          </div>
		  
		  
		   <div class="d-flex justify-content-end py-1">
			
			
			
			@if($institution->news->isNotEmpty())
		  
		  <!-- Notifications Dropdown -->
            <div class="dropdown d-inline-block me-1">
              <button type="button" class="btn btn-sm btn-primary" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="fa fa-fw fa-building-columns"></i> <i class="fa fa-fw fa-rss"></i>
                <span class="badge rounded-pill">Latest {{$institution->abbr}} News</span>
              </button>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                <div class="bg-primary-dark rounded-top fw-semibold text-white text-center p-3">
                  Latest News from {{$institution->abbr}}
                </div>
                <ul class="nav-items my-2">
				
				@foreach($institution->news->take(3) as $news)
                  <li>
                    <a class="d-flex text-dark py-2" href="{{route('institutions.news.show',['institution' => $institution, 'news' => $news])}}">
                      <div class="flex-shrink-0 mx-3">
                        <i class="fa fa-fw fa-coins text-success"></i>
                      </div>
                      <div class="flex-grow-1 fs-sm pe-2">
                        <div class="fw-semibold">{{$news->title}}</div>
                        <div class="text-muted">{{$news->created_at->diffForHumans()}}</div>
                      </div>
                    </a>
                  </li>
				  @endforeach
				  
                  
                </ul>
                <div class="p-2 border-top text-center">
                  <a class="btn btn-alt-primary w-100" href="{{route('institutions.news',['institution' => $institution])}}">
                    <i class="fa fa-fw fa-eye opacity-50 me-1"></i> View All
                  </a>
                </div>
              </div>
            </div>
            <!-- END Notifications Dropdown -->
		  
		  
		  @endif
		  
		  
		   <!-- Social Actions -->
				
				<div class="btn-group me-1" role="group">
					<button type="button" class="btn btn-sm btn-alt-primary dropdown-toggle" id="dropdown-blog-news" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-share-alt opacity-50 me-1"></i> Share Programmes
					</button>
					<div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="dropdown-blog-news">
						@foreach ($shareLinks as $platform => $link)
							<a class="dropdown-item" href="{{ $link }}" onclick="window.open(this.href, '_blank', 'width=700, height=525, left=250, top=200'); return false;">
								<i class="fab fa-fw fa-{{ $platform }} text-{{ $platform }}  me-1"></i> {{ ucfirst($platform) }}
							</a>
						@endforeach
					</div>
				</div>
			
			<!-- END Social Actions -->
		  
		  
		  
		  
		  
		  </div>
		  
		  
        </div>
        <!-- END Hero -->
<!-- Breadcrumbs -->
		  {{Breadcrumbs::render()}}
		 <!-- End Breadcrumbs -->

        <!-- Page Content -->
<div class="content">



	 <div class="col-md-12">

            <!-- nav -->
            <div class="block block-rounded">
			
                
                    <ul class="nav nav-tabs nav-tabs-block bg-gray-lighter">
					@foreach($program_levels as $program_level)
							
                  <li class="nav-item">
                    <a href="{{route('institutions.programs', ['institution' => $institution, 'level' =>$program_level])}}"><button
					@if(
					route('institutions.programs', ['institution' => $institution, 'level' =>$program_level]) == url()->current()
					
					) 
					class="btn-sm nav-link active" disabled
					@else
						class="btn-sm nav-link"
					@endif
					> {{$program_level->name}} Programmes
					</button>
					</a>
                  </li>
				  @endforeach
                  
                </ul>
            </div>
            <!-- END nav -->
        </div>




    <div class="block block-rounded">

        <div class="block-content">
           
            <h2  class="content-heading text-center">Accredited Courses Offered at {{$institution->name}}</h2>
            <div itemprop="hasOfferCatalog" itemscope itemtype="https://schema.org/OfferCatalog" class="row items-push">
                <div class="col-lg-4">
                    <p class=" sticky-top" style="top: 100px;">
                        Explore the official list of accredited <span itemprop="name" class="text-black-75">{{$level->name}} programmes </span> grouped by their various disciplines offered at <span class="text-black-75">{{$institution->name}}</span>.
                    </p>
                </div>
                
                <div  class="col-lg-8">
                    <div id="programs" role="tablist" aria-multiselectable="true">


					@if($level->id == 3)
						
					
						<div class="block-content">

                            @foreach($programs as $program)
								<div itemprop="itemListElement" itemscope itemtype="https://schema.org/OfferCatalog" class="block block-rounded mb-1">
									<a  itemscope itemtype="https://schema.org/EducationalOccupationalProgram" class="fw-normal" href="{{route('institutions.program.show', ['institution' => $institution, 'level' => $level, 'program' => $program])}}">
										<div class="block-header block-header-default fs-6">
										 <span itemprop="name"> {{$program->name}} </span>  @if(!empty($program->pivot->is_distinguished))<i class="fa fa-star text-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Center of Excellence"></i> @endif
										</div>
									  </a>
								</div>
							@endforeach
						</div>
					
					
						
					@else
						

                        @foreach( $programs as $collegeName => $programs)
                        <div itemprop="itemListElement" itemscope itemtype="https://schema.org/OfferCatalog" class="block block-rounded mb-1">
                            <a class="fs-lg link-primary fw-semibold" data-bs-toggle="collapse" data-bs-parent="#programs" href="#programs_q{{$loop->iteration}}" aria-expanded="false" aria-controls="programs_q{{$loop->iteration}}">
								<div class="block-header block-header-default fs-5" role="tab" id="programs_h{{$loop->iteration}}">
								     <div itemprop="name">{{$collegeName}}</div>    <div><span class="text-black fs-sm me-3 ">{{$programs->count()}} </span><span class="toggle-icon fw-light fs-2"> </span> </div>
								</div>
                            </a>
                            <div id="programs_q{{$loop->iteration}}" class="collapse" role="tabpanel" aria-labelledby="programs_h{{$loop->iteration}}" data-bs-parent="#programs">
                                <div class="block-content">

                                    @foreach($programs as $program)
                                    <div itemprop="itemListElement" itemscope itemtype="https://schema.org/OfferCatalog" class="block block-rounded mb-1">
                                        <a  itemscope itemtype="https://schema.org/EducationalOccupationalProgram" class="fw-normal" href="{{route('institutions.program.show', ['institution' => $institution, 'level' => $level, 'program' => $program])}}">
											<div class="block-header block-header-default fs-6">
											 <span itemprop="name"> {{$program->name}} </span>  @if(!empty($program->pivot->is_distinguished))<i class="fa fa-star text-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Center of Excellence"></i> @endif
											</div>
                                          </a>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        @endforeach
						
						
					@endif
					
                    </div>
                </div>
            </div>
          
        </div>
    </div>
</div>
<!-- END Page Content -->

</span>


@endsection