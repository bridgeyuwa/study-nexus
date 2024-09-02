@extends('layouts.backend')

@section('content')

@php

use Carbon\Carbon;

@endphp


<!-- Hero  -->
        <div itemscope itemtype="https://schema.org/EducationalOrganization" class="bg-image bg-studynexus-hero" >
          <div class="bg-black-75">
            <div class="content content-boxed content-full pt-7">
              <div class="row">
			    @if(!empty($exam->examBody->logo))
				
			    <div class="col-md-2 d-flex align-items-center">
                  <div class="block block-rounded  block-transparent bg-black-50 text-center mb-0 mx-auto" style="box-shadow:0 0 2.25rem #d1d8ea;opacity:1">
                    <div class="block-content block-content-full px-1 py-1">
					
                      <img  src="{{$exam->examBody->logo}}" alt="{{$exam->examBody->name}} logo"  style="width: 100px; height: 100px; object-fit: cover;">
                      <link itemprop="logo" href="{{$exam->examBody->logo}}">
                    </div>
                  </div>
                </div>
				@endif
				
                <div class=" @if(!empty($exam->examBody->logo)) col-md-10 @endif d-flex align-items-center pt-3">
					<div class="w-100 text-center @if(!empty($exam->examBody->logo)) text-md-start @endif">
						<div class="h3 fw-light text-white mb-1 "> 
						<span itemprop="name">{{$exam->examBody->name}}</span> 
						@if(!empty($exam->examBody->abbr))
							(<span itemprop="alternateName" class="text-white-75">{{$exam->examBody->abbr}}</span>)
						@endif 
						</div>
                          
						  <link itemprop="url" href="{{url()->current()}}">
						  <link itemprop="sameAs" href="{{$exam->examBody->url}}">
						  
						<div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress" class="h4 fs-sm  fw-light text-white-75 mb-1">
							<div itemprop="streetAddress"> {{$exam->examBody->address}} </div>
							@if(!empty($exam->examBody->locality)) <span itemprop="addressLocality">{{$exam->examBody->locality}} </span>- @endif  <span itemprop="addressRegion">{{$exam->examBody->state->name}} @if(!empty($exam->examBody->state->is_state)) State @endif </span> 
						  @if(!empty($exam->examBody->postal_code)) <meta itemprop="postalCode" content="{{$exam->examBody->postal_code}}"> @endif
							<meta itemprop="addressCountry" content="NG">
							<div> Nigeria </div>
						
						</div>
						
						<h1  class="h3 fw-light text-white mt-3">
					       {{$exam->name}} TIMETABLE
						</h1>
						
						<div class="mt-3">
							<span class="badge rounded-pill bg-dark fs-base px-3 py-2 m-1">
								 <span itemprop="name"> {{$exam->timetables->min('exam_date')->format('jS M')}} </span>
							</span>
							
							<span class="text-white">to</span>
						   
							<span class="badge rounded-pill bg-dark fs-base px-3 py-2 m-1">
								{{$exam->timetables->max('exam_date')->format('jS M')}}
							</span>
							
							<span class="text-white">{{$exam->year}}</span>
						</div>
						
					</div>
					 			
                </div>
              </div>
            </div>
          </div>
		  
        </div>
        <!-- END Hero -->

		<!-- Breadcrumbs -->
		  {{Breadcrumbs::render()}}
		 <!-- End Breadcrumbs -->



