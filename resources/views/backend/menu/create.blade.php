@extends('layouts.backend')

@section('title')
  Create Menu
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> Menu
                    <small class="font-green sbold">Create</small>
                </h1>
            </div>
        </div>
    </div>
    {!! Form::model(null, ['method' => 'post', 'route' => ['menus.store']]) !!}
        <div class="portlet-body">
    
            @include('backend.menu._form')
        
        </div>

        <div class="portlet-footer">
            <div class="form-group">
                <a href="{{ route('menus.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
                Back</a>

                <button class="btn btn-primary green" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Save
                </button>
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@section('backend-script')
    <script type="text/javascript">

        $(document).ready(function() {
            @if(!empty(old('has_sub_menu')) && old('has_sub_menu') == true)
                $('#menu_for_div').hide();
            @else
                $('#menu_for_div').show();
            @endif
        });


        $('#has_sub_menu').click(function () {
            if($(this).prop("checked") == true){
                $('#menu_for_div').hide();
                $('#menu_for').val('');
            }
            else if($(this).prop("checked") == false){
                $('#menu_for_div').show();
            }
        });
    </script>
@endsection