@extends('layouts.backend')

@section('content')


<!-- Study Nexus Hero -->
     
        <div class="row px-4 mb-1 bg-white w-100 mx-auto pt-6 studynexus-bg-cubes" >

			<div class="col-md-6  d-none d-md-block">
				<br>
				<div class="d-flex justify-content-center align-content-center">  
					<img class="center-block " src="/media/photos/bg-406x612.png" alt="study nexus" style="width: 375px; height: 400px; object-fit: cover;"> 
				</div>
			</div>
          
			

			<div class="col-12 col-md-6">
				<div class="text-center d-block d-lg-none ">
				  <h1 class="display-1">Study<span class="text-info">Nexus</span>.<span class="text-success display-5">ng</span></h1>
				</div>
				<div class="text-left d-none d-lg-block ">
				  <h1 class="display-3">Study<span class="text-info">Nexus</span>.<span class="text-success display-6">ng</span></h1>
				</div>

				<p class="lead">Explore the premium source for higher education information in Nigeria.</p>
				<p>Delve into our extensive database containing over 600 programmes across 800+ higher institutions including Universities, Polytechnics/Monotechnics, Colleges of Education and other Institutions with 30,000+ Institution-Programme database entries. Uncover Institution Rankings and insights into Institution programmes in Nigeria. Streamline your search of our vast and comprehensive database by utilizing our multi-teir filtering and sorting system based on Location, Study Level, Programme, Category, and more .</p>
            

				<div class="d-flex justify-content-center pb-4">
					<a class="btn btn-hero btn-secondary rounded-0" href="{{url("#search")}}">Explore</a>     
				</div> 
 
			</div>
		</div>
<!-- END Study Nexus Hero -->


<!-- Search -->

  <!-- Hero -->
        <div id="search" class="bg-image studynexus-bg-hero" >
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-5 pb-0">
              <div class="pt-4 pb-3">
                
              <livewire:search-form fullSearch />

              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->


<!-- End Search -->


<!-- Facts -->
      <div class="d-flex justify-content-center align-items-center text-center py-5 bg-white-75" >
	  
              
              <div class="px-2 px-sm-5">
                <p class="fs-1 text-dark mb-0">{{\Illuminate\Support\Number::format($institutions->count())}}</p>
                <p class="text-muted mb-0">
                  Institutions
                </p>
              </div>
			      <div class="px-2 px-sm-5 border-start">
                <p class="fs-1 text-dark mb-0">{{\Illuminate\Support\Number::format($categoryClasses->count())}}</p>
                <p class="text-muted mb-0">
                 Categories
                </p>
              </div>
              <div class="px-2 px-sm-5 border-start">
                <p class="fs-1 text-dark mb-0">{{\Illuminate\Support\Number::format($programs->count())}}</p>
                <p class="text-muted mb-0">
                 Programmes
                </p>
              </div>
             
              <div class="px-2 px-sm-5 border-start">
                <p class="fs-1 text-dark mb-0">{{\Illuminate\Support\Number::format($levels->count())}}</p>
                <p class="text-muted mb-0">
                  Study Levels
                </p>
              </div>
            </div>
<!-- END Facts -->



      <!--  Grid Links -->
<div class="container">
    <div class="p-3 pb-1">
        <!--  Grid -->
        <div class="row text-center d-flex justify-content-around">




            <div class="col-6 col-md-3">
                <a class="block block-link-pop text-center bg-gray-dark studynexus-bg-concrete" href="{{route('news.index')}}" >
                    <div class="block-content block-content-full ratio ratio-4x3 ">
                        <div class="d-flex justify-content-center align-items-center">
                            <div>
                                <i class="text-white fa fa-3x fa-rss "></i>
                                <div class="fw-semibold mt-2 text-uppercase text-white">News</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a class="block block-link-pop text-center bg-gray-light studynexus-bg-concrete" href="{{route('forum')}}" >
                    <div class="block-content block-content-full ratio ratio-4x3 ">
                        <div class="d-flex justify-content-center align-items-center">
                            <div>
                                <i class="fa fa-3x  fa-comments"></i>
                                <div class="fw-semibold mt-2 text-uppercase">Forum</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a class="block block-link-pop text-center bg-gray studynexus-bg-concrete" href="#resources" >
                    <div class="block-content block-content-full ratio ratio-4x3 ">
                        <div class="d-flex justify-content-center align-items-center">
                            <div>
                                <i class=" fa fa-3x fa-file-alt"></i>
                                <div class="fw-semibold mt-2 text-uppercase">Exam Resources</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a class="block block-link-pop text-center bg-gray-darker studynexus-bg-concrete" href="#" >
                    <div class="block-content block-content-full ratio ratio-4x3 ">
                        <div class="d-flex justify-content-center align-items-center">
                            <div>
                                <i class="fa fa-3x fa-plane-departure text-white"></i>
                                <div class="fw-semibold mt-2 text-uppercase text-white">Study Abroad</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>


        </div>
        <!-- END Grid -->
    </div>
