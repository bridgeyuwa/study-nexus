<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

     <!-- laravel-seo here -->
     @isset($SEOData) {!! seo($SEOData) !!} @endisset
	@isset($canonical) <link rel="canonical" href="{{$canonical}}" > @endisset
	 <!-- Schema -->
    
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <!-- Icons -->
  <link rel="icon" type="image/svg+xml" href="/media/favicons/favicon-192x192.svg">
  <link rel="shortcut icon" type="image/svg+xml" href="/media/favicons/favicon.svg">
  <link rel="apple-touch-icon" type="image/svg+xml" href="/media/favicons/favicon-180x180.svg">
  
  
  <!-- Fonts and Styles -->
  @yield('css_before')
  <link rel="stylesheet" id="css-main" href="{{ asset('css/dashmix.css') }}">
  <!-- You can include a specific file from public/css/themes/ folder to alter the default color theme of the template. eg: -->
  <!-- <link rel="stylesheet" id="css-theme" href="{{ asset('css/themes/xwork.css') }}"> -->
  @yield('css_after')

  @if (config('app.env') === 'local')
	<link rel="stylesheet"  href="{{ asset('js/plugins/select2/css/select2.min.css') }}">

  @else
	  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />
       
  @endif

	<link rel="stylesheet"  href="{{ asset('js/plugins/select2/css/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet"  href="{{ asset('css/custom.css') }}">

  <!-- Scripts -->
  <script>
    window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
  </script>
</head>

<body>
  <!-- Page Container -->

  <div id="page-container" class="sidebar-o sidebar-dark  page-header-fixed main-content-narrow page-header-dark page-header-glass">
    

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

                    <div id="search-dropdown" class="dropdown-menu dropdown-menu-xxl dropdown-menu-start mt-0 w-100 bg-image studynexus-bg-list" aria-labelledby="dropdown-content-hero-primary" >
                      <div class="bg-black-75">
                     <!-- include Livewire search form here -->
                       <livewire:search-form />
                      <!-- End livewire search form -->
                       </div>
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
                <i class="fa fa-fw fa-rss"></i>
                <span class="badge bg-info rounded-pill">News</span> <i class="fa fw-sm fa-caret-down"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                <div class="bg-primary-dark rounded-top fw-semibold fs-sm text-white text-center p-3">
                  Latest News
                </div>
                <ul class="nav-items my-2">
				
				@foreach($news as $story)
                  <li>
                    <a class="d-flex text-dark py-2" href="{{route('news.show',['news' => $story])}}">
                      <div class="flex-shrink-0 mx-3">
                        <i class="fa fa-fw fa-coins text-success"></i>
                      </div>
                      <div class="flex-grow-1 fs-sm pe-2">
                        <div class="fw-semibold">{{$story->title}}</div>
                        <div class="text-muted">{{$story->created_at->diffForHumans()}}</div>
                      </div>
                    </a>
                  </li>
				  @endforeach
				  
                  
                </ul>
                <div class="p-2 border-top text-center">
                  <a class="btn btn-alt-primary w-100" href="{{route('news.index')}}">
                    <i class="fa fa-fw fa-eye opacity-50 me-1"></i> View All
                  </a>
                </div>
              </div>
            </div>
            <!-- END Notifications Dropdown -->

            
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
  
  
  @if (config('app.env') === 'local')
    <p>You are in the local environment.</p>
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script> 
    <script src="{{ asset('js/plugins/select2/js/select2.min.js') }}"></script> 
    <script src="{{ asset('js/plugins/masonry.pkgd.min.js') }}"></script>

  @else
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js"></script>

  @endif
  
  
  <script src="{{ asset('js/plugins/select2/js/select2-searchInputPlaceholder.js') }}"></script>
  <script src="{{ asset('js/share.js') }}"></script>
  
  
  @yield('js_after')
  
</body>

</html>
