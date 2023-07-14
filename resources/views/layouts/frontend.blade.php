<!DOCTYPE html>
<html lang="en">
<head>
  {!! SEOMeta::generate() !!}
  {!! OpenGraph::generate() !!}
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon"/>

  <link href="{{ mix('/css/frontend.css') }}" rel="stylesheet" type="text/css">

  @yield('frontend-style')

  <!-- Google Ads -->
  @if(config('suryadaya.ads_on') == 1)
      <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
      <script>
           (adsbygoogle = window.adsbygoogle || []).push({
                google_ad_client: "ca-pub-2766564597649639",
                enable_page_level_ads: true
           });
      </script>
  @endif

  <!-- Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-137445489-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-137445489-1');
  </script>
</head>

<body>
  <div id="fb-root"></div>
  <div class="container-fluid">
    
    @include('frontend.partials.top-header')
    
    @include('frontend.partials.top-navbar')

    @include('frontend.partials.bottom-navbar')

    @if( Route::currentRouteName() == 'frontend.home')
      @include('frontend.partials.home-slider-notice')
    @endif

    <br/>


    <div class="container">
      <div class="row">
        <div class="col-md-8">
          @yield('content')
        </div>

        <div class="col-md-4">
          @include('frontend.partials.sidebar')
        </div>
      </div>
    </div>
  </div>

  @include('frontend.partials.footer')

  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.3"></script>
  <script src="{{ mix('/js/frontend.js') }}"></script>

  @yield('frontend-script')

  <script>
      $(document).ready(function(){
          @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch(type){
              case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;
                  
              case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;

              case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

              case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
            }
          @endif
      });
  </script>
</body>
</html>
