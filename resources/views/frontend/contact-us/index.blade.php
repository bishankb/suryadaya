@extends('layouts.frontend')

@section('content')
	<div class="row">
		<div class="panel panel-default page-section">
			<div class="panel-body default-page-body">
				<div class="contact-form">
					<h1 class="text-center">
						Contact Us
					</h1>
					
					<hr>

					<div class="single-page-desc contact-us-body">
						<form action="{{ route('contact-us.send') }}" method="post">
		                    {{ csrf_field() }}
		                    
		                    @include('frontend.contact-us._form')
		                    
		                    <button type="submit" class="btn btn-primary" style="margin-top: 10px;">
		                        Send Message
		                        <i class="fa fa-paper-plane"></i>
		                    </button>
		                </form>
					</div>
				</div>
				
				@if(!empty(config('suryadaya.map_cordinate')))
					<div class="map">
						<h3>Our Location</h3>
						{!! config('suryadaya.map_cordinate') !!}
					</div>
				@endif

				@if(!empty(config('suryadaya.map_cordinate')))
					<div class="social-media-site">
						<h3>Follow Us On</h3>
						<ul class="social-media">
							@foreach($social_medias as $social_media)
								<li>
								  <a href="{{ $social_media->url }}">
								    <img src="@if(isset($social_media->image)) /storage/media/social-media/{{$social_media->id}}/{{$social_media->image->filename}} @endif">
								  </a>
								</li>
							@endforeach
						</ul>
					</div>
				@endif
			</div>
		</div>
	</div>
@endsection