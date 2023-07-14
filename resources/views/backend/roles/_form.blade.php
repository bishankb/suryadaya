<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('name') ? ' has-error' : '' }} clearfix">
            {!! Form::label('display_name', 'Display Name', ['class' => 'control-label']) !!}

            {!! Form::text('display_name', null, ['class' => 'form-control', 'placeholder'=>'Display Name'  ]) !!}

            @if ($errors->has('display_name'))
                <div class="ui pointing red basic label"> {{$errors->first('display_name')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('name') ? ' has-error' : '' }} clearfix">
            {!! Form::label('name', 'Identifier (Used Internally)', ['class' => 'control-label']) !!}

            @isset($role->name)
                {!! Form::text('name', null, ['class' => 'form-control', 'disabled' => 'disabled', 'placeholder'=>'Name' ]) !!}
            @else
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder'=>'Name' ]) !!}
            @endisset

            @if ($errors->has('name'))
                <div class="ui pointing red basic label"> {{$errors->first('name')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }} clearfix">
            {!! Form::label('description', 'Description', ['class' => 'control-label']) !!}

            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => "3", 'placeholder'=>'Description'  ]) !!}

            @if ($errors->has('description'))
                <div class="ui pointing red basic label"> {{$errors->first('description')}}</div>
            @endif
        </div>
    </div>
</div>
