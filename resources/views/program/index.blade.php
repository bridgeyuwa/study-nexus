@extends('layouts.backend') 

@section('content')

@php use Illuminate\Support\Str;  @endphp




<!-- Hero -->
<div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
    <div class="bg-black-75">
        <div class="content content-full content-top text-center pt-7">
            <div class="row">
                <div class="col-md-8 pt-4 pb-3">
                    <h1 class="fw-light text-white mb-1">{{str::title($level->name)}} Programs</h1>
                </div>

                <div class="col-md-4 d-flex align-items-center">
                    <div class="block block-rounded block-transparent bg-black-50 text-center mb-0 mx-auto">
                        <div class="block-content block-content-full px-4 py-4">
                            
                            <div class="fs-2 fw-semibold text-white">
                          @php  
                               $min_tuition = $level->programs->min('pivot.tuition_fee');
                               $max_tuition = $level->programs->max('pivot.tuition_fee');
                          @endphp




                               @if(isset($min_tuition)) 
                         @if($min_tuition == $max_tuition)
                                 @if($min_tuition >= 1010000) 
                                 ₦ {{Number::abbreviate($min_tuition, precision: 2)}}  
                                 @else 
                                 ₦ {{Number::abbreviate($min_tuition)}} 
                                 @endif
                         @else 
                                 @if($min_tuition >= 1010000) 
                                  ₦ {{Number::abbreviate($min_tuition, precision: 2)}} 
                                  @else 
                                  ₦ {{Number::abbreviate($min_tuition)}} 
                                 @endif

                                   <span class="fw-semibold">-</span> 

                                @if($max_tuition >= 1010000)   
                                   ₦ {{Number::abbreviate($max_tuition, precision: 2)}} 
                                @else 
                                   ₦ {{Number::abbreviate($max_tuition)}} 
                                @endif
                        @endif 
                                 
                  @endif


                            </div>
                            <div class="fs-sm fw-semibold text-uppercase text-white-50 mt-1 push">Annual Tuition</div>
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- END Hero -->


<!-- Page Content -->
<div  class="content">
    <div class="block block-rounded">

        <div itemscope itemtype="https://schema.org/OfferCatalog" class="block-content">
        <link itemprop="url" content="{{url()->current()}}" />

            <h2 itemprop="name"class="content-heading text-center">Accredited {{str::title($level->name)}} Courses Offered in Nigeria </h2>
            <div class="row items-push">
                <div class="col-lg-4">
                    <p class="text-muted sticky-top" style="top: 100px;">
                        Explore the official list of accredited <span class="text-black-75">{{str::title($level->name)}}</span> courses grouped by their various disciplines offered in various Nigerian Institutions of higher learning.
                    </p>

                </div>

                <div class="col-lg-8">
                    <div id="programs" role="tablist" aria-multiselectable="true">

                        @foreach($colleges as $collegeName => $programs)
                        <div itemprop="itemListElement" itemscope itemtype="https://schema.org/OfferCatalog" class="block block-rounded mb-1">
                            <a class="fw-semibold fs-lg link-primary" data-bs-toggle="collapse" data-bs-parent="#programs" href="#programs_q{{$loop->iteration}}" aria-expanded="false" aria-controls="programs_q{{$loop->iteration}}">
                               <div class="block-header block-header-default fs-5" role="tab" id="programs_h{{$loop->iteration}}">
                                   <div itemprop="name">{{str::title($collegeName)}} <span class="text-black fs-6 fw-normal">({{count($programs)}}) </span></div>   <span class="toggle-icon fw-light fs-2"> </span>
                               </div>
                            </a>
                            <div id="programs_q{{$loop->iteration}}" class="collapse" role="tabpanel" aria-labelledby="programs_h{{$loop->iteration}}" data-bs-parent="#programs">
                                <div class="block-content">

                                    @foreach($programs as $program)
                                    <div itemprop="itemListElement" itemscope itemtype="https://schema.org/OfferCatalog" class="block block-rounded mb-1">
                                        <a itemscope itemtype="https://schema.org/EducationalOccupationalProgram" class="fw-normal " href="{{route('programs.show', ['level' => $level->slug, 'program' => $program->id])}}" >
											<div class="block-header block-header-default fs-6">
											<span itemprop="name">  {{Str::title($program->name)}} </span>
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


