@extends('layouts.backend')


@section('content')
<!-- Hero -->
        <div class="bg-image studynexus-bg-hero">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-5">
              <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">Contact</h1>

              
              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->



<div class="content d-flex justify-content-center">
                  
                  <div class="col col-md-8 mb-3">
                    <div> <livewire:contact-form /> </div>
                  </div>
           
</div>


@endsection