@extends('layouts.backend')

@section('content')
@php

use Carbon\Carbon;

@endphp


<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-7">
              <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">

				{{$exam->examBody->name}} ({{$exam->examBody->abbr}}) {{$exam->name}} Timetable {{$exam->year}}

              </h1>
              
			  <h3  class="fw-light text-white-75  mt-3">
					For {{$exam->type}} 
			 </h3>
			 
			 
               <div class="mt-3">
					<span class="badge rounded-pill bg-primary fs-base px-3 py-2 m-1">
						 <span itemprop="name"> 2nd May </span>
						
					</span>
					
					<span class="text-white">to</span>
				   
					<span class="badge rounded-pill bg-primary fs-base px-3 py-2 m-1">
						 25th June
					</span>
					
					<span class="text-white">{{$exam->year}}</span>
					
              </div>
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
              <h3 class="block-title"> {{$exam->name}} {{$exam->year}} Timetable For {{$exam->type}} 
</h3>
            </div>
            <div class="block-content">
			
			@foreach($groupedTimetables as $examDate => $timetables)
			
			
			@php
			$examDate =	Carbon::parse($examDate);

			@endphp
			
              <!-- Timetable -->
              <h2 class="content-heading text-primary">{{$examDate->format('l, jS F, Y')}} </h2>
              <div class="row items-push">
                <div class="col-lg-4">
				 
                 
                </div>
                <div class="col-lg-8">
                  
				  
				   <table class=" table table-vcenter">
               
                <tbody>
                  @foreach($timetables as $timetable)
				  
				  @php
				  $timetable->start_time = Carbon::parse($timetable->start_time);
				  $timetable->end_time = Carbon::parse($timetable->end_time);
				  
				  
				  $diffInMinutes =  $timetable->start_time->diffInMinutes($timetable->end_time);
				  $diffInHours =  intdiv($diffInMinutes, 60);
				  $remainingMinutes =  $diffInMinutes % 60;
				  
				  @endphp
				  
                  <tr>
                    
                    <td>
					  <p class=" mb-0">
                        <em class="fs-sm ">{{$timetable->paper_code}}</em>
                      </p>
                      <p class="fw-semibold mb-1">
                        {{$timetable->name}}
                      </p>
					  
					  @if(!empty($timetable->remarks))
					  <p class="mb-1">
                        {{$timetable->remarks}}
                      </p>
					  @endif
                      <p class=" mb-0">
					  {{$timetable->start_time->format('g:i A')}} - {{$timetable->end_time->format('g:i A')}} 
					  
					  (
					  @if($diffInHours > 0)
					  {{$diffInHours}}h 
					  @endif
					  
					  @if($remainingMinutes > 0)
					  {{$remainingMinutes}}m 
				      @endif
					  )
                      </p>
					  <p class="text-muted mb-0">
                        <em class="fs-sm text-muted">{{$examDate->format('M d, Y')}} </em>
                      </p>
					  
				  
                    </td>
					
                   
                  </tr>
                 @endforeach
                
                </tbody>
              </table>
				  
				  
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