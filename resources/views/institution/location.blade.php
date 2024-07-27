@extends('layouts.backend')


@section('content')
@php  use Illuminate\Support\Str;  @endphp

<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-6">
              <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">
                                    @if(!empty($category))
                                        @if($category->id === 4) 
                                          Colleges Of Education 
                                        @else 
                                          {{ Str::of($category->name)->plural()->title()}}
                                        @endif

                                    @else
										Tertiary Institutions
                                    @endif in Nigeria
               </h1>

                  <h2 class="h4 fs-md  fw-light text-white-75 ">
                     ( Locate @if(!empty($category))
                                        @if($category->id === 4) 
                                          Colleges Of Education 
                                        @else 
                                          {{ Str::of($category->name)->plural()->title()}}
                                        @endif

                                    @else
										Academic Institutions
                                    @endif by Region/State )
                    </h2>

           
            <h2 class="h3 fw-light text-white">Region/States</h2>
              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->



            <!-- Page Content -->
<div class="content content-boxed">

    <div class="row">
        <div class="col-md-4 order-md-1"> 

            <!-- Ads  -->
            <div class="block block-rounded d-none d-lg-block sticky-top" style="top: 100px;">
                <div class="block-header block-header-default" style="background-image: url(/media/patterns/cubes.png)">
                    <h3 class="block-title">Ads</h3>
                </div>
                <div class="block-content">

                    Ads

                </div>
            </div>
            <!-- END Ads -->
        </div>

        <div class="col-md-8 order-md-0">

            @foreach($regions as $region)

            <!-- Region Block -->
            <div class="block block-rounded">
                <div class="block-header block-header-default" style="background-image: url(/media/patterns/cubes.png)">

                    <h3 class="block-title d-flex justify-content-between align-items-center">{{str::title($region->name)}}
                        <span> 
                      {{$region->institutions->count() }} Schools 
                        </span>
                    </h3>


                </div>
                <div class="block-content">

                    <ul class="list-group list-group-flush">

                        @foreach( $region->states as $state )
                        <li class="list-group-item d-flex justify-content-between align-items-center p-1 mt-0">
                            <a href="
                              @if(!empty($category))
                              {{route('institutions.categories.location.show', ['category' => $category->slug, 'state' => $state->slug])}}
                              @else 
                              {{route('institutions.location.show', ['state' => $state->slug])}}
                              @endif

                               " class="fw-normal fs-normal">{{str::title($state->name)}} 
                            </a>


                            <a href="
                               @if(!empty($category))
                               {{route('institutions.categories.location.show', ['category' => $category->slug, 'state' => $state->slug])}}
                               @else 
                               {{route('institutions.location.show', ['state' => $state->slug])}}
                               @endif
                               " class="btn btn-light w-25 text-secondary"> 

                               <span class="badge rounded-pill bg-info">
                                  
                                {{$state->institutions->count()}} 
                                
                                </span> 
                                Schools
                              </a>
                        </li>
                        @endforeach
                    </ul>

                </div>
            </div>
            <!-- END Region Block -->
            @endforeach


        </div>
    </div>
</div>
<!-- END Page Content -->








@endsection