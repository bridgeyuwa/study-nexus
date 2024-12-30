@extends('layouts.backend') 

@section('content') 

@php 
use Illuminate\Support\Number; 
@endphp

<span itemscope itemtype="https://schema.org/CollegeOrUniversity">
	
	
	<!-- Hero  -->
        <div class="bg-image studynexus-bg-hero" >
          <div class="bg-black-75">
            <div class="content content-boxed content-full py-5 pt-7">
              <div class="row">
			    @if(!empty($institution->logo))
				
			    <div class="col-md-2 d-flex align-items-center">
                  <div class="block block-rounded  block-transparent bg-black-50 text-center mb-0 mx-auto"  style="box-shadow:0 0 2.25rem #d1d8ea;opacity:1">
                    <div class="block-content block-content-full px-1 py-1">
					
                      <img src="{{ Storage::url($institution->logo) }}" alt="{{$institution->name}} logo" style="width: 100px; height: 100px; object-fit: cover;">
                      <link itemprop="logo" href="{{Storage::url($institution->logo)}}">
                    </div>
                  </div>
                </div>
				@endif
				
                <div class=" @if(!empty($institution->logo)) col-md-10 @endif d-flex align-items-center pt-3">
					 <div class="w-100 text-center @if(!empty($institution->logo)) text-md-start @endif">
						<h1 class="h2 text-white mb-1 "> 
						<span itemprop="name">{{$institution->name}}</span> 
						@if(!empty($institution->abbr))
							<span class="fw-light">({{$institution->abbr}})</span>
						@endif 
						</h1>
                          
						  <link itemprop="url" href="{{url()->current()}}">
						  <link itemprop="sameAs" href="{{$institution->url}}">
						  
						<h2 itemprop="address" itemscope itemtype="https://schema.org/PostalAddress" class="h4 fw-light text-white mb-1">
							<meta itemprop="streetAddress" content="{{$institution->address}}">
							@if(!empty($institution->locality)) <span itemprop="addressLocality">{{$institution->locality}} </span>- @endif  <span itemprop="addressRegion">{{$institution->state->name}} @if(!empty($institution->state->is_state)) State @endif </span> 
						     <meta itemprop="postalCode" content="{{$institution->postal_code}}">
							<meta itemprop="addressCountry" content="NG">
						
						</h2>
						<div class="text-white">
						@if(!empty($institution->slogan))( <em itemprop="slogan">{{$institution->slogan}}</em> ) @endif
						</div>
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
				<i class="fa fa-caret-down text-sm"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                <div class="bg-primary-dark rounded-top fw-semibold fs-sm text-white text-center p-3">
                  Latest News from {{$institution->abbr}}
                </div>
                <ul class="nav-items my-2">
				
				@foreach($institution->news->take(3) as $news)
                  <li>
                    <a class="d-flex text-dark py-2" href="{{route('institutions.news.show',['institution' => $institution, 'news' => $news])}}">
                      <div class="flex-shrink-0 mx-3">
                        <i class="fa fa-fw fa-rss text-success"></i>
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
						<i class="fa fa-share-alt opacity-50 me-1"></i> Share Institution
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
	<div class="content content-boxed">
		<div class="row">
			<div class="col-md-4 order-md-1">

				<!-- Institution Summary -->
				<div class="block block-rounded">
					<div class="block-header block-header-default text-center studynexus-bg-cubes" >
							<h3 class="block-title">Highlights</h3>
					</div>
					<div class="block-content">
						<ul class="fa-ul list-icons">
							<li class="mb-1">
								<span class="fa-li text-primary">
									<i class="fa fa-university"></i>
								</span>
								<div class="fw-semibold">Type</div>
								<div class="">{{$institution->institutionType->name}} {{$institution->category->name}}</div>
							</li>
							<li class="mb-1">
								<span class="fa-li text-primary">
									<i class="fa fa-calendar"></i>
								</span>
								<div class="fw-semibold">Term Structure</div>
								<div class="">{{$institution->term->name}}</div>
							</li>
							
							@if(!empty($institution->established))
							<li class="mb-1">
								<span class="fa-li text-primary">
									<i class="fa fa-calendar-check"></i>
								</span>
								<div class="fw-semibold">Established</div>
								<div itemprop="foundingDate" class="">{{$institution->established}}</div>
							</li>
							@endif
							
							<li class="mb-1">
								<span class="fa-li text-primary">
									<i class="fa fa-map-marker-alt"></i>
								</span>
								<div class="fw-semibold">Religious Affiliation</div>
								<div class=""> {{$institution->religiousAffiliation->name}}  </div>
							</li>
							
							@if(!empty($institution->head))
							<li class="mb-1">
								<span class="fa-li text-primary">
									<i class="fa fa-map-marker-alt"></i> 
								</span>
								<div class="fw-semibold"> {{$institution->institutionHead->name}}</div>
								<div class="">{{$institution->head}}  </div>
							</li>
							@endif
							
						</ul>
					</div>
				</div>
				<!-- END Summary -->
			</div>

			<div class="col-md-8 order-md-0">

				<!-- Institution Description -->
				<div class="block block-rounded">
					<div class="block-header block-header-default text-center studynexus-bg-cubes" >
						<h3 class="block-title">Overview</h3>
					</div>
					<div  class="block-content pb-3">
					
							
					
						@if(!empty($institution->description))
						<span itemprop="description">{!! $institution->description !!}</span>
						@else
                        <span itemprop="description">{{$institution->description_alt}}</span>
					    @endif
	
	
						
					</div>
					@if(!empty($institution->parentInstitution))
							
						  <div class="block bg-body-light p-2">
							
					       <span class="fw-semibold me-1">Parent Institution: </span>  <a href="{{route('institutions.show', ['institution' => $institution->parentInstitution])}}"> {{$institution->parentInstitution->name}} </a>

						
						</div>
					@endif
					
				</div>
				<!-- END Institution Description -->
				
				@if(!empty($institution->remarks))
				<div class="block block-rounded">
					
					<div class="block-content fs-sm">
						<p> {{$institution->remarks}} </p>
					</div>
				</div>
				@endif

                @if($institution->catchments->isNotEmpty())
				<!-- Catchment Areas -->
				<div class="block block-rounded text-center">
					<div class="block-header block-header-default studynexus-bg-cubes" >
						<h3 class="block-title">Catchment Areas</h3>
					</div>
					<div class="block-content">
						<ul class="list-inline">
							@foreach($institution->catchments as $catchment)
								<li itemprop="serviceArea" itemscope itemtype="https://schema.org/Place" class="list-inline-item">
									<a  href="{{route('institutions.catchments.show', ['catchment' => $catchment])}}">
									<span itemprop="name" class="fs-sm text-primary-dark">{{$catchment->name}}</span>
							        </a> 
								</li>
							@endforeach
						</ul>
						<span class="fs-sm">(Check <a href="{{route('institutions.catchments.policy')}}">Catchment Area Policy</a>). </span> 						
					</div>
				</div>
				@endif
				<!-- END Catchment Areas -->
										


				<!-- Academic Tiers -->
				<div itemscope itemtype="https://schema.org/ItemList" class="block block-rounded">
					<div class="block-header block-header-default studynexus-bg-cubes" >
						<h3 itemprop="name" class="block-title text-center">Academic Tiers</h3>
					</div>
					<div class="block-content">

					@foreach($levels as $level)

					<a  class="block block-rounded block-bordered block-link-shadow" href="{{route('institutions.programs', ['institution' => $institution, 'level' => $level])}}">
						
						<div itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"  class="block-content block-content-full d-flex align-items-center justify-content-between p-2">
							<meta itemprop="position" content="{{$loop->iteration}}"/>
							<div itemprop="item" itemscope itemtype="https://schema.org/EducationalOccupationalProgram" class="me-3">
							    <p class="fs-lg text-primary mb-0">
								   <span itemprop="name"> {{$level->name}}</span> @if(!empty($level->abbr))<span class="fw-light text-black">({{$level->abbr}})</span> @endif
							    </p>
								
								<span itemprop="offers" itemscope itemtype="https://schema.org/Offer">
								<p itemprop="priceSpecification" itemscope itemtype="https://schema.org/PriceSpecification" class=" mb-0">
								  @if(!empty($level->programs->min('pivot.tuition_fee')))
										 @if($level->programs->min('pivot.tuition_fee') == $level->programs->max('pivot.tuition_fee'))
										<span itemprop="priceCurrency" content="NGN">₦</span> <span itemprop="minPrice"> {{Number::format($level->programs->min('pivot.tuition_fee'))}} </span>
										 @else                            
										<span itemprop="priceCurrency" content="NGN">₦</span> <span itemprop="minPrice"> {{Number::format($level->programs->min('pivot.tuition_fee'))}}</span> - <span itemprop="priceCurrency" content="NGN">₦</span> <span itemprop="maxPrice">{{Number::format($level->programs->max('pivot.tuition_fee'))}} </span>
										 @endif
								   @endif								   
								</p>
								</span>
							</div>
						<div>
						  <div class="h6 mb-0">Programmes</div> 
						  <div class="text-center">(<span class="text-primary">{{$level->programs->count()}}</span>)</div>
						</div>
					  </div>
					</a> @endforeach
					</div>
				</div>
				<!-- END Academic Tiers -->


				<!-- Rankings -->
				<div class="block block-rounded">
					<div class="block-header block-header-default text-center studynexus-bg-cubes" >
						<h3 class="block-title">Rankings</h3>
					</div>
					<div class="block-content">

						<table class="table table-borderless">
							<tr class="">
								<td class=""> {{$institution->category->name}} Rank in <span class="text-black fw-semibold"> {{$institution->state->name}} @if(!empty($institution->state->is_state)) State @endif </span></td>
								<td>@if ($rank['state']) <span class="fw-semibold text-black">{{Number::ordinal($rank['state'])}} </span> @else NR @endif out of {{$institution->state->institutions->where('category_id',$institution->category->id)->count()}} {{$institution->category->name_plural}}</td>
								<td> <a class="btn btn-sm btn-info" href="{{route('institutions.categories.ranking.state', ['categoryClass' => $institution->category, 'state' => $institution->state])}}"> View </a> </td>
							</tr>

							<tr>
								<td class="">{{$institution->category->name}} Rank in <span class="text-black fw-semibold">{{$institution->state->region->name}}</span></td>
								<td>@if ($rank['region']) <span class="fw-semibold text-black">{{Number::ordinal($rank['region'])}}</span> @else NR @endif out of {{$institution->state->region->institutions->where('category_id',$institution->category->id)->count()}} {{$institution->category->name_plural}}</td>
								<td> <a class="btn btn-sm btn-info" href="{{route('institutions.categories.ranking.region', ['categoryClass' => $institution->category, 'region' => $institution->state->region])}}"> View </a> </td>
							</tr>

							<tr>
								<td class="">{{$institution->category->name}} Rank in <span class="text-black fw-semibold">Nigeria</span></td>
								<td>@if ($rank['institution']) <span class="fw-semibold text-black">{{Number::ordinal($rank['institution'])}}</span> @else NR @endif out of {{$institution->category->institutions->count()}} {{$institution->category->name_plural}} </td>
								<td> <a class="btn btn-sm btn-info" href="{{route('institutions.categories.ranking', ['categoryClass' => $institution->category])}}"> View </a> </td>
							</tr>
						</table>
					</div>
				</div>
				<!-- END Rankings -->


				<!-- Accreditation -->
				<div itemprop="hasCredential" itemscope itemtype="https://schema.org/EducationalOccupationalCredential" class="block block-rounded">
					<div class="block-header block-header-default text-center studynexus-bg-cubes" >
						<h3 itemprop="credentialCategory" class="block-title">Accreditation</h3>
					</div>
					<div itemprop="recognizedBy" itemscope itemtype="https://schema.org/EducationalOrganization" class="block-content">
						<table class="table">
							<tr>
								<td class="fw-semibold">Institution Accreditation Body</td>
								<td><a class="link-dark"> <span itemprop="name">{{$institution->accreditationBody->name}}</span> @if(!empty($institution->accreditationBody->abbr)) (<span itemprop="alternateName">{{$institution->accreditationBody->abbr}}</span>) @endif </a>    <img src="{{ Storage::url($institution->accreditationBody->logo) }}" alt="{{$institution->accreditationBody->name}} logo"  style="width: 40px; height: 40px; object-fit: cover;">
						   </td>
							    <link itemprop="sameAs" href="{{$institution->accreditationBody->url}}">
								<link itemprop="image" href="{{$institution->accreditationBody->logo}}">
							</tr>
							<tr>
								<td class="fw-semibold">Accreditation Status</td>
								<td>  
								@if(!empty($institution->accreditationStatus))
								<span class="fs-6 badge bg-{{$institution->accreditationStatus->class}} rounded-0">
								{{$institution->accreditationStatus->name}}
								</span>
								@else
									Not Available
								@endif
								</td>
							</tr>		   
						</table>
					</div>
				</div>
				<!-- END Accreditation -->

				@if($institution->childInstitutions->isNotEmpty())
				<!-- Subsidiary Institutions -->
				<div class="block block-rounded">
					<div class="block-header block-header-default text-center studynexus-bg-cubes" >
						<h3 class="block-title">Subsidiary Institutions</h3>
					</div>
					<div itemscope itemtype="https://schema.org/ItemList" class="block-content">
					<meta itemprop="name"  content="Subsidiary Institutions of {{$institution->name}}" >
					@foreach($institution->childInstitutions as $childInstitution)
                    <div itemprop="itemListElement" itemscope itemtype="https://schema.org/CollegeOrUniversity">
						<a itemprop="url" href="{{route('institutions.show', ['institution' => $childInstitution])}}" class="block block-rounded fs-sm mb-1">
						@if(!empty($childInstitution->url))  <link itemprop="sameAs" content="{{$childInstitution->url}}" /> @endif
						  <div class="block block-header-default bg-image mb-0">
							  <div class="bg-body-light text-center p-1">
								  <div class=" text-primary-darker mb-1"> <span itemprop="name">{{$childInstitution->name}}</span>
								   @if(!empty($childInstitution->abbr))<span >({{$childInstitution->abbr}})</span> @endif 
								</div>

								  
							  </div>
						  </div>
						</a> 
					</div>
					@endforeach
				
						
					</div>
				</div>
				<!-- End Subsidiary Institutions -->
				@endif
				
				
				@if($institution->affiliatedInstitutions->isNotEmpty())
					              
					
				<!-- Affiliated Institutions -->
				<div class="block block-rounded">
					<div class="block-header block-header-default text-center studynexus-bg-cubes" >
						<h3 class="block-title">Affiliated Institutions</h3>
					</div>
					<div itemscope itemtype="https://schema.org/ItemList" class="block-content">
					<meta itemprop="name"  content="Institutions affiliated with {{$institution->name}}" >
					@foreach($institution->affiliatedInstitutions as $affiliatedInstitution)
                    <div itemprop="itemListElement" itemscope itemtype="https://schema.org/CollegeOrUniversity">
						<a itemprop="url" href="{{route('institutions.show', ['institution' => $affiliatedInstitution])}}" class="block block-rounded fs-sm mb-1">
						@if(!empty($affiliatedInstitution->url))  <link itemprop="sameAs" content="{{$affiliatedInstitution->url}}" /> @endif
						  <div class="block block-header-default bg-image mb-0">
							  <div class="bg-body-light text-center p-1">
								  <div class=" text-primary-darker mb-1"> <span itemprop="name">{{$affiliatedInstitution->name}}</span>
								   @if(!empty($affiliatedInstitution->abbr))<span >({{$affiliatedInstitution->abbr}})</span> @endif 
								</div>

								  
							  </div>
						  </div>
						</a> 
					</div>
					@endforeach
				
						
					</div>
				</div>
				<!-- End Afiliated Institutions -->
				@endif

				<!-- Socials & Contact -->
				<div class="block block-rounded">
					<div class="block-header block-header-default text-center studynexus-bg-cubes" >
						<h3 class="block-title">Contact and Social</h3>
					</div>
					<div class="block-content">
						<div class="mb-3 px-3">
						    @if(!empty($institution->url))
							<div class="row bg-stripped">
								<div class="col-3  fw-light text-black"><i class="fa fa-link text-dark me-1"></i>Website </div>
								<div class="col"> <a class="text-primary-darker" href="{{$institution->url}}" target="_blank">{{$institution->url}}</a></div>
							</div>
							@endif
							
							@if(!empty($institution->email))
							<div class="row bg-stripped">
								<div class="col-3  fw-light text-black"> <i class="fas fa-envelope text-dark me-1"></i>Email</div>
								<div class="col"><a class="text-primary-darker" href="mailto:{{$institution->email}}"> <span itemprop="email">{{$institution->email}}</span></a></div>
							</div>
							@endif

							@if($institution->phoneNumbers->isNotEmpty())
							<div  class="row bg-stripped">
								<div  class="col-3 fw-light text-black"><i class="fa fa-phone text-dark me-1"></i>Phone </div>
								<div itemprop="contactPoint" itemscope itemtype="https://schema.org/ContactPoint" class="col"> 
								   @foreach($institution->phoneNumbers as $phone)
								   <a class="text-primary-darker" href="tel:+234{{substr($phone->number, 1)}}"> <span itemprop="telephone">+234 {{substr($phone->number, 1)}}</span> </a> @if(!empty($phone->holder)) <span itemprop="contactType" class="ms-2 fw-light fs-sm">({{$phone->holder}}) </span> @endif <br>
								   @endforeach
								</div>
							</div>
							@endif
							

							@foreach($institution->socials as $social) 
							<div class="row bg-stripped">
								<div class="col-3 fw-light text-black"> <i class="{{$social->socialType->icon}} text-dark me-1"></i> {{$social->socialType->name}} </div>
								<div class="col "> <a class="text-primary-darker" href="{{$social->socialType->url . $social->handle}}" target="_blank">{{Str::replaceFirst('https://','',$social->socialType->url) . $social->handle}}</a>  </div>
							</div>
							@endforeach 
						</div>
					</div>
				</div>
				<!-- End Socials & Contact -->

														
				<!-- Address -->
				<div  class="block block-rounded">
					<div class="block-header block-header-default text-center studynexus-bg-cubes" >
					  <h3 class="block-title">Location</h3>
					</div>
					<div class="block-content">
						<div class="mb-3 px-3">
							   @if(!empty($institution->address)) <span class="me-2 d-block"> {{$institution->address}}, </span> @endif
							   @if(!empty($institution->locality)) <span class="me-2 d-block"> {{$institution->locality}},</span> @endif
								<span class="me-2 d-block">{{$institution->state->name}} @if(!empty($institution->state->is_state)) State, @endif</span>
								@if(!empty($institution->postal_code))<span class="me-2 d-block"> {{$institution->postal_code}},</span>@endif
								<span class="me-2 d-block"> Nigeria.</span>
							   
						</div> 
                        @if(!empty($institution->coordinates))						
						<div class="map bg-success w-100 mx-auto mb-3" style="height: 300px;"> 
				<link itemprop="hasMap" href="https://maps.google.com/place/1,university+drive+bsu,+makurdi">
						
						
						<iframe
							  width="400"
							  height="250"
							  frameborder="0" style="border:0"
							  referrerpolicy="no-referrer-when-downgrade"
							  src="https://www.google.com/maps/embed/v1/MAP_MODE?key=YOUR_API_KEY&PARAMETERS"
							  allowfullscreen>
					    </iframe>
						
						
						
						</div> 
                        @endif						
					</div>
				</div>	
				<!-- END Address -->
				
		</div>
	</div>
	<!-- END Page Content -->
</span>
@endsection