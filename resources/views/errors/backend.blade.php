<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" >
  <meta  name ="robots" content="noindex">
  
  <!-- Icons -->
  <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
  <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">

  <!-- Fonts and Styles -->
  @yield('css_before')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" id="css-main" href="{{ asset('css/dashmix.css') }}">

  <!-- You can include a specific file from public/css/themes/ folder to alter the default color theme of the template. eg: -->
  <!-- <link rel="stylesheet" id="css-theme" href="{{ asset('css/themes/xwork.css') }}"> -->
  @yield('css_after')
   <link rel="stylesheet"  href="{{ asset('css/custom.css') }}">

  <!-- Scripts -->
  
</head>

<body>
  <!-- Page Container -->

  <div id="page-container" class=" @if($exception->getStatusCode() != 500 && $exception->getStatusCode() != 503)sidebar-o @endif sidebar-dark  page-header-fixed main-content-narrow page-header-dark page-header-glass">
    
@if($exception->getStatusCode() != 500 && $exception->getStatusCode() != 503)
    <!-- Sidebar -->
    @include('partials.side-bar')
    <!-- END Sidebar -->

    <!-- Header -->
      <header id="page-header">
        <!-- Header Content -->
        <div class="content-header">
          <!-- Left Section -->
          <div>
            <!-- Toggle Sidebar -->
            

             <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
            <button type="button" class="btn btn-alt-secondary" data-toggle="layout" data-action="sidebar_toggle">
              <div class="studynexus-menu">
                  <div class="studynexus-bar"></div>
                  <div class="studynexus-bar"></div>
                  <div class="studynexus-text">MENU</div>
              </div>
            </button>
            <!-- END Toggle Sidebar -->

            <!-- Open Search Section -->
            
           

            <!-- END Open Search Section -->
          </div>
          <!-- END Left Section -->

          <!-- Right Section -->
		  <!-- End Right Section -->
         
        </div>
        <!-- END Header Content -->
       

      <!-- Header Loader -->
      <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
      <div id="page-header-loader" class="overlay-header bg-header-dark">
        <div class="bg-white-10">
          <div class="content-header">
            <div class="w-100 text-center">
              <i class="fa fa-fw fa-sun fa-spin text-white"></i>
            </div>
          </div>
        </div>
      </div>
      <!-- END Header Loader -->
    </header>
    <!-- END Header -->
@endif
    <!-- Main Container -->
    <main id="main-container">

     <!-- Page Content -->
        <div class="bg-image studynexus-bg-error-image" >
          <div class="row g-0 justify-content-end bg-black-50">
            <!-- Main Section -->
            <div class=" col-md-5 d-flex flex-column bg-body-extra-light pt-4">
              <!-- Header -->
              <div class="flex-grow-0 p-5">
               
				<a href="{{route('home')}}"> <h1 class="display-5 text-dark">Study<span class="text-info">Nexus</span>.<span class="text-success fs-1">ng</span></h1></a>
           
                
              </div>
              <!-- END Header -->

              <!-- Content -->
              <div class="flex-grow-1 d-flex align-items-center p-5 bg-body-light">
                <div class="w-100">
				   @if($exception->getStatusCode() != 503)
                  <p class="text-danger fs-4 fw-bold text-uppercase mb-2">
                    @yield('code') Error
                  </p>
				  @endif
                  <h1 class="fw-bold mb-2">
                    @yield('title')
                  </h1>
                  <p class="fs-4 fw-medium text-muted mb-5">
                    @yield('message')
                  </p>
					@if($exception->getStatusCode() != 503) 	
					<a class="btn btn-lg btn-alt-primary" href="{{route('home')}}">
                        <i class="fa fa-arrow-left opacity-50 me-1"></i> @if($exception->getStatusCode() == 500)  Try Returning to Home Page @else  Return to Home Page  @endif
					</a>
					@endif
                </div>
              </div>
              <!-- END Content -->

            </div>
            <!-- END Main Section -->
          </div>
        </div>
        <!-- END Page Content --> 

    </main>
    <!-- END Main Container -->

    <!-- Footer -->
    <footer id="page-footer" class="bg-body-dark">
      <div class="content py-0">
        <div class="row fs-sm">
          <div class="col-sm-6 order-sm-2 mb-1 mb-sm-0 text-center text-sm-end">
            Developed by <a class="fw-semibold" href="https://bridgeyuwa.github.io" rel="nofollow" target="_blank">Bridges Yuwa</a>
          </div>
          <div class="col-sm-6 order-sm-1 text-center text-sm-start">       
            <a class="fw-semibold" href="{{route('about')}}" target="_blank">Study Nexus</a> &copy;
            <span data-toggle="year-copy"></span>
          </div>
        </div>
      </div>
    </footer>
    <!-- END Footer -->
  </div>
  <!-- END Page Container -->

  <!-- Dashmix Core JS -->
  <script src="{{ asset('js/dashmix.app.js') }}"></script>
  
  @yield('js_after')
</body>

</html>
