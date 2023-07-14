<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('name') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}

            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Name' ]) !!}

            @if ($errors->has('name'))
                <div class="ui pointing red basic label"> {{$errors->first('name')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('email') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}

            {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Email' ]) !!}

            @if ($errors->has('email'))
                <div class="ui pointing red basic label"> {{$errors->first('email')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('password') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('password', 'Password', ['class' => 'control-label']) !!}

            {!! Form::password('password', ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Password' ]) !!}

            @if ($errors->has('password'))
                <div class="ui pointing red basic label"> {{$errors->first('password')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('password_confirmation') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('password_confirmation', 'Confirm Password', ['class' => 'control-label']) !!}

            {!! Form::password('password_confirmation', ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Confirm Password' ]) !!}

            @if ($errors->has('password_confirmation'))
                <div class="ui pointing red basic label"> {{$errors->first('password_confirmation')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="form-group {{ $errors->has('active') ? ' has-error' : '' }} clearfix ">
    {!! Form::label('active', 'Active', ['class' => 'control-label']) !!}
    <div>
        <label class="toggle-switch">
            {!! Form::checkbox('active', null, 1) !!}
            <span class="toggle-slider round"></span>
        </label>
    </div>
    
    @if ($errors->has('active'))
        <div class="ui pointing red basic label"> {{$errors->first('active')}}</div>
    @endif
</div>
