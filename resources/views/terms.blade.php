@extends('layouts.backend') 

@section('content')

<!-- Hero -->
<div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
    <div class="bg-black-75">
        <div class="content content-full content-top text-center pt-7">
            <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">Terms of Service</h1>

            </div>
        </div>
    </div>
</div>
<!-- END Hero -->


<!-- Page Content -->
<div class="content content-boxed">
   <div class="block block-rounded">
                          

             <div class="p-4 "> {!! $terms !!} </div>
 
   </div>

</div>
<!-- END Page Content -->

@endsection