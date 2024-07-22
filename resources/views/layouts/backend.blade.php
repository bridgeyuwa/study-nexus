<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

     <!-- laravel-seo here -->
     @isset($SEOData) {!! seo($SEOData) !!} @endisset
	 
	 <!-- Schema -->
     @isset($jsonLd) {!! $jsonLd !!}  @endisset
    
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
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


<link rel="stylesheet"  href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet"  href="{{ asset('js/plugins/select2/css/select2-bootstrap-5-theme.min.css') }}">

<link rel="stylesheet"  href="{{ asset('css/custom.css') }}">

  <!-- Scripts -->
  <script>
    window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
  </script>
</head>

<body>
  <!-- Page Container -->

  <div id="page-container" class="sidebar-o sidebar-dark side-scroll page-header-fixed main-content-narrow page-header-dark page-header-glass">
    

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
            
            

             @if(!request()->is('/') && !request()->is('search'))
              <div class="dropdown push d-inline-block">

                    <button type="button" class="btn btn-alt-secondary dropdown-toggle" id="dropdown-content-hero-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-auto-close="outside" ><i class="fa fa-fw fa-search"></i> <span class="ms-1 d-none d-sm-inline-block">Search</span> </button>

                    <div id="search-dropdown" class="dropdown-menu dropdown-menu-xxl dropdown-menu-start mt-0 w-100" aria-labelledby="dropdown-content-hero-primary">
                      
                     <!-- include Livewire search form here -->
                       <livewire:search-form />
                      <!-- End livewire search form -->
                       
                    </div>
               </div>
            @endif

            <!-- END Open Search Section -->
          </div>
          <!-- END Left Section -->

          <!-- Right Section -->
          <div>
            <!-- Notifications Dropdown -->
            <div class="dropdown d-inline-block">
              <button type="button" class="btn btn-alt-secondary" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-fw fa-flag"></i>
                <span class="badge bg-success rounded-pill">3</span>
              </button>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                <div class="bg-primary-dark rounded-top fw-semibold text-white text-center p-3">
                  Notifications
                </div>
                <ul class="nav-items my-2">
                  <li>
                    <a class="d-flex text-dark py-2" href="javascript:void(0)">
                      <div class="flex-shrink-0 mx-3">
                        <i class="fa fa-fw fa-coins text-danger"></i>
                      </div>
                      <div class="flex-grow-1 fs-sm pe-2">
                        <div class="fw-semibold">You’ve made a payment of $49 to Adobe Inc.</div>
                        <div class="text-muted">5 min ago</div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a class="d-flex text-dark py-2" href="javascript:void(0)">
                      <div class="flex-shrink-0 mx-3">
                        <i class="fa fa-fw fa-coins text-danger"></i>
                      </div>
                      <div class="flex-grow-1 fs-sm pe-2">
                        <div class="fw-semibold">Recurring payment of $29 to Dropbox was successful.</div>
                        <div class="text-muted">30 min ago</div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a class="d-flex text-dark py-2" href="javascript:void(0)">
                      <div class="flex-shrink-0 mx-3">
                        <i class="fa fa-fw fa-coins text-success"></i>
                      </div>
                      <div class="flex-grow-1 fs-sm pe-2">
                        <div class="fw-semibold">Incoming payment of <strong>$499</strong> from John Taylor!</div>
                        <div class="text-muted">2 hrs ago</div>
                      </div>
                    </a>
                  </li>
                </ul>
                <div class="p-2 border-top text-center">
                  <a class="btn btn-alt-primary w-100" href="javascript:void(0)">
                    <i class="fa fa-fw fa-eye opacity-50 me-1"></i> View All
                  </a>
                </div>
              </div>
            </div>
            <!-- END Notifications Dropdown -->

            <!-- User Dropdown -->
            <div class="dropdown d-inline-block">
              <button type="button" class="btn btn-alt-secondary" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-fw fa-user-circle"></i>
                <i class="fa fa-fw fa-angle-down d-none opacity-50 d-sm-inline-block"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="page-header-user-dropdown">
                <div class="bg-primary-dark rounded-top fw-semibold text-white text-center p-3">
                  <img class="img-avatar img-avatar48 img-avatar-thumb" src="assets/media/avatars/avatar10.jpg" alt="">
                  <div class="pt-2">
                    <a class="text-white fw-semibold" href="be_pages_generic_profile.html">Henry Harrison</a>
                  </div>
                </div>
                <div class="p-2">
                  <a class="dropdown-item" href="javascript:void(0)">
                    <i class="fa fa-fw fa-cog me-1"></i> Settings
                  </a>
                  <div role="separator" class="dropdown-divider"></div>
                  <a class="dropdown-item" href="op_auth_signin.html">
                    <i class="fa fa-fw fa-arrow-alt-circle-left me-1"></i> Log Out
                  </a>
                </div>
              </div>
            </div>
            <!-- END User Dropdown -->
          </div>
          <!-- END Right Section -->
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

    <!-- Main Container -->
    <main id="main-container">

      @yield('content') 

    </main>
    <!-- END Main Container -->

    <!-- Footer -->
    <footer id="page-footer" class="bg-body-dark">
      <div class="content py-0">
        <div class="row fs-sm">
          <div class="col-sm-6 order-sm-2 mb-1 mb-sm-0 text-center text-sm-end">
            Developed by <a class="fw-semibold" href="https://github.com/bridgeyuwa" rel="nofollow" target="_blank">Bridges Yuwa</a>
          </div>
          <div class="col-sm-6 order-sm-1 text-center text-sm-start">       
            <a class="fw-semibold" href="{{route('about')}}" target="_blank">StudyNexus</a> &copy;
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
  <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
  <script src="{{ asset('js/plugins/select2/js/select2.min.js') }}"></script>
  <script src="{{ asset('js/plugins/select2/js/select2-searchInputPlaceholder.js') }}"></script>

  
  @yield('js_after')
</body>

</html>
