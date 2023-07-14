@extends('layouts.backend')

@section('title')
  Edit Role
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> Role
                    <small class="font-green sbold">Edit</small>
                </h1>
            </div>
        </div>
    </div>
    {!! Form::model($role, ['method' => 'PUT', 'route' => ['roles.update',  $role->id ]]) !!}
        <div class="portlet-body">
           
            @include('backend.roles._form')

            @if($role->name === 'admin')
                @include('backend.roles._permissions', [
                    'title' => 'Permissions',
                    'options' => ['disabled']
                ])
            @else
                @include('backend.roles._permissions', [
                    'title' => 'Permissions',
                    'model' => $role
                ])
            @endif
        </div>

        <div class="portlet-footer">
            <div class="form-group">
                <a href="{{ route('roles.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
                Back</a>

                <button class="btn btn-primary green" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Update
                </button>
            </div>
        </div>
    {!! Form::close() !!}
@endsection