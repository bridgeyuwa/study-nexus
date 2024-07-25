@extends('layouts.backend') 

@section('content') 

@php 
use Illuminate\Support\Str; 
use Illuminate\Support\Number; 
@endphp

<span itemscope itemtype="https://schema.org/WebPage" >


<!-- Hero -->
<div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
    <div class="bg-black-75">
        <div class="content content-full content-top text-center pt-7">
            <div class="pt-4 pb-3">
                <h1  itemprop="name"  ><a class="fw-light text-white mb-1" href="{{route('institutions.categories.ranking', ['category' => $category->slug])}}">{{str::title($category->name)}} Rankings</a></h1>
                <meta itemprop="sameAs" content="https://webometrics.info/en/Africa/Nigeria">
				<meta itemprop="url" content="{{url()->current()}}">
itemprop="url"
                <h2 class="h4 fs-md  fw-light text-white-75 mb-1">
                    @if(isset($state)) {{str::title($state->name)}} - Nigeria @elseif(isset($region)) {{str::title($region->name)}} - Nigeria @else Nigeria @endif
                </h2>

            </div>
        </div>
    </div>
</div>
<!-- END Hero -->



<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-content">

            <h2 class="content-heading text-center">Ranking of @if($category->id == 4) Colleges of Education @else {{str::of($category->name)->title()->plural()}} @endif in @if(isset($state)) {{str::title($state->name)}}, Nigeria @elseif(isset($region)) {{str::title($region->name)}}, Nigeria @else Nigeria @endif </h2>
            <div itemprop="description" class="row items-push">
                <div>
                        <p class="text-muted ">
                            Discover the top-ranked Nigerian @if($category->id == 4) Colleges of Education @else {{str::of($category->name)->title()->plural()}} @endif with our comprehensive ranking table. Explore accreditation details, admission criteria, and courses offered by
                            the best @if($category->id == 4) Colleges of Education @else {{str::of($category->name)->title()->plural()}} @endif in @if(isset($state)) {{str::title($state->name)}} state, @elseif(isset($region)) {{str::title($region->name)}}, @endif Nigeria. Whether
                            you are searching for the top @if($category->id == 4) Colleges of Education @else {{str::of($category->name)->title()->plural()}} @endif in Nigeria or seeking valuable insights into higher education, our list provides essential
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
                                <i class="fa fa-star me-1"></i>@if(isset($state)) {{str::title($state->name)}} @elseif(isset($region)) {{str::title($region->name)}} @else Nigeria @endif Rank 
                                </th>
                                <th style="min-width: 265px;">{{$category->name}}</th>
                                <th class="@if(isset($state)) d-none @endif" style="width: 15%; min-width: 140px;">State Rank</th>
                                <th class="@if(isset($region)) d-none @endif" style="width: 18% ; min-width: 157px;">Region Rank</th>
                                <th class="text-center" style="width: 10%;"><span data-bs-toggle="tooltip" data-bs-placement="top" title="World Rank (Webometrics)">WR</span></th>
                            </tr>
                        </thead>

                        <tbody itemscope itemtype="https://schema.org/ItemList">
						<meta itemprop="name" content="Ranking of @if($category->id == 4) Colleges of Education @else {{str::of($category->name)->title()->plural()}} @endif in @if(isset($state)) {{str::title($state->name)}}, Nigeria @elseif(isset($region)) {{str::title($region->name)}}, Nigeria @else Nigeria @endif">
                            @foreach($institutions as $institution)
							
							
                            <tr itemscope itemprop="itemListElement" itemtype="https://schema.org/ListItem">
							@isset($institution->rank) <meta itemprop="position" content="{{$rank[$institution->id]['institution']}}"> @endisset
                                <td class="fw-semibold fs-sm text-center text-black">
                                 @if(!empty($rank[$institution->id]['institution'])) {{Number::ordinal($rank[$institution->id]['institution'])}} @else NR @endif
                                </td>
                                <td class="fs-sm">
                                   <a itemscope itemtype="https://schema.org/CollegeOrUniversity" itemprop="item" href="{{route('institutions.show', ['institution' => $institution->id])}}">
									<span itemprop="name">{{str::of($institution->name)->title()}}</span>
									<meta itemprop="url" content="{{route('institutions.show', ['institution' => $institution->id])}}">
									@isset($institution->url)<meta itemprop="sameAs" content="{{$institution->url}}"> @endisset
										
									</a>
                                </td>
                                <td class="fs-sm @if(isset($state)) d-none @endif">

                                    @if(!empty($rank[$institution->id]['state'])) {{Number::ordinal($rank[$institution->id]['state'])}} @else NR @endif in

                                    <a href="{{route('institutions.categories.ranking.state', ['category' => $institution->category->slug, 'state' => $institution->state->slug])}}"> {{str::title($institution->state->name)}} </a>

                                </td>

                                <td class="fs-sm @if(isset($region)) d-none @endif">

                                    @if(!empty($rank[$institution->id]['region'])) {{Number::ordinal($rank[$institution->id]['region'])}} @else NR @endif in

                                    <a href="{{route('institutions.categories.ranking.region', ['category' => $institution->category->slug, 'region' => $institution->state->region->slug])}}">{{str::title($institution->state->region->name)}}</a>

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