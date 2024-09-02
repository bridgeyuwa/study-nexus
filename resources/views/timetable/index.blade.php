@extends('layouts.backend')

@section('content')
<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-7">
              <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">

                 Timetables

              </h1>
              
              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->

		<!-- Breadcrumbs -->
		  {{Breadcrumbs::render()}}
		 <!-- End Breadcrumbs -->


		<!-- Page Content -->
        <div  itemscope itemtype="https://schema.org/ItemList" class="content">
          
          <div class="block block-rounded">
            <div class="block-header block-header-default">
              <h3 itemprop="name" class="block-title">Timetables</h3>
            </div>
			<meta itemprop="description" content="Find the latest timetables for all major exams like WAEC, NECO, NABTEB, etc...." />
			<link itemprop="url" href="{{url()->current()}}" />
  
			
            <div class="block-content ">
			
			@foreach($examBodies as $examBody)
              <!-- Timetable -->
			  <div itemprop="itemListElement" itemscope itemtype="https://schema.org/EducationalOrganization">
				<h2 class="content-heading"> 
				@if(!empty($examBody->logo)) <img  src="{{$examBody->logo}}" alt="{{$examBody->name}} logo"  style="width: 40px; height: 40px; object-fit: cover;"> @endif
					<span itemprop="name">{{$examBody->name}}</span>  <span itemprop="alternateName"> ({{$examBody->abbr}})</span>
				</h2>
              <div class="row items-push">
                <div class="col-lg-4">
				     
				
                    <p itemprop="description" class="text-muted">
						{{$examBody->description}}
                    </p>
                </div>
				<link itemprop="sameAs" href="{{$examBody->url}}" />
				
                <div hasOfferCatalog" itemscope itemtype="https://schema.org/OfferCatalog" class="col-lg-8">
					<meta itemprop="name" content="{{$examBody->name}} Examination Timetables">
							
                    <div id="{{$examBody->abbr}}" role="tablist" aria-multiselectable="true">
				  
					    @foreach($examBody->exams as $exam)
						<div itemprop="itemListElement"  class="block block-rounded mb-1">
							<a class="fw-semibold" data-bs-toggle="collapse" data-bs-parent="#{{$examBody->abbr}}" href="#{{$examBody->abbr}}_q{{$loop->iteration}}" aria-expanded="true" aria-controls="{{$examBody->abbr}}_q{{$loop->iteration}}">
								  <div class="block-header block-header-default" role="tab" id="{{$examBody->abbr}}_h{{$loop->iteration}}">
								 <span itemprop="name">  {{$exam->name}} -  Timetable </span>
								 <link itemprop="url" href="{{route('timetable.show', ['exam' => $exam] )}}" />
								
								  </div>
							</a>
							
							<div id="{{$examBody->abbr}}_q{{$loop->iteration}}" class="collapse" role="tabpanel" aria-labelledby="{{$examBody->abbr}}_h{{$loop->iteration}}" data-bs-parent="#{{$examBody->abbr}}">
								<div class="block-content">
									<p itemprop="description"> {{$exam->description}}</p>
									<a class="btn btn-primary" href="{{route('timetable.show', ['exam' => $exam] )}}"> <i class="fa fa-fw fa-eye opacity-50 me-1"></i> View Timetable</a>
								</div>
							</div>
						</div>
						
						@endforeach
				
					</div>
                </div>
              </div>
			  </div>
              <!-- END Timetable -->

              @endforeach

              
            </div>
          </div>
         
        </div>
        <!-- END Page Content -->




@endsection