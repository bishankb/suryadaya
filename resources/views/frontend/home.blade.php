@extends('layouts.frontend')

@section('content')
	<div class="row home-section">
		<div class="col-sm-6">
			<div class="panel panel-success home-panel">
				<div class="panel-body" style="background-color: #9bc08c;">
					<h4>ACCOUNTS</h4>
					<p>A variety of accounts to meet all your needs</p>
					@foreach($accounts->take(3) as $account)
						<a href="{{ route('frontend.listPageDesc', $account->slug) }}" style="color: #cc7a00 !important">
							<h5>{{ $account->name }}</h5>
						</a>
						<p style="border-bottom: 1px solid; border-color: #6b9e56;">{!! $account->description !!}</p>
						<br>
					@endforeach
					<p class="know-more">
						<a style="color: #cc7a00" href="{{ route('frontend.listPage', 'account') }}">More about Accounts [..]</a>
					</p>
				</div>
			</div>
		</div>

		<div class="col-sm-6">
			<div class="panel panel-success home-panel">
				<div class="panel-body" style="background-color: #6b9e56;">
					<h4 style="color: #2b2a2a;">LOANS</h4>
					<p style="margin-bottom: 17px; color: #232323;">Variety of Loans That will Suit Your Needs</p>
					@foreach($loans->take(7) as $loan)
						<a href="{{ route('frontend.listPageDesc', $loan->slug) }}" style="color: #333 !important">
							<h5 style="margin-bottom: 13.09px;">
								<i class="fa fa-money" style="margin-right: 5px;"></i> {{ $loan->name }}
							</h5>
						</a>
					@endforeach
					<br>
					<br>
					<p class="know-more">
						<a style="color: #333" href="{{ route('frontend.listPage', 'loan') }}">More about Loans [..]</a>
					</p>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-success home-panel" style="margin-bottom: 22px;">
		<div class="panel-body" style="background-color: #336600; color: white; position: relative;">
			<h4>REMITANCES</h4>
			<hr>
			<h4 style="margin-bottom: 35px; font-weight: normal;">Variety of Remittances that you looking for..</h4>
			<div class="remittance-slick">
                @foreach ($remittances as $remittance)
                    <a href="{{ route('frontend.listPageDesc', $remittance->slug) }}">
                    	<img src="@if(isset($remittance->file)) /storage/media/Remittance/{{ $remittance->id }}/thumbnail/{{ $remittance->file->filename }} @endif" alt=""/>
                    </a>
                @endforeach
            </div>
            <a style="color: #fff" href="{{ route('frontend.listPage', 'remittance') }}">
	            <div class="remmittance-know-more">
	            	<p>
						Explorer more Remittance
					</p>
	            </div>
            </a>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-success home-panel">
				<div class="panel-body" style="background-color: #336600; color: white;">
					<h4>ABOUT US</h4>
					<hr>
					<p style="text-align: justify;">
						{!! str_limit($about_us->description, $limit = 450, $end = '...') !!}
					</p>
					<p style="margin-top: 20px;" class="know-more">
						<a style="color: #fff;" href="{{ route('frontend.singlePage', 'about-us') }}">Know More....</a>
					</p>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="panel panel-success home-panel">
				<div class="panel-body" style="background-color: #336600; color: white;">
					<h4>ACHIEVEMENTS</h4>
					<hr>
					@foreach($achievements->take(3) as $achievement)
						<div class="single-news" style="margin-bottom: 19px;">
							<h5>
								<a style="color: #fff;" href="{{ route('frontend.listPageDesc', $achievement->slug) }}">{!! str_limit($achievement->name, $limit = 45, $end = '...') !!}</a>
							</h5>
							<p style="border-bottom: 1px solid; border-color: #6b9e56; font-size: 13px;">
								<i class="far fa-calendar"></i> {{ $achievement->created_at->format('Y/m/d') }}
							</p>
						</div>
					@endforeach
					<p style="margin-top: 20px;" class="know-more">
						<a style="color: #fff" href="{{ route('frontend.listPage', 'achievement') }}">More about Achievements [..]</a>
					</p>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('frontend-script')
	<script type="text/javascript">
		$( document ).ready(function() {
			$('.remittance-slick').slick({
				dots: false,
				infinite: true,
				speed: 300,
				slidesToShow: 4,
				slidesToScroll: 4,
				autoplay: true,
  				autoplaySpeed: 2000,
  				responsive: [

				    {
				      	breakpoint: 480,
				      	settings: {
					        slidesToShow: 2,
					        slidesToScroll: 2
				    	}
				    }
				]
			});
      	});
    </script>
@endsection