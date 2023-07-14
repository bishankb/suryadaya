@extends('layouts.frontend')

@section('content')
	<div class="row">
		<div class="panel panel-default page-section">
			<div class="panel-body default-page-body">
				<h1 class="text-center">
					Gallery
				</h1>
				
				<hr>

				<div class="single-page-desc gallery-body">
					<div class="row">
						@forelse($galleries as $gallery )
				          	<div class="col-sm-4">
				            	<div class="single-gallery">
				              		<div class="panel panel-default panel-gallery"> 
				                		<a href="{{ route('gallery.show', $gallery->slug) }}">
											<div class="panel-heading">
												<img src="@if(isset($gallery->images)) /storage/media/gallery/{{ $gallery->id }}/thumbnail/{{ $gallery->images->first()->filename }} @endif" alt=""/>
											</div>
											<div class="panel-body">
												<span>{{ $gallery->name }}</span>
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