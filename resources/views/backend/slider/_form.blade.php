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

            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder'=>'Description', 'rows' => 3]) !!}

            @if ($errors->has('description'))
                <div class="ui pointing red basic label"> {{$errors->first('description')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('slider_image_id') ? ' has-error' : '' }} clearfix">
            <label class="control-label" for="slider_image_id">Image
                <span style="color: red; font-size: 13px;">(Note: 1170 x 500)</span>
            </label>
            @if(isset($slider->image))
                <div class="show-image">
                    <a href="@if(isset($slider->image)) /storage/media/slider/{{ $slider->id }}/{{ $slider->image->filename }} @endif" data-lightbox="image">
                        <img class="custom-thumbnail selected-img" src="@if(isset($slider->image)) /storage/media/slider/{{$slider->id}}/thumbnail/{{$slider->image->filename}} @endif" class="custom-thumbnail">
                    </a>

                    <button type="button" class="btn btn-xs btn-delete-image" onclick="deleteImage({{ $slider->id }})">
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
            {!! Form::file('slider_image_id', ['class' => 'form-control input_image', 'accept' => 'image/*']) !!}

            @if ($errors->has('slider_image_id'))
                <span class="help-block">
                <strong>{{ $errors->first('slider_image_id') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('status') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('status', 'Status', ['class' => 'control-label']) !!}
            <div>
                <label class="toggle-switch">
                    {!! Form::checkbox('status', null, isset($slilder->status) ? $slilder->status : 1) !!}
                    <span class="toggle-slider round"></span>
                </label>
            </div>
            
            @if ($errors->has('status'))
                <div class="ui pointing red basic label"> {{$errors->first('status')}}</div>
            @endif
        </div>
    </div>
</div>