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




		<!-- Page Content -->
        <div class="content">
          <!-- Frequently Asked Questions -->
          <div class="block block-rounded">
            <div class="block-header block-header-default">
              <h3 class="block-title">Timetables</h3>
            </div>
            <div class="block-content">
			
			@foreach($examBodies as $examBody)
              <!-- Timetable -->
              <h2 class="content-heading">{{$examBody->name}} ({{$examBody->abbr}})</h2>
              <div class="row items-push">
                <div class="col-lg-4">
                  <p class="text-muted">
				  
				  {{$examBody->description}}
                   </p>
                </div>
                <div class="col-lg-8">
                  <div id="{{$examBody->abbr}}" role="tablist" aria-multiselectable="true">
				  
				  @foreach($examBody->exams as $exam)
                    <div class="block block-rounded mb-1">
						 <a class="fw-semibold" data-bs-toggle="collapse" data-bs-parent="#{{$examBody->abbr}}" href="#{{$examBody->abbr}}_q{{$loop->iteration}}" aria-expanded="true" aria-controls="{{$examBody->abbr}}_q{{$loop->iteration}}">
							  <div class="block-header block-header-default" role="tab" id="{{$examBody->abbr}}_h{{$loop->iteration}}">
							   {{$exam->name}} - {{$exam->type}} {{$exam->year}}
							  </div>
						  </a>
                      <div id="{{$examBody->abbr}}_q{{$loop->iteration}}" class="collapse" role="tabpanel" aria-labelledby="{{$examBody->abbr}}_h{{$loop->iteration}}" data-bs-parent="#{{$examBody->abbr}}">
                        <div class="block-content">
                          <p> {{$exam->description}}</p>
						  
                        <a class="btn btn-info rounded-0 " href="{{route('timetable.show', ['exam' => $exam] )}}"> <i class="fa fa-fw fa-eye opacity-50 me-1"></i> View Timetable</a>
                    
						  
                        </div>
                      </div>
                    </div>
                    
					
					@endforeach
					
					
					
                  </div>
                </div>
              </div>
              <!-- END Timetable -->

              @endforeach

              
            </div>
          </div>
          <!-- END Frequently Asked Questions -->
        </div>
        <!-- END Page Content -->




@endsection