</div>
<!--  End Grid Links -->



<!-- Explore -->
<div class="container">
    <div class="p-3">
        <div class="row" data-masonry='{"percentPosition": true }'>
            <div class="col-md-6">
                <div class="block block-rounded">
                    <div class="block-header block-header-default text-white bg-gray-dark studynexus-bg-cubes" >
                        <h3 class="fw-light mb-1">Academic Programmes Library</h3>
                    </div>
                    <div class="block-content pb-2">
					  @foreach($levels as $level)
                        <p class="mb-2"><i class="fa fa-graduation-cap me-2"></i><a href="{{route('programs.index', ['level' => $level])}}">{{$level->name}} @if(!empty($level->abbr)) ({{$level->abbr}}) @endif</a></p>
						@endforeach
					 
					</div>

                </div>
            </div>


            <div class="col-md-6">
                <div class="block block-rounded">
                    <div class="block-header block-header-default text-white bg-gray-dark studynexus-bg-cubes">
                        <h3 class=" fw-light mb-1">Academic Institutions Library</h3>
                    </div>
                    <div class="block-content pb-2">
							
						@foreach($categoryClasses as $categoryClass)
							<p class="mb-2"><i class="fa fa-university me-2"></i><a href="{{route('institutions.categories.index', ['categoryClass' => $categoryClass])}}">{{$categoryClass->name_plural}}</a></p>
                        @endforeach
						
				
                    </div>
                    <div class="block-content block-content-full block-content-sm bg-body-light fs-sm">
                        <a class="btn btn-hero btn-alt-primary rounded-0 w-100" href="{{route('institutions.index')}}"> <i class="fa fa-fw fa-eye opacity-50 me-1"></i> View all Institutions</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="block block-rounded">
                    <div class="block-header block-header-default text-white bg-gray-dark studynexus-bg-cubes">
                        <h3 class="fw-light mb-1">Academic Institutions by Location</h3>
                    </div>
                    <div class="block-content pb-2">
						@foreach($categoryClasses as $categoryClass)
                        <p class="mb-2"><i class="fa fa-map-location-dot me-2"></i><a href="{{route('institutions.categories.location', ['categoryClass' => $categoryClass])}}">{{$categoryClass->name}} Locations</a></p>
                        @endforeach
                    </div>
                    <div class="block-content block-content-full block-content-sm bg-body-light fs-sm">
                        <a class="btn btn-hero btn-alt-primary rounded-0 w-100" href="{{route('institutions.location')}}"> <i class="fa fa-fw fa-eye opacity-50 me-1"></i> View All Locations</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="block block-rounded">
                    <div class="block-header block-header-default text-white bg-gray-dark studynexus-bg-cubes">
                        <h3 class="fw-light mb-1">Academic Institution Rankings</h3>
                    </div>
                    <div class="block-content pb-2">
						@foreach($categoryClasses as $categoryClass)
                        <p class="mb-2"><i class="si si-trophy me-2"></i><a href="{{route('institutions.categories.ranking', ['categoryClass' => $categoryClass])}}">{{$categoryClass->name}} Rankings</a></p>
                        @endforeach
                    </div>

                </div>
            </div>
			
			
			<div id="resources" class="col-md-6">
                <div class="block block-rounded">
                    <div class="block-header block-header-default text-white bg-gray-dark studynexus-bg-cubes">
                        <h3 class="fw-light mb-1">Exam Resources</h3>
                    </div>
                    <div class="block-content pb-2">
                        <p class="mb-2"><i class="si si-trophy me-2"></i><a href="#">#Post-UTME updates</a></p>
                        <p class="mb-2"><i class="si si-trophy me-2"></i><a href="{{route('syllabus.index')}}">Syllabuses <span class="text-dark fs-sm">(JAMB, WAEC, NECO, NABTEB etc...)</span></a></p>
                        <p class="mb-2"><i class="si si-trophy me-2"></i><a href="{{route('timetable.index')}}">Timetables <span class="text-dark fs-sm">(WAEC, NECO, NABTEB etc...)</span></a></p>
                        
                    </div>

                </div>
            </div>

        </div>
			
    </div>
    <!-- END md Grid -->

</div>
<!--  End Explore -->





@endsection