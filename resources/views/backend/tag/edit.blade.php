@extends('layouts.backend')

@section('title')
  Edit Tag
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> Tag
                    <small class="font-green sbold">Edit</small>
                </h1>
            </div>
        </div>
    </div>
    {!! Form::model($tag, ['method' => 'PUT', 'route' => ['tags.update',  $tag->id ], 'files' => 'true']) !!}
        <div class="portlet-body">
           
            @include('backend.tag._form')

        </div>

        <div class="portlet-footer">
            <div class="form-group">
                <a href="{{ route('tags.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
                Back</a>

                <button class="btn btn-primary green" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Update
                </button>
            </div>
        </div>
    {!! Form::close() !!}
@endsection