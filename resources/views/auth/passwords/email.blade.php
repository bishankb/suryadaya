@extends('layouts.auth')

@section('title')
  Reset Password
@endsection

@section('content')
  <form class="form-horizontal" action="{{ route('password.email') }}" method="POST">
    {{ csrf_field() }}
    
    <h3 class="form-title font-green">Reset Password</h3>
    @if (session('status'))
      <div class="alert alert-dismissable alert-success form-group">
        {{ session('status') }}
      </div>
    @endif

    @if (isset($errors) && count($errors) > 0)
      <div class="alert alert-dismissable alert-danger form-group">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="form-group">
      <label class="control-label visible-ie8 visible-ie9" for="email">Email</label>
      <input class="form-control form-control-solid placeholder-no-fix"
             type="text"
             autocomplete="off"
             placeholder="Email"
             name="email"
             value="{{ old('email') }}"
      />
    </div>
    <div class="form-group">
      <div class="form-actions">
        <a href="{{ route('login') }}"
           class="btn green btn-outline">Back</a>
        <button type="submit" class="btn green uppercase pull-right">Submit</button>
      </div>
    </div>
  </form>
@endsection
