<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>@yield('title') | {{ env('APP_NAME') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="author" />
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon"/>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{ mix('/css/auth.css') }}" rel="stylesheet" type="text/css">
  </head>

  <body class=" login">
    <div class="logo">
      <a href="{{ route('backend.dashboard') }}">
        <img src="" alt="" /> </a>
      </div>
      <div class="content">
        @yield('content')
    </div>
    <div class="copyright"> {{ date('Y') }} &copy;  {{ env('APP_NAME') }}  </div>
  </body>
</html>
