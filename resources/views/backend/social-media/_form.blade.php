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
        <div class="form-group {{ $errors->has('url') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('url', 'Url', ['class' => 'control-label']) !!}

            {!! Form::text('url', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Url']) !!}

            @if ($errors->has('url'))
                <div class="ui pointing red basic label"> {{$errors->first('url')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('image_id') ? ' has-error' : '' }} clearfix">
            <label class="control-label" for="image_id">Image
                <span style="color: red; font-size: 13px;">(Note: Round Image and 35 x 35)</span>
            </label>
            @if(isset($social_media->image))
                <div class="show-image">
                    <a href="@if(isset($social_media->image)) /storage/media/social-media/{{ $social_media->id }}/{{ $social_media->image->filename }} @endif" data-lightbox="image">
                        <img class="custom-thumbnail selected-img" src="@if(isset($social_media->image)) /storage/media/social-media/{{$social_media->id}}/thumbnail/{{$social_media->image->filename}} @endif" class="custom-thumbnail">
                    </a>

                    <button type="button" class="btn btn-xs btn-delete-image" onclick="deleteImage({{ $social_media->id }})">
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
            {!! Form::file('image_id', ['class' => 'form-control input_image', 'accept' => 'image/*']) !!}

            @if ($errors->has('image_id'))
                <span class="help-block">
                <strong>{{ $errors->first('image_id') }}</strong>
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