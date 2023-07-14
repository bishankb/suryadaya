@extends('layouts.frontend')

@section('content')
	<div class="row">
		<div class="panel panel-default page-section">
			<div class="panel-body default-page-body">
				<h1 class="text-center">
					@if(isset($single_page))
						{{ $single_page->name}}
					@else
						{{ $menu->name}}
					@endif
				</h1>
				
				<hr>

				<div class="single-page-desc">
					@isset($single_page->file)
						<div class="page-file">
							@if($single_page->file->extension == 'pdf')
		                        <a style="color: #fff; font-size: 20px;" href="@if(isset($single_page->file)) /storage/media/{{ $single_page->name}}/{{ $single_page->id }}/{{ $single_page->file->filename }} @endif">
		                            <i style="margin-right: 12px;" class="fa fa-download"></i>Click here to download the file
		                        </a>
		                    @else
		                    	<div id="custom-lightgallery">
			                        <a href="@if(isset($single_page->file)) /storage/media/{{ $single_page->name}}/{{ $single_page->id }}/{{ $single_page->file->filename }} @endif">
			                            <img class="image-feature" src="@if(isset($single_page->file)) /storage/media/{{ $single_page->name}}/{{ $single_page->id }}/{{ $single_page->file->filename }} @endif" alt=""/>
			                        </a>
			                    </div>
		                    @endif
		                </div>
	                @endisset
	                @isset($single_page->description)
	                	<div class="page-description">
	                		{!! $single_page->description !!}
	                	</div>
	                @endisset
				</div>
			</div>
		</div>
	</div>
@endsection