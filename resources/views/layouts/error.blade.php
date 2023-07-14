<!DOCTYPE HTML>
<html>
<head>
	<title>Error Page</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="{{ mix('/css/error.css') }}" rel="stylesheet" type="text/css">
	<link href='//fonts.googleapis.com/css?family=Fenix' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon"/>
</head>
<body>
  <div class="wrap">

	@yield('content')
	
	<div class="footer">
		<p>&copy; {{ date('Y') }} {{ env('APP_NAME') }}. All Rights Reserved</p>
    </div>
    
  </div>
</body>
</html>

