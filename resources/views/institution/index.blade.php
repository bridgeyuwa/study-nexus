@extends('layouts.backend')


@section('content')
@php use Illuminate\Support\Str; @endphp


<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-7">
              <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">

                 @isset($category)
                    @if($category->id == 4) 
                        Colleges Of Education 
                     @else 
                        {{ Str::of($category->name)->plural()->title()}}
                      @endif
                 @else
                    Tertiary Institutions
                 @endisset in Nigeria

              </h1>
              
              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->




        <!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-content">

            <h2 class="content-heading text-center"> List of @isset($category) @if($category->id === 4)
                <span class="text-black"> Colleges of Education</span> @else
                <span class="text-black">{{ Str::of($category->name)->plural()->title()}} </span> @endif @else Academic Institutions of Higher Learning @endisset in Nigeria.</h2>
            <div class="row items-push">
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 100px;">
                        <p class="text-muted ">
                            A comprehensive list of accredited @isset($category) @if($category->id === 4)
                            <span class="text-black"> Colleges of Education</span> @else
                            <span class="text-black">{{ Str::of($category->name)->plural()->title()}} </span> @endif @else Institutions @endisset in Nigeria.
                        </p>

                        <p class="fs-sm">We provide comprehensive information about each of the schools as well as detailed insights into every course offered by these institutions. (eg. description, catchment areas, tuition fees, admission requirements, etc.)</p>

                    </div>
                </div>

                <div class="col-lg-8">

                    {{ $institutions->onEachSide(1)->links() }} @foreach($institutions as $institution)

                    <a href="{{route('institutions.show', ['institution' => $institution->id])}}" class="block block-rounded mb-3">
                      <div class="block block-header-default bg-image mb-0"
                          style="background-image: url('/media/photos/photo11.jpg');">
                          <div class="bg-black-75 text-center p-3">
                              <div class="fs-lg text-white mb-1">{{str::title($institution->name)}}
                               @if(!empty($institution->abbr))<span class="text-white-75 fw-light">({{str::upper($institution->abbr)}})</span> @endif 
                            </div>

                        @if(!empty($institution->former_name)) <div class="text-white mb-2 fs-5"> Former: <span class="text-white-75 fw-light">{{str::title($institution->former_name)}}</span> </div> @endif  
                              <div class="h6 fw-normal fs-sm text-white-75 mb-0">
                               {{str::title($institution->schooltype->name)}} 
                               {{str::title($institution->category->name)}}. 
                                    <i class="fa fa-map-marker-alt ms-2 me-1 text-primary"></i> 
                                @if(isset($institution->locality)) {{str::title($institution->locality)}}, @endif {{str::title($institution->lga->name)}} - @if($institution->state->id == 15) FCT @else {{str::title($institution->state->name)}} State @endif
                               </div>
                              
                          </div>
                      </div>
                    </a> @endforeach {{ $institutions->onEachSide(1)->links() }}

                </div>
            </div>
        </div>



    </div>
</div>

<!-- END Page Content -->


@endsection