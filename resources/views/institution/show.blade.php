@extends('layouts.backend') 

@section('content') 

@php 
use Illuminate\Support\Str; 
use Illuminate\Support\Number; 
@endphp

<span itemscope itemtype="https://schema.org/CollegeOrUniversity">
	
	
	<!-- Hero  -->
        <div class="bg-image" style="background-image: url('/media/photos/photo13@2x.jpg');">
          <div class="bg-black-75">
            <div class="content content-boxed content-full py-5 pt-7">
              <div class="row">
			    @if(!empty($institution->logo))
				
			    <div class="col-md-4 d-flex align-items-center">
                  <div class="block block-rounded  block-transparent bg-black-50 text-center mb-0 mx-auto" href="be_pages_jobs_apply.html" style="box-shadow:0 0 2.25rem #d1d8ea;opacity:1">
                    <div class="block-content block-content-full px-2 py-2">
					
                      <img  src="{{$institution->logo}}" alt="{{$institution->name}} logo" class="" style="width: 150px; height: 150px; object-fit: cover;"></img>
                      <link itemprop="logo" href="{{$institution->logo}}">
                    </div>
                  </div>
                </div>
				@endif
				
                <div class=" @if(!empty($institution->logo)) col-md-8 @endif d-flex align-items-center py-3">
					 <div class="w-100 text-center @if(!empty($institution->logo)) text-md-start @endif">
						<h1>  <a class="fw-light text-white mb-1 link-fx" href="{{route('institutions.show',['institution' => $institution->id])}}"> 
						<span itemprop="name">{{Str::title($institution->name)}}</span> 
						@if(!empty($institution->abbr))
							<span class="text-white-75">({{Str::upper($institution->abbr)}})</span>
						@endif 
						</a></h1>
                          
						  <link itemprop="url" href="{{url()->current()}}">
						  <link itemprop="sameAs" href="{{$institution->url}}">
						  
						<h2 itemprop="address" itemscope itemtype="https://schema.org/PostalAddress" class="h4 fs-md  fw-light text-white-75 mb-1">
							<meta itemprop="streetAddress" content="{{$institution->address}}">
							@if(!empty($institution->locality)) <span itemprop="addressLocality">{{str::title($institution->locality)}} </span>- @endif  <span itemprop="addressRegion">{{str::title($institution->state->name)}} @if(!empty($institution->state->is_state)) State @endif </span> 
						     <meta itemprop="postalCode" content="{{$institution->postal_code}}">
							<meta itemprop="addressCountry" content="NG">
						
						</h2>
						<div class="text-white">
						@if(!empty($institution->slogan))( <i itemprop="slogan">{{$institution->slogan}}</i> ) @endif
						</div>
					 </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->


	<!-- Page Content -->
	<div class="content content-boxed">
		<div class="row">
			<div class="col-md-4 order-md-1">

				<!-- Institution Summary -->
				<div class="block block-rounded">
					<div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
							<h3 class="block-title">Highlights</h3>
					</div>
					<div class="block-content">
						<ul class="fa-ul list-icons">
							<li class="mb-1">
								<span class="fa-li text-primary">
									<i class="fa fa-university"></i>
								</span>
								<div class="fw-semibold">Type</div>
								<div class="text-muted">{{str::title($institution->schooltype->name)}} {{$institution->category->name}}</div>
							</li>
							<li class="mb-1">
								<span class="fa-li text-primary">
									<i class="fa fa-calendar"></i>
								</span>
								<div class="fw-semibold">Term Structure</div>
								<div class="text-muted">{{str::title($institution->term->name)}}</div>
							</li>
							
							@if(!empty($institution->established))
							<li class="mb-1">
								<span class="fa-li text-primary">
									<i class="fa fa-calendar-check"></i>
								</span>
								<div class="fw-semibold">Established</div>
								<div itemprop="foundingDate" class="text-muted">{{$institution->established}}</div>
							</li>
							@endif
							
							<li class="mb-1">
								<span class="fa-li text-primary">
									<i class="fa fa-map-marker-alt"></i>
								</span>
								<div class="fw-semibold">Location</div>
								<div class="text-muted"> @if(!empty($institution->locality)) {{str::title($institution->locality)}} - @endif {{$institution->state->name}} @if(!empty($institution->state->is_state)) State @endif  </div>
							</li>
						</ul>
					</div>
				</div>
				<!-- END Summary -->
			</div>

			<div class="col-md-8 order-md-0">

				<!-- Institution Description -->
				<div class="block block-rounded">
					<div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
						<h3 class="block-title">Overview</h3>
					</div>
					<div  class="block-content pb-3">
					
						@if(!empty($institution->description))
						<span itemprop="description">{{$institution->description}}</span>
						@else
                        <span itemprop="description">{{$institution->description_alt}}</span>
					    @endif
	
					</div>
				</div>
				<!-- END Institution Description -->

                @if($institution->catchments->isNotEmpty())
				<!-- Catchment Areas -->
				<div class="block block-rounded text-center">
					<div class="block-header block-header-default" style="background-image: url(/media/patterns/cubes.png)">
						<h3 class="block-title">Catchment Areas</h3>
					</div>
					<div class="block-content">
						<ul class="list-inline">
							@foreach($institution->catchments as $catchment)
								<li itemprop="serviceArea" itemscope itemtype="https://schema.org/Place" class="list-inline-item">
									<a  href="{{route('institutions.catchments.show', ['catchment' => $catchment->slug])}}">
									<span itemprop="name">	{{str::title($catchment->name)}} </span>
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
					<div class="block-header block-header-default" style="background-image: url(/media/patterns/cubes.png)">
						<h3 itemprop="name" class="block-title text-center">Academic Tiers</h3>
					</div>
					<div class="block-content">

					@foreach($levels as $level)

					<a  class="block block-rounded block-bordered block-link-shadow link-fx" href="{{route('institutions.programs', ['institution' => $institution->id, 'level' => $level->slug])}}">
						
						<div itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"  class="block-content block-content-full d-flex align-items-center justify-content-between p-2">
							<meta itemprop="position" content="{{$loop->iteration}}"/>
							<div itemprop="item" itemscope itemtype="https://schema.org/EducationalOccupationalProgram" class="me-3">
							    <p class="fs-lg text-primary mb-0">
								   <span itemprop="name"> {{$level->name}}</span> @if(!empty($level->abbr))<span class="fw-light text-black">({{str::upper($level->abbr)}})</span> @endif
							    </p>
								
								<span itemprop="offers" itemscope itemtype="https://schema.org/Offer">
								<p itemprop="priceSpecification" itemscope itemtype="https://schema.org/PriceSpecification" class="text-muted mb-0">
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
					<div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
						<h3 class="block-title">Rankings</h3>
					</div>
					<div class="block-content">

						<table class="table table-borderless">
							<tr class="">
								<td class=""> {{str::title($institution->category->name)}} Rank in <span class="text-black fw-semibold"> {{str::title($institution->state->name)}} @if(!empty($institution->state->is_state)) State @endif </span></td>
								<td>@if ($rank['state']) <span class="fw-semibold text-black">{{Number::ordinal($rank['state'])}} </span> @else NR @endif out of {{$institution->state->institutions->where('category_id',$institution->category->id)->count()}} @if($institution->category->id == 4) Colleges of Education  @else {{str::of($institution->category->name)->title()->plural()}} @endif</td>
								<td> <a class="btn btn-sm btn-info" href="{{route('institutions.categories.ranking.state', ['category' => $institution->category->slug, 'state' => $institution->state->slug])}}"> View </a> </td>
							</tr>

							<tr>
								<td class="">{{str::title($institution->category->name)}} Rank in <span class="text-black fw-semibold">{{str::title($institution->state->region->name)}}</span></td>
								<td>@if ($rank['region']) <span class="fw-semibold text-black">{{Number::ordinal($rank['region'])}}</span> @else NR @endif out of {{$institution->state->region->institutions->where('category_id',$institution->category->id)->count()}}
									@if($institution->category->id == 4) Colleges of Education  @else {{str::of($institution->category->name)->title()->plural()}} @endif</td>
								<td> <a class="btn btn-sm btn-info" href="{{route('institutions.categories.ranking.region', ['category' => $institution->category->slug, 'region' => $institution->state->region->slug])}}"> View </a> </td>
							</tr>

							<tr>
								<td class="">{{str::title($institution->category->name)}} Rank in <span class="text-black fw-semibold">Nigeria</span></td>
								<td>@if ($rank['institution']) <span class="fw-semibold text-black">{{Number::ordinal($rank['institution'])}}</span> @else NR @endif out of {{$institution->category->institutions->count()}} @if($institution->category->id == 4) Colleges of Education  @else {{str::of($institution->category->name)->title()->plural()}} @endif</td>
								<td> <a class="btn btn-sm btn-info" href="{{route('institutions.categories.ranking', ['category' => $institution->category->slug])}}"> View </a> </td>
							</tr>
						</table>
					</div>
				</div>
				<!-- END Rankings -->


				<!-- Accreditation -->
				<div itemprop="hasCredential" itemscope itemtype="https://schema.org/EducationalOccupationalCredential" class="block block-rounded">
					<div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
						<h3 itemprop="credentialCategory" class="block-title">Accreditation</h3>
					</div>
					<div itemprop="recognizedBy" itemscope itemtype="https://schema.org/EducationalOrganization" class="block-content">
						<table class="table">
							<tr>
								<td class="fw-semibold">Institution Accreditation Body</td>
								<td><a class="link-fx link-dark"> <span itemprop="name">{{$institution->accreditationBody->name}}</span> @if(!empty($institution->accreditationBody->abbr)) (<span itemprop="alternateName">{{str::upper($institution->accreditationBody->abbr)}}</span>) @endif </a> </td>
							    <link itemprop="sameAs" href="{{$institution->accreditationBody->url}}">
							</tr>
							<tr>
								<td class="fw-semibold">Accreditation Status</td>
								<td>  
								@if(!empty($institution->accreditationStatus))
								<button type="button" class="btn btn-{{$institution->accreditationStatus->class}} rounded-0" disabled>
								{{$institution->accreditationStatus->name}}
								</button>
								@else
									Not Available
								@endif
								</td>
							</tr>		   
						</table>
					</div>
				</div>
				<!-- END Accreditation -->



				<!-- Socials & Contact -->
				<div class="block block-rounded">
					<div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
						<h3 class="block-title">Contact and Social</h3>
					</div>
					<div class="block-content">
						<div class="mb-3 px-3">
						    @if(!empty($institution->url))
							<div class="row bg-stripped">
								<div class="col-3  fw-light text-black"><i class="fa fa-link text-dark me-1"></i>Website </div>
								<div class="col"> <a class="link-fx link-info" href="{{$institution->url}}">{{$institution->url}}</a></div>
							</div>
							@endif
							
							@if(!empty($institution->email))
							<div class="row bg-stripped">
								<div class="col-3  fw-light text-black"> <i class="fas fa-envelope text-dark me-1"></i>Email</div>
								<div class="col"><a class="link-fx link-info" href="mailto:{{$institution->email}}"> <span itemprop="email">{{$institution->email}}</span></a></div>
							</div>
							@endif

							@if($institution->phonenumbers->isNotEmpty())
							<div  class="row bg-stripped">
								<div  class="col-3 fw-light text-black"><i class="fa fa-phone text-dark me-1"></i>Phone </div>
								<div itemprop="contactPoint" itemscope itemtype="https://schema.org/ContactPoint" class="col"> 
								   @foreach($institution->phonenumbers as $phone)
								   <a class="link-fx link-info" href="tel:+234{{substr($phone->number, 1)}}"> <span itemprop="telephone">+234 {{substr($phone->number, 1)}}</span> </a> @if(!empty($phone->holder)) <span itemprop="contactType" class="ms-2 fw-light fs-sm">({{$phone->holder}}) </span> @endif <br>
								   @endforeach
								</div>
							</div>
							@endif
							

							@foreach($institution->socials as $social) 
							<div class="row bg-stripped">
								<div class="col-3 fw-light text-black"> <i class="{{$social->socialtype->icon}} text-dark me-1"></i> {{$social->socialtype->name}} </div>
								<div class="col "> <a class="link-fx link-info" href="https://{{$social->url}}">{{$social->url}}</a>  </div>
							</div>
							@endforeach 
						</div>
					</div>
				</div>
				<!-- End Socials & Contact -->

														
				<!-- Address -->
				<div  class="block block-rounded">
					<div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
					  <h3 class="block-title">Location</h3>
					</div>
					<div class="block-content">
						<div class="mb-3 px-3">
							   @if(!empty($institution->address)) <span class="me-2 d-block"> {{$institution->address}} </span> @endif
							   @if(!empty($institution->locality)) <span class="me-2 d-block"> {{$institution->locality}}</span> @endif
								<span class="me-2 d-block">{{$institution->state->name}} @if(!empty($institution->state->is_state)) State @endif <span class="fs-sm">(NG-{{$institution->state->code}})</span> </span>
								@if(!empty($institution->postal_code))<span class="me-2 d-block"> {{$institution->postal_code}}</span>@endif
								<span class="me-2 d-block"> Nigeria (<span class="fs-sm">NG</span>)</span>
							   
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