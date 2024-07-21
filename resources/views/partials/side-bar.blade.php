<!-- Sidebar -->
<nav id="sidebar"aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="bg-header-dark">
        <div class="content-header bg-white-5">
            <!-- Logo -->
            <a class="fw-semibold text-white tracking-wide"href="{{url("/")}}">
                <span class="smini-visible">
                    S<span class="opacity-75">N</span>
                </span>
                <span class="smini-hidden">
                    Study<span class="opacity-75">Nexus</span>
                </span>
            </a>
            <!-- END Logo -->

            <!-- Options -->
            <div>

                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button"class="btn btn-sm btn-alt-secondary d-lg-none"data-toggle="layout"data-action="sidebar_close">
                    <i class="fa fa-times-circle"></i> 
                     <div class="studynexus-text">CLOSE</div>
                </button>
                <!-- END Close Sidebar -->
            </div>
            <!-- END Options -->
        </div>
    </div>
    <!-- END Side Header -->

    <!-- Sidebar Scrolling -->
    <div class="js-sidebar-scroll">
        <!-- Side Navigation -->
        <div class="content-side">
            <ul class="nav-main">


                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{route('home')}}">
                        <i class="nav-main-link-icon fa fa-home"></i>
                        <span class="nav-main-link-name">Home</span></a>
                </li>
				
				<li class="nav-main-item">
                    <a class="nav-main-link" href="{{route('search')}}">
                        <i class="nav-main-link-icon fa fa-search"></i>
                        <span class="nav-main-link-name">Search</span></a>
                </li>



                <li class="nav-main-heading">Explore</li>



                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu"data-toggle="submenu"aria-haspopup="true"aria-expanded="false"href="#">
                        <i class="nav-main-link-icon fa fa-graduation-cap"></i>
                        <span class="nav-main-link-name">Institutions</span>
                    </a>
                    <ul class="nav-main-submenu">



                        <li class="nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu"data-toggle="submenu"aria-haspopup="true"aria-expanded="false"href="#">
                               
                                <span class="nav-main-link-name">All Institutions</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a  class="nav-main-link"href="{{route('institutions.index')}}">
                                        
                                        <span class="nav-main-link-name">View All Institutions</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{route('institutions.location')}}">
                                        
                                        <span class="nav-main-link-name">All Institutions by Location</span>
                                    </a>
                                </li>

                            </ul>
                        </li>


                        <li class="nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu"data-toggle="submenu"aria-haspopup="true"aria-expanded="false"href="#">
                                
                                <span class="nav-main-link-name">Universities</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{route('institutions.categories.index',['category'=> 'university'])}}">
                                        
                                        <span class="nav-main-link-name">View Universities</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a  class="nav-main-link" href="{{route('institutions.categories.location',['category'=> 'university'])}}">
                                        
                                        <span class="nav-main-link-name"> Universities by Location</span>
                                    </a>
                                </li>

                            </ul>
                        </li>


                        <li class="nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu"data-toggle="submenu"aria-haspopup="true"aria-expanded="false"href="#">
                               
                                <span class="nav-main-link-name">Polytechnics</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{route('institutions.categories.index',['category'=> 'polytechnic'])}}">
                                        
                                        <span class="nav-main-link-name">View Polytechnics</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{route('institutions.categories.location',['category'=> 'polytechnic'])}}">
                                        
                                        <span class="nav-main-link-name"> Polytechnics by Location</span>
                                    </a>
                                </li>

                            </ul>
                        </li>


                        <li class="nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu"data-toggle="submenu"aria-haspopup="true"aria-expanded="false"href="#">
                               
                                <span class="nav-main-link-name">Monotechnics</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{route('institutions.categories.index',['category'=> 'monotechnic'])}}">
                                        
                                        <span class="nav-main-link-name">View Monotechnics</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{route('institutions.categories.location',['category'=> 'monotechnic'])}}">
                                        
                                        <span class="nav-main-link-name"> Monotechnics by Location</span>
                                    </a>
                                </li>

                            </ul>
                        </li>


                        <li class="nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu"data-toggle="submenu"aria-haspopup="true"aria-expanded="false"href="#">
                               
                                <span class="nav-main-link-name">Colleges of Education</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{route('institutions.categories.index',['category'=> 'college-of-education'])}}">
                                        
                                        <span class="nav-main-link-name">View Colleges of Education</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{route('institutions.categories.location',['category'=> 'college-of-education'])}}">
                                        
                                        <span class="nav-main-link-name"> Colleges of Education by Location</span>
                                    </a>
                                </li>

                            </ul>
                        </li>


                        <li class="nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu"data-toggle="submenu"aria-haspopup="true"aria-expanded="false"href="#">
                               
                                <span class="nav-main-link-name">Innovation Enterprise Institutions</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{route('institutions.categories.index',['category'=> 'innovation-enterprise-institution'])}}">
                                        
                                        <span class="nav-main-link-name">View Innovation Enterprise Institutions</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{route('institutions.categories.location',['category'=> 'innovation-enterprise-institution'])}}">
                                        
                                        <span class="nav-main-link-name"> Innovation Enterprise Institutions by Location</span>
                                    </a>
                                </li>

                            </ul>
                        </li>

                    </ul>
                </li>








                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu"data-toggle="submenu"aria-haspopup="true"aria-expanded="false"href="#">
                        <i class="nav-main-link-icon fa fa-book"></i>
                        <span class="nav-main-link-name">Programs</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('programs.index', ['level'=>'bachelors'])}}">
                                
                                <span class="nav-main-link-name">Bachelor's Degree Courses</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('programs.index', ['level'=>'diploma'])}}">
                                
                                <span class="nav-main-link-name">National Diploma (N.D) Courses</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('programs.index', ['level'=>'nce'])}}">
                                
                                <span class="nav-main-link-name">Nigeria Certificate in Education (N.C.E) Courses</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('programs.index', ['level'=>'nid'])}}">
                                
                                <span class="nav-main-link-name">National Innovation Diploma (N.I.D) Courses</span>
                            </a>
                        </li>

                    </ul>
                </li>



                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu"data-toggle="submenu"aria-haspopup="true"aria-expanded="false"href="#">
                        <i class="nav-main-link-icon fa fa-location-arrow"></i>
                        <span class="nav-main-link-name">Catchments</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">  
                              <a class="nav-main-link" href="{{route('institutions.catchments.index')}}">
                                
                                <span class="nav-main-link-name">Federal University Catchments</span>
                            </a>
                        </li>
                        
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('institutions.catchments.policy')}}">
                                
                                <span class="nav-main-link-name">Catchment Area Policy</span>
                            </a>
                        </li>


                    </ul>
                </li>




                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu"data-toggle="submenu"aria-haspopup="true"aria-expanded="false"href="#">
                        <i class="nav-main-link-icon fa fa-trophy"></i>
                        <span class="nav-main-link-name">Institution Rankings</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('institutions.categories.ranking',['category'=>'university'])}}">
                                <span class="nav-main-link-name">University Rankings</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('institutions.categories.ranking',['category'=>'polytechnic'])}}">
                                <span class="nav-main-link-name">Polytechnic Rankings</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('institutions.categories.ranking',['category'=>'monotechnic'])}}">
                                <span class="nav-main-link-name">Monotechnic Rankings</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{route('institutions.categories.ranking',['category'=>'college-of-education'])}}">
                                <span class="nav-main-link-name">College of Education Rankings</span>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-main-heading">Extend</li>

                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{route('about')}}">
                        <i class="nav-main-link-icon fa fa-info-circle"></i>
                        <span class="nav-main-link-name">About Us</span></a>
                </li>
               
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{route('tos')}}">
                        <i class="nav-main-link-icon fa fa-balance-scale"></i>
                        <span class="nav-main-link-name">Terms of Service</span></a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{route('policy')}}">
                        <i class="nav-main-link-icon fa fa-lock"></i>
                        <span class="nav-main-link-name">Privacy Policy</span></a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{route('contact')}}">
                        <i class="nav-main-link-icon fa fa-envelope"></i>
                        <span class="nav-main-link-name">Contact Us</span></a>
                </li>

            </ul>


         <!-- END Side Navigation -->
        </div>          

          <!-- Social Links -->
          <div class="bg-black-10 text-center mt-auto">
            <div class="">
              <a class="btn btn-sm btn-secondary">
                <i class="fab fa-fw fa-facebook-f"></i>
              </a>
              <a  class="btn btn-sm btn-secondary">
                <i class="fab fa-fw fa-twitter"></i>
              </a>
              <a class="btn btn-sm btn-secondary">
                <i class="fab fa-fw fa-instagram"></i>
              </a>
              <a class="btn btn-sm btn-secondary">
                <i class="fab fa-fw fa-linkedin-in"></i>
              </a>
            </div>
          </div>
          <!-- END Social links -->


    </div>
    <!-- END Sidebar Scrolling -->

</nav>
<!-- END Sidebar -->