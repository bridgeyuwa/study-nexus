@extends('layouts.backend') 

@section('content')

<!-- Hero -->
<div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
    <div class="bg-black-75">
        <div class="content content-full content-top text-center pt-7">
            <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">About Us</h1>
            </div>
        </div>
    </div>
</div>
<!-- END Hero -->

<!-- Breadcrumbs -->
{{Breadcrumbs::render()}}
<!-- End Breadcrumbs -->

<!-- Page Content -->
<div class="content content-boxed bg-white">
    <div class="container my-5 pb-5">
        <div class="text-center mb-5 pt-4">
            <h1 class="display-6 fw-bold text-primary-dark">About Study Nexus</h1>
            <p class="lead">Your Gateway to Comprehensive Academic Opportunities</p>
        </div>

        <div class="mb-5">
            <h2 class="fw-bold text-primary-dark">Welcome to Study Nexus</h2>
            <p class="">The premier platform designed to connect students with a wide range of educational opportunities. Whether you’re seeking admission to universities, polytechnics, monotechnics, or colleges of education at various levels, exploring exam syllabi, or staying up-to-date with education news, Study Nexus is here to guide you.</p>
        </div>

        <div class="card border-0 shadow-sm mb-5 bg-white-75">
            <div class="card-body p-4">
                <h2 class="fw-bold text-primary">Our Mission</h2>
                <p class="">At Study Nexus, our mission is to empower students by providing accurate, current information about educational institutions, programmes, exam syllabi, timetables, and more. We are dedicated to offering a comprehensive resource that supports students in making informed decisions about their higher education and future careers.</p>
            </div>
        </div>

       
	   
	   
	   
	   <div class="card border-0 shadow-sm mb-5 bg-white-75">
    <div class="card-body p-4">
        <h2 class="fw-bold text-primary">What We Offer</h2>
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <i class="fa fa-info-circle me-2 text-primary"></i><strong class="text-primary-dark">Detailed Programme Information:</strong> Access in-depth details about programmes, including curriculum structure, duration, and admission criteria.
                    </li>
                    <li class="list-group-item">
                        <i class="fa fa-search me-2 text-primary"></i><strong class="text-primary-dark">Faceted Search:</strong> Filter institutions and programmes by location, level of study, programme type, and more.
                    </li>
                    <li class="list-group-item">
                        <i class="fa fa-sort-alpha-down me-2 text-primary"></i><strong class="text-primary-dark">Sorting Options:</strong> Customize your search results by rank, alphabetical order, and other criteria.
                    </li>
					<li class="list-group-item">
                        <i class="fa fa-newspaper me-2 text-primary"></i><strong class="text-primary-dark">News & Updates:</strong> Stay informed with the latest news and updates related to education.
                    </li>
                    <li class="list-group-item">
                        <i class="fa fa-award me-2 text-primary"></i><strong class="text-primary-dark">Scholarship Opportunities:</strong> Find scholarships for Nigerian students locally and abroad.
                    </li>
                    <li class="list-group-item">
                        <i class="fa fa-medal me-2 text-primary"></i><strong class="text-primary-dark">Institution Rankings:</strong> Browse rankings by category, including universities, polytechnics, and colleges of education.
                    </li>
                </ul>
            </div>
            <div class="col-lg-6">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <i class="fa fa-calendar me-2 text-primary"></i><strong class="text-primary-dark">Exam Timetables:</strong> View and plan around official timetables for WAEC, NECO, NABTEB, and other national exams.
                    </li>
                    <li class="list-group-item">
                        <i class="fa fa-file-lines me-2 text-primary"></i><strong class="text-primary-dark">Syllabi:</strong> Access official syllabi for key exams like JAMB, WAEC, NECO, and NABTEB.
                    </li>
                    <li class="list-group-item">
                        <i class="fa fa-globe me-2 text-primary"></i><strong class="text-primary-dark">Study Abroad Programmes:</strong> Explore international study options to broaden your educational experience.
                    </li>
                    <li class="list-group-item">
                        <i class="fa fa-map me-2 text-primary"></i><strong class="text-primary-dark">Catchment Areas:</strong> Find out which institutions have specific states as their catchment areas.
                    </li>
                    <li class="list-group-item">
                        <i class="fa fa-comments me-2 text-primary"></i><strong class="text-primary-dark">Forum:</strong> Join discussions and connect with other students and educators in our vibrant community forum.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

	   
	   
	   
	   
	   
	   
	   
	   

        <div class="card border-0 shadow-sm mb-5 bg-white-75">
            <div class="card-body p-4">
                <h2 class="fw-bold text-primary">Our Commitment to Accuracy</h2>
                <p class="">We strive to provide the most accurate and up-to-date information by sourcing data from official school websites, government databases, and direct communications with educational institutions. Our goal is to ensure that you have the most reliable information at your fingertips.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-5 bg-white-75">
            <div class="card-body p-4">
                <h2 class="fw-bold text-primary">How to Use Study Nexus</h2>
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class="fa fa-search me-2 text-primary"></i><strong class="text-primary-dark">Search Tool:</strong> Use our <a href="/search" class="text-decoration-none text-primary">search tool</a> to find educational opportunities that fit your criteria.
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-funnel me-2 text-primary"></i><strong class="text-primary-dark">Filter Options:</strong> Apply multiple filters to narrow down your search results effectively.
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class="fa fa-list-check me-2 text-primary"></i><strong class="text-primary-dark">Detailed Listings:</strong> Review detailed descriptions of programmes and institutions to make well-informed decisions.
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-arrow-repeat me-2 text-primary"></i><strong class="text-primary-dark">Clear Navigation:</strong> Enjoy a seamless browsing experience with our clear and concise navigation structure.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <h2 class="fw-bold text-primary">Join the Study Nexus Community</h2>
            <p class="mb-4">Explore the wealth of resources available on Study Nexus and take control of your academic journey. Our platform is designed to help you find institutions, programmes and resources that best suit your educational and career goals.</p>
            <a href="{{route('search')}}" class="btn btn-lg btn-primary"><i class="fa fa-search me-1"></i> Search Now</a>
        </div>
    </div>
</div>
<!-- END Page Content -->

@endsection
