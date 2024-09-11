@extends('layouts.backend') 

@section('content')

<!-- Hero -->
<div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
    <div class="bg-black-75">
        <div class="content content-full content-top text-center pt-7">
            <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">Catchment Area Policy</h1>

            </div>
        </div>
    </div>
	
	<div class="d-flex justify-content-end py-1">		
		     <!-- Social Actions -->
				
				<div class="btn-group me-1" role="group">
					<button type="button" class="btn btn-sm btn-alt-primary dropdown-toggle" id="dropdown-blog-news" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-share-alt opacity-50 me-1"></i> Share
					</button>
					<div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="dropdown-blog-news">
						@foreach ($shareLinks as $platform => $link)
							<a class="dropdown-item" href="{{ $link }}" onclick="window.open(this.href, '_blank', 'width=700, height=525, left=250, top=200'); return false;">
								<i class="fab fa-fw fa-{{ $platform }} text-{{ $platform }}  me-1"></i> {{ ucfirst($platform) }}
							</a>
						@endforeach
					</div>
				</div>
			
			<!-- END Social Actions -->	 
			</div>
	
</div>
<!-- END Hero -->

	<!-- Breadcrumbs -->
		  {{Breadcrumbs::render()}}
	<!-- End Breadcrumbs -->

<!-- Page Content -->
<div class="content content-boxed">

    <div class="block block-rounded">
    
	<div class=" p-4 rounded-3 shadow-sm">
            <h1 class="fw-bold text-primary-dark mb-4">Catchment Area Policy for Nigerian Higher Education Institutions</h1>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">Introduction</h2>
                    <p>The catchment area policy is a significant aspect of the admission process in Nigerian higher education institutions. This policy is designed to ensure that students from certain regions, known as the "catchment areas," are given preference during the admissions process. This page outlines the key aspects of the catchment area policy, how it affects admissions, and what prospective students need to know.</p>
            </section>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">What is a Catchment Area?</h2>
                    <p>A catchment area refers to specific states or regions that are geographically or historically connected to a particular university. For federal universities, these areas are predetermined and play a crucial role in the admissions process.</p>
                
            </section>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">Purpose of the Catchment Area Policy</h2>
                    <ul>
                        <li>Promote regional inclusivity by giving students from specific regions better access to higher education.</li>
                        <li>Ensure a fair distribution of educational opportunities across different parts of the country.</li>
                        <li>Encourage educational development within regions that are traditionally underserved.</li>
                    </ul>
			</section>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">How the Catchment Area Policy Affects Admissions</h2>
                    <p>During the admission process, universities may:</p>
                    <ul>
                        <li>Lower the cut-off marks for candidates from the catchment area, making it easier for them to gain admission.</li>
                        <li>Reserve a certain percentage of admissions for students from the catchment area, in line with the federal or state quota system.</li>
                    </ul>
			</section>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">Catchment Areas for Federal Universities</h2>
                    <p>Each federal university in Nigeria has a designated catchment area. These areas are usually composed of states that are geographically close to the university. For example:</p>
                    <ul>
                        <li><strong class="">University of Lagos (UNILAG):</strong> Lagos, Ogun, Oyo, Ekiti, Osun, Ondo.</li>
                        <li><strong class="">University of Ibadan (UI):</strong> Oyo, Lagos, Osun, Ondo, Ekiti.</li>
                        <li><strong class="">Ahmadu Bello University (ABU):</strong> Kaduna, Kano, Katsina, Sokoto, Zamfara, Kebbi.</li>
                    </ul>
				<p style="line-height: 1.85;"> Check the list of <a href="{{route('institutions.catchments.index')}}" class="btn btn-sm btn-primary">catchment areas</a>  to see Federal Universities associated with each state.  
				<br>  Alternatively, visit individual <a href="{{route('search', [ 'category' => '1', 'type' => 'federal'])}}" class="btn btn-sm btn-primary">Federal Universities</a> pages to view their specific catchment areas. </p>
					
            </section>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">Catchment Areas for State Universities</h2>
                    <p>State universities typically consider the entire state where the university is located as the catchment area. This means that indigenes of the state are often given priority during admissions.</p>
            </section>
			
			<section class="mb-4">
				<h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">Catchment Areas for Private Universities</h2>
				<p>Private universities in Nigeria do not typically follow the catchment area policy. Unlike federal and state universities, private institutions admit students based solely on merit without giving preference to candidates from any specific region or state. Admission criteria for private universities are usually uniform across all candidates, regardless of their geographical location.</p>
			</section>
			
			<section class="mb-4">
				<h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">Catchment Areas for Polytechnics and Colleges of Education</h2>
				<p>Polytechnics and colleges of education in Nigeria also apply the catchment area policy similar to federal and state universities. While there isn't a widely published list of specific catchment areas for each polytechnic or college of education, the general principle is that these institutions give preference to candidates from neighboring states or regions.</p>
				<p><strong class="text-primary-dark">What You Need to Know:</strong></p>
				<ul>
					<li><strong class="text-primary-dark">General Principle:</strong> Most polytechnics and colleges of education give admission priority to students from states within their geographical region.</li>
					<li><strong class="text-primary-dark">No Formal List:</strong> Unlike federal universities, there's no formal, widely available list of catchment areas for polytechnics and colleges of education.</li>
					<li><strong class="text-primary-dark">Check with Institutions:</strong> Prospective students are advised to check directly with their chosen institution for specific catchment area details.</li>
				</ul>
			</section>

            <section class="mb-4">
                <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">Admission Categories</h2>
                    <p>The catchment area policy works in tandem with the following admission categories:</p>
                    <ul>
                        <li><strong class="text-primary-dark">Merit:</strong> A percentage of admissions is based purely on merit, without consideration of the candidate's state of origin.</li>
                        <li><strong class="text-primary-dark">Catchment Area:</strong> A significant percentage of admissions is reserved for candidates from the catchment area.</li>
                        <li><strong class="text-primary-dark">Educationally Less Developed States (ELDS):</strong> Some slots are reserved for candidates from states identified as educationally less developed, to promote equal educational opportunities.</li>
                    </ul>
            </section>
			
			<section class="mb-4">
                    <h2 class="h3 text-primary-dark border-bottom pb-2 mb-3">How to Determine Your Catchment Area</h2>
                    <p>Prospective students can determine if they are within a university's catchment area by:</p>
                    <ul>
                        <li>Checking the list of designated states for each federal university.</li>
                        <li>Understanding the policies of state universities regarding their admission preferences.</li>
                    </ul>
            </section>
	
        </div>
	
	
	</div>
	
</div>
<!-- END Page Content -->

@endsection