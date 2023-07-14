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

            @if(Auth::user()->id == $user->id || Auth::user()->hasRole('admin'))
                {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Email' ]) !!}
            @else
                {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'disabled' => 'disabled', 'placeholder'=>'Email' ]) !!}
            @endif

            @if ($errors->has('email'))
                <div class="ui pointing red basic label"> {{$errors->first('email')}}</div>
            @endif
        </div>
    </div>
</div>

@hasrole('admin')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group required {{ $errors->has('role') ? ' has-error' : '' }} clearfix ">
                {!! Form::label('role', 'Role', ['class' => 'control-label']) !!}

                <select name = "role" class="form-control">
                    <option disabled selected>Please select an option</option>
                    @foreach($roles as $role)
                        @if(isset($user->role_id))
                            <option value = "{{ $role->id }}" @if($user->role_id == $role->id) selected @endif>
                                {{$role->display_name}}
                            </option>
                        @elseif(old('role') != null)
                            <option value = "{{ $role->id }}" @if($role->id == old('role')) selected @endif>
                                {{$role->display_name}}
                            </option>
                        @else
                            <option value = "{{ $role->id }}">
                                {{$role->display_name}}
                            </option>
                        @endif
                    @endforeach
                </select>

                @if ($errors->has('role'))
                    <div class="ui pointing red basic label"> {{$errors->first('role')}}</div>
                @endif
            </div>
        </div>
    </div>
@endhasrole

<div class="form-group {{ $errors->has('active') ? ' has-error' : '' }} clearfix ">
    {!! Form::label('active', 'Active', ['class' => 'control-label']) !!}
    <div>
        <label class="toggle-switch">
            {!! Form::checkbox('active', null, isset($user->active) ? $user->active : 1) !!}
            <span class="toggle-slider round"></span>
        </label>
    </div>
    
    @if ($errors->has('active'))
        <div class="ui pointing red basic label"> {{$errors->first('active')}}</div>
    @endif
</div>

<div class="portlet-footer">
    <div class="form-group">
        <a href="{{ route('users.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
        Back</a>

        <button class="btn btn-primary green" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Update
        </button>
    </div>
</div>

