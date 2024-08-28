@extends('layouts.backend')


@section('content')
<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-7">
              <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">

                {{$examBody->abbr}} Syllabus for {{$syllabus->subject->name}}
             </h1>
              
              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->



	<div class="content content-boxed ">

			<p class="bg-white p-3 "> {{$syllabus->description}}It appear you don't have a PDF Plugin for this browser.  instead </p>
				
		

			<object data="{{$syllabus->url}}" type="application/pdf" width="100%" height="500px" >
				<p class="bg-white p-3 text-center"> It appear you don't have a PDF Plugin for this browser. <a class="btn btn-primary" href="{{$syllabus->url}}" download> Download the {{$examBody->abbr}} Syllabus for {{$syllabus->subject->name}} </a> instead
				
				
			</object>




	</div>

@endsection