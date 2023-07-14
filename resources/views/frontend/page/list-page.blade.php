@extends('layouts.frontend')

@section('content')
	<div class="row">
		<div class="panel panel-succes page-section">
			<div class="panel-body default-page-body">
				<h1 class="text-center">
					@if(isset($category))
						{{ $category->name }}
					@elseif(isset($tag))
						{{ $tag->name }}
					@elseif(isset($page_type))
						{{ $page_type->name}}
					@else
						{{ $menu->name}}
					@endif
				</h1>

				<hr>

				<div class="list-page-desc">
					@foreach($list_pages as $key => $list_page)
						<div class="list-page-block">
							<div class="row">
								@isset($list_page->file)
								    <div class="col-sm-4">
							        	@if($list_page->file->extension != 'pdf')
					                        <img class="image-feature" src="@if(isset($list_page->file)) /storage/media/{{ $page_type->name}}/{{ $list_page->id }}/thumbnail/{{ $list_page->file->filename }} @endif" alt=""/>
					                    @endif
								    </div>
								@endisset
							    <div class="{{ isset($list_page->file) && ($list_page->file->extension != 'pdf') ? 'col-sm-8' : 'col-md-12'}}"> 
							    	<div class="list-page-detail">
								        <h3>
								        	<a href="{{ route('frontend.listPageDesc', $list_page->slug) }}" style="color: #fff;">{{ $list_page->name }}</a>
								        </h3>
								        <h5>
								        	<i class="fa fa-clock-o" style="margin-right: 8px;"></i>On : {{ $list_page->created_at->format('d M, Y') }}
								        </h5>
								        <p>
								        	{!! str_limit($list_page->description, $limit = 510, $end = '...') !!}
								        </p>
								    </div>
							    </div>
							</div>
						</div>
						@if ($key + 1 != count($list_pages))
	                    	<hr>
	                    @endif
					@endforeach
				</div>
			</div>
			<div class="text-center">
				{{ $list_pages->links() }}					
			</div>
		</div>
	</div>
@endsection