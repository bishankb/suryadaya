<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('name') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}

            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Name']) !!}

            @if ($errors->has('name'))
                <div class="ui pointing red basic label"> {{$errors->first('name')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('order') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('order', 'Order', ['class' => 'control-label']) !!}

            {!! Form::number('order', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Order']) !!}

            @if ($errors->has('order'))
                <div class="ui pointing red basic label"> {{$errors->first('order')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('description', 'Description', ['class' => 'control-label']) !!}

            {!! Form::textarea('description', null, ['class' => 'form-control custom-textarea', 'placeholder'=>'Description']) !!}

            @if ($errors->has('description'))
                <div class="ui pointing red basic label"> {{$errors->first('description')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('file_id') ? ' has-error' : '' }} clearfix">
            {!! Form::label('file_id', 'File', ['class' => 'control-label']) !!}
            @if(isset($list_page->file))
                <div class="show-image">
                    @if($list_page->file->extension == 'pdf')
                        <a href="@if(isset($list_page->file)) /storage/media/{{ $type->name}}/{{ $list_page->id }}/{{ $list_page->file->filename }} @endif">
                            <img  class="custom-thumbnail selected-img" src="@if(isset($list_page->file)) {{ asset('images/pdf-logo.jpg') }} @endif" alt=""/>
                        </a>
                    @else
                        <a href="@if(isset($list_page->file)) /storage/media/{{ $type->name}}/{{ $list_page->id }}/{{ $list_page->file->filename }} @endif" data-lightbox="image">
                            <img  class="custom-thumbnail selected-img" src="@if(isset($list_page->file)) /storage/media/{{ $type->name}}/{{ $list_page->id }}/thumbnail/{{ $list_page->file->filename }} @endif" alt=""/>
                        </a>
                    @endif

                    <button type="button" class="btn btn-xs btn-delete-image" onclick="deleteFile({{ $list_page->id }})">
                        <i class="fa fa-times fa-2x"></i>
                    </button>
                </div>
            @else
                 <div class="image-margin"> 
                    <img class="selected-img" src="">

                    <button type="button" class="btn btn-xs btn-delete-image" onclick="removeImage()">
                        <i class="fa fa-times fa-2x"></i>
                    </button>
                </div>
            @endif
            <input type="file" name="file_id" class="form-control input_image" accept="image/*,application/pdf">

            @if ($errors->has('file_id'))
                <span class="help-block">
                <strong>{{ $errors->first('file_id') }}</strong>
            </span>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('category_id', 'Category', ['class' => 'control-label']) !!}

            {!! Form::select("category_id", $categories, null, ['class' => 'form-control custom-select', 'placeholder' => 'Select the category']) !!}

            @if ($errors->has('category_id'))
                <div class="ui pointing red basic label"> {{$errors->first('category_id')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('tags') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('tags', 'Tags', ['class' => 'control-label']) !!}

            {!! Form::select('tags[]', $tags, null, ['class' => 'form-control custom-select', 'multiple' => 'multiple', 'data-placeholder' => 'Select tag']) !!}

            @if ($errors->has('tags'))
                <div class="ui pointing red basic label"> {{$errors->first('tags')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('status') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('status', 'Status', ['class' => 'control-label']) !!}
            <div>
                <label class="toggle-switch">
                    {!! Form::checkbox('status', null, isset($list_page->status) ? $list_page->status : 1) !!}
                    <span class="toggle-slider round"></span>
                </label>
            </div>
            
            @if ($errors->has('status'))
                <div class="ui pointing red basic label"> {{$errors->first('status')}}</div>
            @endif
        </div>
    </div>
</div>