@extends('layouts.backend') 

@section('content') 

@php 
use Illuminate\Support\Str; 
use Illuminate\Support\Number; 
@endphp


<!-- Hero -->
<div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
    <div class="bg-black-75">
        <div class="content content-full content-top text-center pt-7">
            <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">{{Str::title($institution->name)}} @if(!empty($institution->abbr))<span class="text-white-75">({{Str::upper($institution->abbr)}})</span>@endif</h1>

                <h2 class="h4 fs-md  fw-light text-white-75 mb-1">
                     @if(isset($institution->locality)) {{str::title($institution->locality)}} @endif - @if($institution->state->id == 15) FCT @else {{str::title($institution->state->name)}} State @endif
                </h2>

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
                <div class="block-content fs-sm">
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
                        <li class="mb-1">
                            <span class="fa-li text-primary">
                  <i class="fa fa-calendar-check"></i>
                </span>
                            <div class="fw-semibold">Established</div>
                            <div class="text-muted">{{$institution->established}}</div>
                        </li>
                        <li class="mb-1">
                            <span class="fa-li text-primary">
                  <i class="fa fa-map-marker-alt"></i>
                </span>
                            <div class="fw-semibold">Location</div>
                            <div class="text-muted"> @if(isset($institution->locality)) {{str::title($institution->locality)}}, @endif {{str::title($institution->lga->name)}} - @if($institution->state->id == 15) FCT @else {{str::title($institution->state->name)}} State @endif </div>
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
                <div class="block-content pb-3">


                    {{$institution->description}}

                </div>
            </div>
            <!-- END Institution Description -->


            
            <!-- Catchment Areas -->
            <div class="block block-rounded text-center">
                <div class="block-header block-header-default" style="background-image: url(/media/patterns/cubes.png)">
                    <h3 class="block-title">Catchment Areas</h3>
                </div>
                <div class="block-content">

                    @if($institution->catchments->isNotEmpty())
                    <ul class="list-inline">
                        @foreach($institution->catchments as $catchment)
                        <li class="list-inline-item"><a class="" href="{{route('institutions.catchments.show', ['catchment' => $catchment->slug])}}">{{str::title($catchment->name)}}</a> </li>
                        @endforeach
                    </ul>
                    @else All states of the federation. <span class="fs-sm">(Check <a href="{{route('institutions.catchments.policy')}}">Catchment Area Policy</a>). </span> @endif


                </div>
            </div>
            <!-- END Catchment Areas -->
            


            <!-- Academic Tiers -->
            <div class="block block-rounded">
                <div class="block-header block-header-default" style="background-image: url(/media/patterns/cubes.png)">
                    <h3 class="block-title text-center">Academic Tiers</h3>
                </div>
                <div class="block-content">

                    @foreach($levels as $level)



                    <a class="block block-rounded block-bordered block-link-shadow" href="{{route('institutions.programs', ['institution' => $institution->id, 'level' => $level->slug])}}">
                  <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                    <div class="me-3">
                      <p class="fs-lg text-primary mb-0">
                        {{$level->name}} @if(!empty($level->abbr))<span class="fw-light text-black">({{str::upper($level->abbr)}})</span> @endif
                      </p>
                      <p class="text-muted mb-0">
                      @if(!empty($level->programs->min('pivot.tuition_fee')))
                             @if($level->programs->min('pivot.tuition_fee') == $level->programs->max('pivot.tuition_fee'))
                               ₦{{Number::format($level->programs->min('pivot.tuition_fee'))}}
                             @else                            
                               ₦{{Number::format($level->programs->min('pivot.tuition_fee'))}} - ₦{{Number::format($level->programs->max('pivot.tuition_fee'))}}  
                             @endif
                       @endif
                       
                      </p>
                    </div>
                    <div>
                      <div class="h6 mb-0">Courses</div> 
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

                        <tr>
                            <td class=""> {{str::title($institution->category->name)}} Rank in <span class="text-black fw-semibold"> {{str::title($institution->state->name)}} </span></td>
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


            <!-- Socials & Contact -->
            <div class="block block-rounded">
                <div class="block-header block-header-default text-center" style="background-image: url(/media/patterns/cubes.png)">
                    <h3 class="block-title">Contact and Social</h3>
                </div>
                <div class="block-content">
                    <div class="mb-3">
                        <div class="row bg-stripped">
                            <div class="col-3  fw-light text-black">Website <i class="fa fa-link text-dark"></i></div>
                            <div class="col"> <a href="">abu.edu.ng</a></div>
                        </div>
                        <div class="row bg-stripped">
                            <div class="col-3  fw-light text-black">Email <i class="fas fa-envelope text-dark"></i></div>
                            <div class="col"><a href="mailto:support@abu.edu.ng">support@abu.edu.ng</a></div>
                        </div>

                         @if($institution->phonenumbers->isNotEmpty())
                        <div class="row bg-stripped">
                            <div class="col-3 fw-light text-black">Phone <i class="fa fa-phone-flip text-dark"></i></div>
                            <div class="col"> 
                               @foreach($institution->phonenumbers as $phone)
                               <a href="tel:+234{{substr($phone->number, 1)}}">+234 {{substr($phone->number, 1)}} </a> @if(isset($phone->holder)) <span class="ms-2 fw-light">( {{$phone->holder}} ) </span> @endif <br>
                               @endforeach
                            </div>
                        </div>
                        @endif

                          @foreach($institution->socials as $social) 
                        <div class="row bg-stripped">
                            <div class="col-3 fw-light text-black"> {{$social->socialtype->name}}  <i class="{{$social->socialtype->icon}} text-dark"></i></div>
                            <div class="col"> <a href="https://{{$social->url}}">{{$social->url}}</a>  </div>
                        </div>
                         @endforeach 
                    </div>
                </div>
            </div>
            <!-- End Socials & Contact -->

                            

              @if(isset($institution->address))
            <!-- Address -->
              <div class="block block-rounded text-center">
                <div class="block-header block-header-default" style="background-image: url(/media/patterns/cubes.png)">
                  <h3 class="block-title">Location</h3>
                </div>
                <div class="block-content">
                  <div class="mb-3">
                    <span class="fw-semibold me-2">Address:</span>
                    795 Folsom Ave, Suite 600, San Francisco, CA 94107 
                    <abbr title="Phone">P:</abbr> (123) 456-7890
                  </div>                   
                  <div class="map bg-success w-100 mx-auto mb-3" style="height: 300px;"> 
                        Map Goes Here! {{$institution->address}}
                  </div                  
                </div>
              </div>
              <!-- END Address -->
                @endif


        </div>
    </div>
</div>
<!-- END Page Content -->

@endsection