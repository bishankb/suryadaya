@extends('layouts.backend')

@section('title')
  Social Medias
@endsection

@section('content')
  <div class="portlet-title">
    <div class="alert alert-success" id="status-change-alert">
      Status Changed Sucessfully.
    </div>
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> Social Medias
          <small class="font-green sbold">List</small>
        </h1>
      </div>
      @can('add_social_medias')
        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="caption pull-right">
            <a href="{{ route('social-medias.create') }}" class="btn btn-sm bold green">
              <i class="fa fa-plus"></i> Add New
            </a>
          </div>
        </div>
      @endcan

      @include('backend.social-media._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered" id="pi-academy-transaction">
      <thead>
        <tr>
          <th>#</th>
          <th>
            <a href="{{ route('social-medias.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'name-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Name

            <a href="{{ route('social-medias.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'name-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>

          </th>

          <th>
            <a href="{{ route('social-medias.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'order-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Order
              
            <a href="{{ route('social-medias.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'order-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>

          <th>Created By</th>
          <th>Updated By</th>
          <th class="text-center">Status</th>
          @if(auth()->user()->can('edit_social_medias') || auth()->user()->can('delete_social_medias'))
            <th class="text-center">Actions</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @forelse($social_medias as $social_media)
          <tr>
            <td>{{ pagination($social_medias, $loop) }}</td>                      
            <td>{{ $social_media->name }}</td>
            <td>{{ $social_media->order }}</td>
            <td>{{ $social_media->createdBy->name }}</td>
            <td>{{ $social_media->updatedBy->name }}</td>
            @can('edit_social_medias')
              <td class="text-center">
                <label class="toggle-switch">
                  <input type="checkbox" class="changeStatus{{$social_media->id}}" @if($social_media->status == 1) checked @endif>
                  <span class="toggle-slider round"></span>
                </label>
              </td>
            @else
              <td class="text-center">
                @if($social_media->status == 1)
                  <span style="font-size: 12px;" class="label label-success">Active</span>
                @else
                  <span style="font-size: 12px;" class="label label-danger">Inactive</span>
                @endif
              </td>
            @endif
            @if(auth()->user()->can('view_social_medias') || auth()->user()->can('edit_social_medias') || auth()->user()->can('delete_social_medias'))
              <td class="text-center">
                @can('edit_social_medias')
                  <a href="{{ route('social-medias.edit', $social_media->id) }}"
                     class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                    <i class="fa fa-edit"></i>
                  </a>
                @endcan
                @can('delete_social_medias')
                  @if($social_media->deleted_at == null)
                    {!! Form::open(['route' => ['social-medias.destroy', $social_media->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-delete"
                          title="Delete"
                      >
                        <i class="fa fa-trash-o"></i>
                      </button>
                    {!! Form::close() !!}
                  @else
                    {!! Form::open(['route' => ['social-medias.restore', $social_media->id], 'method' => 'POST', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-restore"
                          title="Restore"
                      >
                        <i class="fa fa-recycle"></i>
                      </button>
                    {!! Form::close() !!}

                    {!! Form::open(['route' => ['social-medias.forceDestroy', $social_media->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-force-delete"
                          title="Force Delete"
                      >
                        <i class="fa fa-trash"></i>
                      </button>
                    {!! Form::close() !!}
                  @endif
                @endcan
              </td>
            @endif
          </tr>
        @empty
          <tr class="text-center">
            <td colspan="7">No data available in table</td>
          </tr>
        @endforelse
      </tbody>
      </table>
    </div>
  </div>
  <div class="portlet-footer text-center">
    {{ $social_medias->appends(request()->input())->links() }}    
  </div>
@endsection

@section('backend-script')
  <script type="text/javascript">
    $(document).ready(function(){
      @foreach($social_medias as $social_media)
        $('.changeStatus'+'{{$social_media->id}}').click(function () {
          var socialMediaId = {{$social_media->id}};
          var val = $(this).prop('checked') == false ? 0 : 1;
          $.ajax({
            type     : "POST",
            headers  : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url      : "{{route('social-medias.changeStatus', '')}}/"+socialMediaId,
            data     : {status: val},
            success: function(response){
              if (response.success) {
                $("#status-change-alert").show();
                $('#status-change-alert').delay(3000).fadeOut(1000);
              }
            },
            error: function(response){
              alert("There was some internal error while updating the status.");
              window.location.reload(); 
            },
          });
        });
      @endforeach
    });
  </script>
@endsection