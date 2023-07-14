@extends('layouts.auth')

@section('title')
  Reset your admin Password | Fill Storage
@endsection

@section('content')
  <h3 class="form-title font-green">Reset Password</h3>
  @if (session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif
  <form class="form-horizontal" role="form" method="POST" action="{{ route('password.request') }}">
    {{ csrf_field() }}

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group">
      <label class="control-label visible-ie8 visible-ie9" for="email">Email</label>
      <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" required value="{{ $email or old('email') }}"/>
      @if ($errors->has('email'))
        <span class="help-block" style="color: red;">{{ $errors->first('email') }}</span>
      @endif
    </div>
    <div class="form-group">
      <label class="control-label visible-ie8 visible-ie9" for="password">Password</label>
      <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="New Password" name="password" required/>
      @if ($errors->has('password'))
        <span class="help-block" style="color: red;">{{ $errors->first('password') }}</span>
      @endif
    </div>
    <div class="form-group">
      <label class="control-label visible-ie8 visible-ie9" for="password">Password Confirmation</label>
      <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password Confirmation" name="password_confirmation" required/>
      @if ($errors->has('password_confirmation'))
        <span class="help-block" style="color: red;">{{ $errors->first('password_confirmation') }}</span>
      @endif
    </div>
    <div class="form-actions">
      <button type="submit" class="btn green uppercase">
        Reset Password
      </button>
    </div>
  </form>
@endsection
