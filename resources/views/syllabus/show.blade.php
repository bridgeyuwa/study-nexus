@extends('layouts.backend')


@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>

<span itemscope itemtype="https://schema.org/Syllabus" >
  <link itemprop="url" href="{{url()->current()}}" >
<!-- Hero  -->
        <div itemprop="provider"  itemscope itemtype="https://schema.org/EducationalOrganization" class="bg-image studynexus-bg-hero" >
          <div class="bg-black-75">
            <div class="content content-boxed content-full pt-7">
              <div class="row">
			    @if(!empty($exam->examBody->logo))
				
			    <div class="col-md-2 d-flex align-items-center">
                  <div class="block block-rounded  block-transparent bg-black-50 text-center mb-0 mx-auto" style="box-shadow:0 0 2.25rem #d1d8ea;opacity:1">
                    <div class="block-content block-content-full px-1 py-1">
					
                      <img  src="{{ Storage::url($exam->examBody->logo) }}" alt="{{$exam->examBody->name}} logo"  style="width: 100px; height: 100px; object-fit: cover;">
                      <link itemprop="logo" href="{{Storage::url($exam->examBody->logo)}}">
                    </div>
                  </div>
                </div>
				@endif
				
                <div class=" @if(!empty($exam->examBody->logo)) col-md-10 @endif d-flex align-items-center pt-3">
					 <div class="w-100 text-center @if(!empty($exam->examBody->logo)) text-md-start @endif">
						<div class="h3 text-white mb-1 "> 
						<span itemprop="name">{{$exam->examBody->name}}</span> 
						@if(!empty($exam->examBody->abbr))
							(<span itemprop="alternateName" class="fw-light">{{$exam->examBody->abbr}}</span>)
						@endif 
						</div>
                          
						  <link itemprop="sameAs" href="{{$exam->examBody->url}}">
						  
						<div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress" class="h4 fs-sm fw-light text-white mb-1">
							<div itemprop="streetAddress"> {{$exam->examBody->address}} </div>
							@if(!empty($exam->examBody->locality)) <span itemprop="addressLocality">{{$exam->examBody->locality}} </span>- @endif  <span itemprop="addressRegion">{{$exam->examBody->state->name}} @if(!empty($exam->examBody->state->is_state)) State @endif </span> 
						  @if(!empty($exam->examBody->postal_code)) <meta itemprop="postalCode" content="{{$exam->examBody->postal_code}}"> @endif
							<meta itemprop="addressCountry" content="NG">
							<div> Nigeria </div>
						
						</div>
						
						<h1 class="h3 text-white mt-3 mb-1">
							 {{$syllabus->name}}
						</h1>
						
					 </div>
						
                </div>
              </div>
            </div>
          </div>
		  
		  <div class="d-flex justify-content-end py-1">		
		   <!-- Social Actions -->
				
				<div class="btn-group me-1" role="group">
					<button type="button" class="btn btn-sm btn-alt-primary dropdown-toggle" id="dropdown-blog-news" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-share-alt opacity-50 me-1"></i> Share Syllabus
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

	<div class="content content-boxed ">
			<meta itemprop="name" content="{{$syllabus->name}}">
			@if(!empty($syllabus->description))
			<p class="bg-white p-3" itemprop="description"> {{$syllabus->description}} </p>
			@else
			<p class="bg-white p-3" itemprop="description"> {{$exam->examBody->name}} Syllabus for {{$syllabus->subject}}. @if(!empty($exam->abbr)) for {{$exam->description}} | {{$exam->abbr}} @endif </p>
			@endif
				
			<div id="pdf-viewer"><span class="d-flex justify-content-end py-1"><a class="btn btn-sm btn-dark rounded-0" href="{{Storage::url($syllabus->attachment)}}" > Download the {{$exam->examBody->abbr}} Syllabus for {{$syllabus->subject}} </a> </span> </div>

		
   
			
			

	</div>

</span>





<script>
  const pdfUrl = '{{Storage::url($syllabus->attachment)}}';

  // Configure PDF.js
  pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

  // Fetch and render the PDF
  const viewer = document.getElementById('pdf-viewer');

  pdfjsLib.getDocument(pdfUrl).promise.then((pdf) => {
    const totalPages = pdf.numPages;  // Get the total number of pages

    // Loop through each page in the PDF and render it
    for (let pageNumber = 1; pageNumber <= totalPages; pageNumber++) {
      pdf.getPage(pageNumber).then((page) => {
        const canvas = document.createElement('canvas');
        viewer.appendChild(canvas); // Append the canvas for each page

        // Get the initial viewport (for scale = 1)
        const initialViewport = page.getViewport({ scale: 1 });

        // Get the scale based on the container width
        const scale = viewer.offsetWidth / initialViewport.width;

        // Calculate the viewport with the new scale
        const scaledViewport = page.getViewport({ scale });

        // Adjust for device pixel ratio (DPI scaling) to avoid blurriness on high-DPI screens
        const dpiScale = window.devicePixelRatio || 1; // Default to 1 if devicePixelRatio is not available
        canvas.width = scaledViewport.width * dpiScale;
        canvas.height = scaledViewport.height * dpiScale;

        // Scale the canvas context to match the device pixel ratio
        const ctx = canvas.getContext('2d');
        ctx.setTransform(dpiScale, 0, 0, dpiScale, 0, 0);  // Scale the context to match the DPI

        // Render the page to the canvas
        page.render({
          canvasContext: ctx,
          viewport: scaledViewport
        });
      });
    }
  });
</script>




 



@endsection