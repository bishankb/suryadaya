@extends('layouts.auth')

@section('title')
    Admin Login
@endsection

@section('content')
    <h3 class="form-title font-green">Admin Log In</h3>
    <form class="login-form" action="{{ route('login') }}" method="POST">
        {{ csrf_field() }}

        @if(session()->has('error_message'))
            <div class="alert alert-danger alert-dismissable">
                <strong>{{ session()->get('error_message') }}</strong>
            </div>
        @endif

        @if (isset($errors) && count($errors) > 0)
            <div class="alert alert-danger alert-dismissable">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9" for="email">Email</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Email"
            name="email"/>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password"/>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn green uppercase">Login</button>
            <a class="forget-password" href="{{ route('password.request') }}">
                Forgot Password?
            </a>
        </div>
        <div class="create-account">
            <p>
            </p>
        </div>
    </form>
@endsection