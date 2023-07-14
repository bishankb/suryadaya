@extends('layouts.backend')

@section('title')
    Dashboard
@endsection

@section('content')
	<div class="container-fluid">
	    <h4>Welcome to Admin Panel of {{ env('APP_Name') }}</h4>
	</div>
@endsection
