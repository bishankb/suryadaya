<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon"/>
<title></title>
<body>
	<p>You got new message from <strong>{{ $viewer_message->name }}</strong> at {{ $viewer_message->email }}</p>
	<p><strong>Name:</strong> {{ $viewer_message->name }}</p>
    <p><strong>Email:</strong> {{ $viewer_message->email }}</p>
    @isset($viewer_message->phone)
    	<p><strong>Phone Number:</strong> {{ $viewer_message->phone }}</p>
    @endisset
    @isset($viewer_message->address)
        <p><strong>Address:</strong> {{ $viewer_message->address }}</p>
    @endisset
	@isset($viewer_message->subject)
    	<p><strong>Subject:</strong> {{ $viewer_message->subject }}</p>
    @endisset  
    <p><strong>Message:</strong> {{ $viewer_message->message }}</p>
    <p>
        <strong>Please review the mail and reply at </strong>
        <a href="mailto:{{ $viewer_message->email }}">{{ $viewer_message->email }}</a>
    </p>
</body>
