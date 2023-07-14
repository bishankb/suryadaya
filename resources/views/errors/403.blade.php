@extends('layouts.error')

@section('content')
	<div class="main">
		<h3>{{ env('APP_NAME') }}</h3>
		<h1>403 ERROR</h1>
		<p>You don't have permission to access on this server.<br>
			<span>Don't waste your time enjoying the look of it</span>
		</p>
    </div>
@endsection