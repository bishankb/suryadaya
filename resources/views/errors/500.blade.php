@extends('layouts.error')

@section('content')
  	<div class="main">
	    <h3>{{ env('APP_NAME') }}</h3>
	    <h1>500 ERROR</h1>
	    <p>Internal Server Error, Try refreshing the page.<br>
	      <span>Don't waste your time enjoying the look of it</span>
	    </p>
    </div>
@endsection