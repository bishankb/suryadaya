@extends('layouts.backend')

@section('title')
  Galleries
@endsection

@section('content')
  <div class="portlet-title">
    <div class="alert alert-success" id="status-change-alert">
      Status Changed Sucessfully.
    </div>
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> Galleries
          <small class="font-green sbold">List</small>
        </h1>
      </div>
      @can('add_galleries')
        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="caption pull-right">
            <a href="{{ route('galleries.create') }}" class="btn btn-sm bold green">
              <i class="fa fa-plus"></i> Add New
            </a>
          </div>
        </div>
      @endcan

      @include('backend.gallery._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered" id="pi-academy-transaction">
      <thead>
        <tr>
          <th>#</th>
          <th>
            <a href="{{ route('galleries.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'name-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Name

            <a href="{{ route('galleries.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'name-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>

          </th>

          @can('edit_galleries')
            <th>Images</th>
          @endcan

          <th>
            <a href="{{ route('galleries.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'order-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Order
              
            <a href="{{ route('galleries.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'order-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>

          <th>Created By</th>
          <th>Updated By</th>
          <th class="text-center">Status</th>
          @if(auth()->user()->can('edit_galleries') || auth()->user()->can('delete_galleries'))
            <th class="text-center">Actions</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @forelse($galleries as $gallery)
          <tr>
            <td>{{ pagination($galleries, $loop) }}</td>                      
            <td>{{ $gallery->name }}</td>
            @can('edit_galleries')
              <td>
                <a href="{{route('galleries.addImages', $gallery->slug)}}">Manage</a>
              </td>
            @endcan
            <td>{{ $gallery->order }}</td>
            <td>{{ $gallery->createdBy->name }}</td>
            <td>{{ $gallery->updatedBy->name }}</td>
            @can('edit_galleries')
              <td class="text-center">
                <label class="toggle-switch">
                  <input type="checkbox" class="changeStatus{{$gallery->id}}" @if($gallery->status == 1) checked @endif>
                  <span class="toggle-slider round"></span>
                </label>
              </td>
            @else
              <td class="text-center">
                @if($gallery->status == 1)
                  <span style="font-size: 12px;" class="label label-success">Active</span>
                @else
                  <span style="font-size: 12px;" class="label label-danger">Inactive</span>
                @endif
              </td>
            @endif
            @if(auth()->user()->can('view_galleries') || auth()->user()->can('edit_galleries') || auth()->user()->can('delete_galleries'))
              <td class="text-center">
                @can('edit_galleries')
                  <a href="{{ route('galleries.edit', $gallery->id) }}"
                     class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                    <i class="fa fa-edit"></i>
                  </a>
                @endcan
                @can('delete_galleries')
                  @if($gallery->deleted_at == null)
                    {!! Form::open(['route' => ['galleries.destroy', $gallery->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-delete"
                          title="Delete"
                      >
                        <i class="fa fa-trash-o"></i>
                      </button>
                    {!! Form::close() !!}
                  @else
                    {!! Form::open(['route' => ['galleries.restore', $gallery->id], 'method' => 'POST', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-restore"
                          title="Restore"
                      >
                        <i class="fa fa-recycle"></i>
                      </button>
                    {!! Form::close() !!}

                    {!! Form::open(['route' => ['galleries.forceDestroy', $gallery->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
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
    {{ $galleries->appends(request()->input())->links() }}    
  </div>
@endsection

@section('backend-script')
  <script type="text/javascript">
    $(document).ready(function(){
      @foreach($galleries as $gallery)
        $('.changeStatus'+'{{$gallery->id}}').click(function () {
          var galleryId = {{$gallery->id}};
          var val = $(this).prop('checked') == false ? 0 : 1;
          $.ajax({
            type     : "POST",
            headers  : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url      : "{{route('galleries.changeStatus', '')}}/"+galleryId,
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