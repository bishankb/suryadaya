@extends('layouts.frontend')

@section('content')
	<div class="row">
		<div class="panel panel-default page-section">
			<div class="panel-body default-page-body">
				<h1 class="text-center">
					{{ $list_page->pageType->name }}
				</h1>

				<hr>

				<div class="single-page-desc list-page-description">
					<h3>{{ $list_page->name }}</h3>
					<h5>
			        	<i class="fa fa-clock-o" style="margin-right: 8px;"></i>Posted on {{ $list_page->created_at->format('d M, Y') }}
			        </h5>
			        <hr>
					@isset($list_page->file)
						<div class="page-file">
							@if($list_page->file->extension == 'pdf')
		                        <a style="color: #fff; font-size: 20px;" href="@if(isset($list_page->file)) /storage/media/{{ $list_page->pageType->name}}/{{ $list_page->id }}/{{ $list_page->file->filename }} @endif">
		                            <i style="margin-right: 12px;" class="fa fa-download"></i>Click here to download the file
		                        </a>
		                    @else
		                    	<div id="custom-lightgallery">
			                        <a href="@if(isset($list_page->file)) /storage/media/{{ $list_page->pageType->name}}/{{ $list_page->id }}/{{ $list_page->file->filename }} @endif">
			                            <img class="image-feature" src="@if(isset($list_page->file)) /storage/media/{{ $list_page->pageType->name}}/{{ $list_page->id }}/{{ $list_page->file->filename }} @endif" alt=""/>
			                        </a>
			                    </div>
		                    @endif
		                </div>
	                @endisset
	                @isset($list_page->description)
	                	<div class="page-description">
	                		{!! $list_page->description !!}
	                	</div>
	                @endisset

	                @if(isset($list_page->category) || count($list_page->tags) > 0)
		                <div class="page-category-tags">
		                	<ul>
		                		@isset($list_page->category)
		                			<li>
		                				<strong>Category: </strong>
		                				<a href="{{ route('frontend.categoryListPage', $list_page->category->slug) }}">{{ $list_page->category->name }}</a>
		                			</li>
		                		@endisset
		                		@if(count($list_page->tags) > 0)
		                			<li>
		                				<strong>Tags: </strong>
		                				@foreach($list_page->tags as $key=>$tag)
		                					<a href="{{ route('frontend.tagListPage', $tag->slug) }}">{{ $tag->name }}</a> 
		                					@if ($key + 1 != count($list_page->tags))
						                    	/
						                    @endif
		                				@endforeach
		                			</li>
		                		@endisset
		                	</ul>
	                    </div>
	                @endif
				</div>
			</div>
		</div>
	</div>
@endsection
