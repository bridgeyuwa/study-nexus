@extends('layouts.backend') 

@section('content')

@php use Illuminate\Support\Str;  @endphp




<!-- Hero -->
<div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
    <div class="bg-black-75">
        <div class="content content-full content-top text-center pt-7">
           
                <div class=" pt-4 pb-3">
                    <h1 class="fw-light text-white mb-1">{{$level->name}} Programmes</h1>
                </div>

                
        </div>
    </div>
</div>
<!-- END Hero -->

<!-- Breadcrumbs -->
		  {{Breadcrumbs::render()}}
		 <!-- End Breadcrumbs -->

<!-- Page Content -->
<div  class="content">

	<div class="col-md-12 order-md-1">

            <!-- nav -->
            <div class="block block-rounded">
			
                
                    <ul class="nav nav-tabs nav-tabs-block bg-gray-lighter">
					@foreach($program_levels as $program_level)
						
                  <li class="nav-item">
                    <a href="{{route('programs.index', $program_level)}}"><button
					@if(
					route('programs.index', ['level' => $program_level] ) == url()->current()
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

        <div itemscope itemtype="https://schema.org/OfferCatalog" class="block-content">
        <link itemprop="url" content="{{url()->current()}}" />

            <h2 itemprop="name"class="content-heading text-center">Accredited {{$level->name}} Programmes Offered in Nigeria </h2>
            <div class="row items-push">
                <div class="col-lg-4">
                    <p class="text-muted sticky-top" style="top: 100px;">
                        Explore the official list of accredited <span class="text-black-75">{{$level->name}}</span> programmes grouped by their various disciplines offered in various Nigerian Institutions of higher learning.
                    </p>

                </div>

                <div class="col-lg-8">
                    <div id="programs" role="tablist" aria-multiselectable="true">

                        @foreach($programs as $collegeName => $programs)
                        <div itemprop="itemListElement" itemscope itemtype="https://schema.org/OfferCatalog" class="block block-rounded mb-1">
                            <a class="fw-semibold fs-lg link-primary" data-bs-toggle="collapse" data-bs-parent="#programs" href="#programs_q{{$loop->iteration}}" aria-expanded="false" aria-controls="programs_q{{$loop->iteration}}">
                               <div class="block-header block-header-default fs-5" role="tab" id="programs_h{{$loop->iteration}}">
                                   <div itemprop="name">{{$collegeName}}</div>    <div><span class="text-black fs-sm me-3 ">{{$programs->count()}} </span><span class="toggle-icon fw-light fs-2"> </span> </div>
                               </div>
                            </a>
                            <div id="programs_q{{$loop->iteration}}" class="collapse" role="tabpanel" aria-labelledby="programs_h{{$loop->iteration}}" data-bs-parent="#programs">
                                <div class="block-content">
							
							
                                    @foreach($programs as $program)
                                    <div itemprop="itemListElement" itemscope itemtype="https://schema.org/OfferCatalog" class="block block-rounded mb-1">
                                        <a itemscope itemtype="https://schema.org/EducationalOccupationalProgram" class="fw-normal " href="{{route('programs.show', ['level' => $level, 'program' => $program])}}" >
											<div class="block-header block-header-default fs-6">
											<span itemprop="name">  {{$program->name}} </span>
											</div>
										</a>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- END Introduction -->

        </div>
    </div>
</div>

<!-- END Page Content -->

@endsection


