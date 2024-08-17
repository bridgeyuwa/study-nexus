@extends('layouts.backend') 

@section('content') 

@php 
use Illuminate\Support\Number; 
@endphp

<span itemscope itemtype="https://schema.org/WebPage" >


<!-- Hero -->
<div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
    <div class="bg-black-75">
        <div class="content content-full content-top text-center pt-7">
            <div class="pt-4 pb-3">
                <h1  itemprop="name"  ><a class="fw-light text-white mb-1" href="{{route('institutions.categories.ranking', ['categoryClass' => $categoryClass])}}">{{$categoryClass->name}} Rankings</a></h1>
                <meta itemprop="sameAs" content="https://webometrics.info/en/Africa/Nigeria">
				<meta itemprop="url" content="{{url()->current()}}">

                <h2 class="h4 fs-md  fw-light text-white-75 mb-1">
                    @if(!empty($state)) {{$state->name}} @if(!empty($state->is_state)) State @endif - Nigeria @elseif(!empty($region)) {{$region->name}} - Nigeria @else Nigeria @endif
                </h2>

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

	<div class="col-md-12 order-md-1">

            <!-- nav -->
            <div class="block block-rounded">
			
					 <ul class="nav nav-tabs nav-tabs-block bg-gray-lighter">
					
					@foreach($categoryClasses as $institution_category)
					
					<li class="nav-item">
						@if(!empty($state))
							<a href=" 
							{{route('institutions.categories.ranking.state', ['categoryClass' => $institution_category, 'state' => $state])}}
							"><button
							
							@if(
							route('institutions.categories.ranking.state', ['categoryClass' => $institution_category, 'state' => $state]) == url()->current()
							) 
							class="btn-sm nav-link active" disabled
							@else
								class="btn-sm nav-link"
							@endif
							
							> {{$institution_category->name}} Rankings ({{$state->name}})
							</button>
							</a>
						@elseif(!empty($region))
							<a href="
							{{route('institutions.categories.ranking.region', ['categoryClass' => $institution_category, 'region' => $region])}}
							"><button
							
							@if(
							route('institutions.categories.ranking.region', ['categoryClass' => $institution_category, 'region' => $region]) == url()->current()
							) 
							class="btn-sm nav-link active" disabled
							@else
								class="btn-sm nav-link"
							@endif
							
							> {{$institution_category->name}} Rankings ({{$region->name}})
							</button>
							</a>
						@else
							<a href="
							{{route('institutions.categories.ranking', ['categoryClass' => $institution_category])}}
							"><button
							
							@if(
							route('institutions.categories.ranking', ['categoryClass' => $institution_category]) == url()->current()
							) 
							class="btn-sm nav-link active" disabled
							@else
								class="btn-sm nav-link"
							@endif
							
							> {{$institution_category->name}} Rankings
							</button>
							</a>
						
						@endif
                  </li>
				  @endforeach
                  
                </ul>
            </div>
            <!-- END nav -->
        </div>


    <div class="block block-rounded">
        <div class="block-content">

            <h2 class="content-heading text-center">Ranking of {{$categoryClass->name_plural}} in @if(!empty($state)) {{$state->name}} @if(!empty($state->is_state)) State @endif, Nigeria @elseif(!empty($region)) {{$region->name}}, Nigeria @else Nigeria @endif </h2>
            <div itemprop="description" class="row items-push">
                <div>
                        <p>
                            Discover the top-ranked Nigerian {{$categoryClass->name_plural}} with our comprehensive ranking table. Explore accreditation details, admission criteria, and courses offered by
                            the best {{$categoryClass->name_plural}} in @if(!empty($state)) {{$state->name}} @if(!empty($state->is_state)) State, @endif @elseif(!empty($region)) {{$region->name}}, @endif Nigeria. Whether
                            you are searching for the top  {{$categoryClass->name_plural}} in Nigeria or seeking valuable insights into higher education, our list provides essential
                            information.
                        </p>
                </div>
            </div>



            <div class="table-responsive" >

                    <!-- full Table -->
                    <table class="table table-bordered table-striped table-vcenter ">
                       
						<thead class="table-dark">
                            <tr class="fs-sm">
                                <th class="text-center" style="width: 150px; min-width: 85px">
                                <i class="fa fa-star me-1"></i>@if(!empty($state)) {{$state->name}} @if(!empty($state->is_state)) State @endif @elseif(!empty($region)) {{$region->name}} @else Nigeria @endif Rank 
                                </th>
                                <th style="min-width: 265px;">{{$categoryClass->name}}</th>
                                <th class="@if(!empty($state)) d-none @endif" style="width: 15%; min-width: 140px;">State Rank</th>
                                <th class="@if(!empty($region)) d-none @endif" style="width: 18% ; min-width: 157px;">Region Rank</th>
                                <th class="text-center" style="width: 10%;"><span data-bs-toggle="tooltip" data-bs-placement="top" title="World Rank (Webometrics)">WR</span></th>
                            </tr>
                        </thead>

                        <tbody itemscope itemtype="https://schema.org/ItemList" >
						<meta itemprop="name" content="Ranking of {{$categoryClass->name_plural}} in @if(!empty($state)) {{$state->name}} @if(!empty($state->is_state)) State @endif, Nigeria @elseif(!empty($region)) {{$region->name}}, Nigeria @else Nigeria @endif" />
                            @foreach($institutions as $institution)
							
							
                            <tr itemscope itemprop="itemListElement" itemtype="https://schema.org/ListItem">
							@if(!empty($institution->rank)) <meta itemprop="position" content="{{$rank[$institution->id]['institution']}}"> @endif
                                <td class="fw-semibold fs-sm text-center text-black">
                                 @if(!empty($rank[$institution->id]['institution'])) {{Number::ordinal($rank[$institution->id]['institution'])}} @else NR @endif
                                </td>
                                <td class="fs-sm">
                                   <a itemscope itemtype="https://schema.org/CollegeOrUniversity" itemprop="item" href="{{route('institutions.show', ['institution' => $institution])}}">
									<span itemprop="name">{{$institution->name}}</span>
									<link itemprop="url" content="{{route('institutions.show', ['institution' => $institution])}}">
									@if(!empty($institution->url))<meta itemprop="sameAs" content="{{$institution->url}}"> @endif
									<span  itemprop="address" itemscope itemtype="https://schema.org/PostalAddress"> 
										@if(!empty($institution->address))<meta itemprop="streetAddress" content="{{$institution->address}}" >@endif
										@if(!empty($institution->locality))<meta itemprop="addressLocality" content="{{$institution->locality}}" >@endif
										<meta itemprop="addressRegion" content="{{$institution->state->name}} @if(!empty($institution->state->is_state)) State @endif" >
										@if(!empty($institution->postal_code))<meta itemprop="postalCode" content="{{$institution->postal_code}}" > @endif
										<meta itemprop="addressCountry" content="NG" />
									</span>	
										
									</a>
                                </td>
                                <td class="fs-sm @if(!empty($state)) d-none @endif">

                                    @if(!empty($rank[$institution->id]['state'])) {{Number::ordinal($rank[$institution->id]['state'])}} @else NR @endif in

                                    <a href="{{route('institutions.categories.ranking.state', ['categoryClass' => $institution->category->categoryClass, 'state' => $institution->state])}}"> {{$institution->state->name}}  </a>

                                </td>

                                <td class="fs-sm @if(!empty($region)) d-none @endif">

                                    @if(!empty($rank[$institution->id]['region'])) {{Number::ordinal($rank[$institution->id]['region'])}} @else NR @endif in

                                    <a href="{{route('institutions.categories.ranking.region', ['categoryClass' => $institution->category->categoryClass, 'region' => $institution->state->region])}}">{{$institution->state->region->name}}</a>

                                </td>
                                <td class="fs-sm text-center">
                                    @if(!empty($institution->rank)) {{$institution->rank}} @else NR @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- end full table -->
					{{$institutions->links()}}
            </div>
			
			
        </div>

    </div>
</div>
<!-- END Page Content -->


</span>


@endsection