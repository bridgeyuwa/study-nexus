@extends('layouts.backend')


@section('content')


<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-5 pb-0">
              <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">Search</h1>

                  <h2 class="h4 fs-md  fw-light text-white-75 ">
                     Discover Academic Institutions and Courses
                    </h2>

             <form class="p-2" action="/search" method="GET">
                       

               <div class="row"> 
                        <div class="mb-2 col-12 col-md-4">
                         <label class="form-label fw-light text-white" for="##">Location</label>
                         <select class="form-select" name="location"> 
                         <option value="">Any</option>
                         
                         <option value=""> qwertyuio </option>
                         
                         </select>
                         </div>
  

                         <div class="mb-2 col-12 col-md-4">
                         <label class="form-label fw-light text-white" for="##">Level</label>
                        <select class="form-select" name="level"> 
                         <option value="">Any</option>
                        
                         <option value="">asdfghjk</option>
                      
                         </select>
                         </div>

                         <div class="mb-2 col-12 col-md-4">
                         <label class="form-label fw-light text-white" for="##">Program</label>
                         <select class="form-select" name="program"> 
                         <option value="">Any</option>
                          
                         <option value="" class="fw-light">asdfghj</option>
                         
                         </select>
                         </div>

</div>

                        
                         

                   <div class="pt-2">
                    <div class="d-flex  justify-content-center justify-content-md-end me-md-5 ">
                        <button type="submit" class="btn btn-lg btn-info rounded-0 text-uppercase">Search</button>
                    </div>
                </div>


                      </form>


              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->

<br>




<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-5 pt-5">
              <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">Acme Inc</h1>

                  <h2 class="h4 fs-md  fw-light text-white-75 mb-1">
                      Benin - Edo
                    </h2>

                <h2 class="h3 fw-light text-white-75">Web Design &amp; Development</h2>



              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->

<br>
/institutions/{institution}
<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-5">
              <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">Ahmadu Bello University <span class="text-white-75">(ABU)</span></h1>

                  <h2 class="h4 fs-md  fw-light text-white-75 mb-1">
                      Zaria - Kaduna
                    </h2>

              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->
<br>

/institutions/{institution}/programs
<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-5">
              <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">Ahmadu Bello University <span class="text-white-75">(ABU)</span></h1>

                  <h2 class="h4 fs-md  fw-light text-white-75 ">
                      Zaria - Kaduna
                    </h2>

            <h2 class="h3 fw-light text-white">Bachelor's Degree Programs</h2>

              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->


<br>

/institutions/{institution}/levels/{level}/programs/{program}
<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-5">
              <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">Ahmadu Bello University <span class="text-white-75">(ABU)<span></h1>

                  <h2 class="h4 fs-md  fw-light text-white-75 ">
                      Zaria - Kaduna
                    </h2>

            <h2 class="h3 fw-light text-white">Accounting <span class="h4 fw-light text-white-75">(Bachelor's Degree)</span></h2> 

              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->


<br>

/institutions/{institution}/programs/{program}
<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-5">
           <div class="row">
              <div class="col-md-8 pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">Ahmadu Bello University <span class="text-white-75">(ABU)<span></h1>

                  <h2 class="h4 fs-md  fw-light text-white-75 ">
                     Zaria - Kaduna
                    </h2>

           
                  <h2 class="h3 fw-light text-white">Accounting Programs</h2> 
              </div>

              <div class="col-md-4 d-flex align-items-center">
                  <div class="block block-rounded block-transparent bg-black-50 text-center mb-0 mx-auto">
                    <div class="block-content block-content-full px-5 py-4">
                      <div class="fs-2 fw-semibold text-white">
                        $50-$60<span class="text-white-50">k</span>
                      </div>
                      <div class="fs-sm fw-semibold text-uppercase text-white-50 mt-1 push">Tuition/Year</div>
                      
                    </div>
                  </div>
                </div>
             
         </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->


<br>

/institutions
<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-5">
              <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">Nigerian Universities </h1>

              
              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->


<br>

/institutions/location
<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-5">
              <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">Nigerian Universities</h1>

                  <h2 class="h4 fs-md  fw-light text-white-75 ">
                     ( Locate University by Region/State )
                    </h2>

           
            <h2 class="h3 fw-light text-white">Region/States</h2>
              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->


<br>

/institutions/catchments
<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-5">
              <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">Nigerian Universities</h1>

                  <h2 class="h4 fs-md  fw-light text-white-75 ">
                     ( Locate University by Catchment Area )
                    </h2>

           
            <h2 class="h3 fw-light text-white">Catchment Areas</h2>
              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->


<br>

/programs
<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-5">
           <div class="row">
              <div class="col-md-8 pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">Bachelor's Degree Programs</h1>

                  <h2 class="h4 fs-md  fw-light text-white-75 ">
                     ( Locate University by Catchment )
                    </h2>

           
                  <h2 class="h3 fw-light text-white">Catchment Areas</h2>
              </div>

              <div class="col-md-4 d-flex align-items-center">
                  <div class="block block-rounded block-transparent bg-black-50 text-center mb-0 mx-auto">
                    <div class="block-content block-content-full px-5 py-4">
                      <div class="fs-2 fw-semibold text-white">
                        $50-$60<span class="text-white-50">k</span>
                      </div>
                      <div class="fs-sm fw-semibold text-uppercase text-white-50 mt-1 push">Tuition/Year</div>
                      
                    </div>
                  </div>
                </div>
             
         </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->


<br>

/programs/{program}
<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-5">
              <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">Accounting</h1>

                  <h2 class="h4 fs-md  fw-light text-white-75 ">
                     Bachelors Degree
                    </h2>
              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->

<br>

/programs/{program}/institutions
<!-- Hero -->
        <div class="bg-image" style="background-image: url('{{asset('/media/photos/photo13@2x.jpg')}}');">
          <div class="bg-black-75">
            <div class="content content-full content-top text-center pt-5">
              <div class="pt-4 pb-3">
                <h1 class="fw-light text-white mb-1">Accounting</h1>

                  <h2 class="h4 fs-md  fw-light text-white-75 ">
                     Institutions Offering Bachelor's Degree in Accounting
                    </h2>
              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->

<br>

<!-- Addresses -->
              <div class="block block-rounded h-100 mb-0 text-center">
                <div class="block-header block-header-default">
                  <h3 class="block-title">Addresses</h3>
                </div>
                <div class="block-content">
                  <address>
                    <strong>Twitter, Inc.</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    <abbr title="Phone">P:</abbr> (123) 456-7890
                  </address>
                  <address>
                    <strong>Full Name</strong><br>
                    <a href="mailto:#">first.last@example.com</a>
                  </address>
                </div>
              </div>
              <!-- END Addresses -->

<br>




@endsection