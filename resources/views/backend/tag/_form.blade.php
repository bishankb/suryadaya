<div class="row">
     <div class="col-md-12">
        <div class="form-group required {{ $errors->has('page_type') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('page_type', 'Page Type', ['class' => 'control-label']) !!}

            {!! Form::select("page_type", $page_types, null, ['class' => 'form-control custom-select', 'placeholder' => 'Select the Page Type', 'required' => 'required']) !!}

            @if ($errors->has('page_type'))
                <div class="ui pointing red basic label"> {{$errors->first('page_type')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group required {{ $errors->has('name') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}

            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Name']) !!}

            @if ($errors->has('name'))
                <div class="ui pointing red basic label"> {{$errors->first('name')}}</div>
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
                    {!! Form::checkbox('status', null, isset($tag->status) ? $tag->status : 1) !!}
                    <span class="toggle-slider round"></span>
                </label>
            </div>
            
            @if ($errors->has('status'))
                <div class="ui pointing red basic label"> {{$errors->first('status')}}</div>
            @endif
        </div>
    </div>
</div>