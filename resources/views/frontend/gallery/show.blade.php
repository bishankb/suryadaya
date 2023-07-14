@extends('layouts.frontend')

@section('content')
	<div class="row">
		<div class="panel panel-default page-section">
			<div class="panel-body default-page-body">
				<h1 class="text-center">
					{{ $gallery->name }}
				</h1>
				
				<hr>

				<div class="single-page-desc gallery-body">
					<div class="row" id="galleries">
	       				@forelse($gallery->images as $image)
				          	<div class="col-sm-4 custom-col">
				          		<div class="single-image">
					            	<div class="single-gallery">
				                		<a class="image-gallery" href="/storage/media/gallery/{{ $gallery->id }}/{{ $image->filename }}">
											<div class="panel-heading">
												<img src="@if(isset($gallery->images)) /storage/media/gallery/{{ $gallery->id }}/thumbnail/{{ $image->filename }} @endif" alt=""/>
											</div>
				                		</a>
					            	</div>
					            </div>
				          	</div>
				        @empty
				        	<span>No gallery added</span>
				        @endforelse
				    </div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('frontend-script')
  <script>
    $(document).ready(function() {
      $("#galleries").lightGallery({
        share: false,
        actualSize: false,
        selector: '.image-gallery'
      }); 
    });
  </script>
@endsection