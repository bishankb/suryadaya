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
            <label class="control-label" for="file_id">File
                <span style="color: red; font-size: 13px;">(Note: 500 x 45 only for zerone ads)</span>
            </label>
            @if(isset($single_page->file))
                <div class="show-image">
                    @if($single_page->file->extension == 'pdf')
                        <a href="@if(isset($single_page->file)) /storage/media/{{ $single_page->name}}/{{ $single_page->id }}/{{ $single_page->file->filename }} @endif">
                            <img  class="custom-thumbnail selected-img" src="@if(isset($single_page->file)) {{ asset('images/pdf-logo.jpg') }} @endif" alt=""/>
                        </a>
                    @else
                        <a href="@if(isset($single_page->file)) /storage/media/{{ $single_page->name}}/{{ $single_page->id }}/{{ $single_page->file->filename }} @endif" data-lightbox="image">
                            <img  class="custom-thumbnail selected-img" src="@if(isset($single_page->file)) /storage/media/{{ $single_page->name}}/{{ $single_page->id }}/thumbnail/{{ $single_page->file->filename }} @endif" alt=""/>
                        </a>
                    @endif

                    <button type="button" class="btn btn-xs btn-delete-image" onclick="deleteFile({{ $single_page->id }})">
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

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('menu_id') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('menu_id', 'Menu', ['class' => 'control-label']) !!}

            <select name = "menu_id" class="form-control custom-select" placeholder = "Select the menu" style="width: 100%">
                <option></option>
                @foreach($menus as $menu)
                    @if(old('menu_id') != null)
                        <option value = "{{ $menu->id }}" @if($menu->id == old('menu_id')) selected @endif>
                            {{ $menu->name }} @if($menu->has_sub_menu == 0) (Primary Menu) @elseif($menu->has_sub_menu == 1) (Sub Menu) @endif
                        </option>
                    @elseif(isset($single_page->menu_id))
                        <option value = "{{ $menu->id }}" @if($single_page->menu_id == $menu->id) selected @endif>
                            {{ $menu->name }} @if($menu->has_sub_menu == 0) (Primary Menu) @elseif($menu->has_sub_menu == 1) (Sub Menu) @endif
                        </option>
                    @else
                        <option value = "{{ $menu->id }}">
                            {{ $menu->name }} @if($menu->has_sub_menu == 0) (Primary Menu) @elseif($menu->has_sub_menu == 1) (Sub Menu) @endif
                        </option>
                    @endif
                @endforeach
            </select>

            @if ($errors->has('menu_id'))
                <div class="ui pointing red basic label"> {{$errors->first('menu_id')}}</div>
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
                    {!! Form::checkbox('status', null, isset($single_page->status) ? $single_page->status : 1) !!}
                    <span class="toggle-slider round"></span>
                </label>
            </div>
            
            @if ($errors->has('status'))
                <div class="ui pointing red basic label"> {{$errors->first('status')}}</div>
            @endif
        </div>
    </div>
</div>