<!-- Page Content -->
        <div itemscope itemtype="https://schema.org/ItemList" class="content">
			<meta itemprop="name" content="{{$exam->name}}">  
			<link itemprop="url" href="{{url()->current()}}" >
			<link itemprop="sameAs" href="{{$exam->timetable_url}}" />  
          <!-- Frequently Asked Questions -->
          <div class="block block-rounded">
            <div class="block-header block-header-default">
              <h3 class="block-title"> Timetable </h3>
			  
			</div>
			
            <div class="block-content">
			
			@foreach($groupedTimetables as $examDate => $timetables)
			
			
			@php
			$examDate =	Carbon::parse($examDate);
			
			if($examDate->isToday()){
				$dateClass = "text-success";
			}elseif($examDate->startOfDay()->isBefore(Carbon::today()->startOfDay())){
				$dateClass = "text-danger";
			}else{
				$dateClass = "text-primary";
			}
			
			
			if($examDate->isYesterday()){
				$day = "(Yesterday)";
			} 
			elseif($examDate->isTomorrow()){
				$day = "(Tomorrow)";
			}
			elseif($examDate->isToday()){
				$day = "(Today)";
			}
			else{
				$day ="";
			}
			

			@endphp
			
			
			
			
              <!-- Timetable -->
              <h2 class="content-heading {{$dateClass}}"> <i class="fas fa-calendar-day"></i> {{$examDate->format('l, jS F, Y')}} {{$day}}</h2>
              <div class="row items-push">
                <div class="col-lg-4">
				(<em>{{$exam->remarks}}</em>)
                 
                </div>
                <div class="col-lg-8">
                  
				  
				   <table class=" table table-vcenter">
               
                <tbody>
                  @foreach($timetables as $timetable)
				  
				  
				  @php
				  $diffInMinutes =  $timetable->start_time->diffInMinutes($timetable->end_time);
				  $diffInHours =  intdiv($diffInMinutes, 60);
				  $remainingMinutes =  $diffInMinutes % 60;
				  
				 
					$metaDuration ="PT";
					if($diffInHours > 0){
						$metaDuration .= $diffInHours ."H";
					}
					  
					if($remainingMinutes > 0){  
						$metaDuration .= $remainingMinutes ."M";
				    }
				  
				  @endphp
				  
				  
				  
				 
                  <tr itemprop="itemListElement" itemscope itemtype="https://schema.org/EducationEvent">
                    
                    <td>
					  <p class="mb-0">
                       <em itemprop="identifier" class="fs-sm ">{{$timetable->paper_code}}</em>
                      </p>
                      <p itemprop="name"  class="fw-semibold mb-1">
                        {{$timetable->name}}
                      </p>
					
						
						<p class="text-muted mb-0">
							<em class="fs-sm text-muted">{{$examDate->format('M d, Y')}} </em>
						</p>
						
						<p class="mb-0">
							{{$timetable->start_time->format('g:i A')}} - {{$timetable->end_time->format('g:i A')}} 
							 ({{$timetable->start_time->diff($timetable->end_time)}})
						</p>
						
						@if(!empty($timetable->remarks))
						<p class="mb-1">
							{{$timetable->remarks}}
						</p>
						@endif
					
					
						@if( Carbon::now()->isBefore($timetable->start_time))
							<span class="text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="This exam is upcoming"> <i class="fas fa-calendar"></i> Upcoming </span> ({{$timetable->start_time->diffForHumans()}})
						
						@elseif( Carbon::now()->isBetween($timetable->start_time, $timetable->end_time ))
							<span class="text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="This exam in currently ongoing"> <i class="fas fa-circle-play"></i> Ongoing </span> 
						
						@else
							<span class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="This exam has already passed"> <i class="fas fa-calendar-xmark "></i> Past </span> ({{$timetable->end_time->diffForHumans()}})
						
					     @endif
						  
						<link itemprop="url" href="{{url()->current()}}" >
						<link itemprop="sameAs" href="{{$exam->timetable_url}}" />
						<link itemprop="image" href="{{$exam->examBody->logo}}" />
						<meta itemprop="educationalLevel" content="{{$exam->type}}" />
						<meta itemprop="location" content="Candidate's Examination Center" />
						<meta itemprop="startDate" content="{{$timetable->start_time->toIso8601String()}}" />
						<meta itemprop="endDate" content="{{$timetable->end_time->toIso8601String()}}" />
						<meta itemprop="duration" content="{{$metaDuration}}" />
						<meta itemprop="doorTime" content="{{$timetable->start_time->subMinutes(30)->toIso8601String()}}" />
						
						<div itemprop="organizer" itemscope itemtype="https://schema.org/EducationalOrganization">
							<meta itemprop="name" content="{{$exam->examBody->name}}" />
							<meta itemprop="alternateName" content="{{$exam->examBody->abbr}}" />
							<link itemprop="url" href="{{$exam->examBody->url}}" />
							<link itemprop="sameAs" href="{{$exam->examBody->url}}" />
						</div>
					
						
					
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