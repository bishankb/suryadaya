<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('password') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('password', 'New Password', ['class' => 'control-label']) !!}

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

            @if ($errors->has('password'))
                <div class="ui pointing red basic label"> {{$errors->first('password_confirmation')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="portlet-footer">
    <div class="form-group">
        <a href="{{ route('users.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
        Back</a>

        <button class="btn btn-primary green" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Change Password
        </button>
    </div>
</div>