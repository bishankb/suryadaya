<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>@yield('title') | {{ env('APP_NAME') }} Admin</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon"/>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
    type="text/css"/>
    
    <link href="{{ mix('/css/backend.css') }}" rel="stylesheet" type="text/css">

    @yield('backend-style')

</head>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-container-bg-solid">
    @include('backend.partials.navbar')
    <div class="clearfix"></div>
    <div class="page-container">
        @include('backend.partials.sidebar')
        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light">

                            @include('flash::message')
                            
                            @if($errors->any())
                                <div class="alert alert-dismissable alert-danger ">There seems validation error on your submission, Please check the form below.
                                </div>
                            @endif

                            @yield('content')

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-footer">
        <div class="page-footer-inner">{{ date('Y') }} &copy; {{ env('APP_NAME') }} </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('/plugins/ckeditor/ckeditor.js') }}"></script>

    <script src="{{ mix('/js/backend.js') }}"></script>

    @yield('backend-script')

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
            });
        });
    </script>

    <script>
        $("#english_date_picker").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        }).on("changeDate", function (e) {
            var selectedEnglishDate = $('#english_date_picker').val();
            var conversionType = $('#english_date_picker').attr('data-conversion-type');
            $.ajax({
                type     : "GET",
                headers  : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url      : "",
                data     : {conversion_type: conversionType},
                success: function(response){
                  if (response.success) {
                    $('#nepali_date_picker').val(response.converted_date);
                  }
                },
                error: function(response){
                    alert("There was some internal error.");
                    window.location.reload();
                },
            });
        });

        $("#nepali_date_picker").nepaliDatePicker({
            dateFormat: "%y-%m-%d",
            closeOnDateSelect: true,
            npdMonth: true,
            npdYear: true,
            onChange: function(){
                var selectedNepaliDate = $('#nepali_date_picker').val();
                var conversionType = $('#nepali_date_picker').attr('data-conversion-type');
                $.ajax({
                    type     : "GET",
                    headers  : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url      : "",
                    data     : {conversion_type: conversionType},
                    success: function(response){
                      if (response.success) {
                        $('#english_date_picker').val(response.converted_date);
                      }
                    },
                    error: function(response){
                      alert("There was some internal error.");
                      window.location.reload();
                    },
                });
            }
        });
    </script>
</body>
</html>
