@extends('layouts.backend')

@section('title')
  {{ $type->name }}
@endsection

@section('content')
  <div class="portlet-title">
    <div class="alert alert-success" id="status-change-alert">
      Status Changed Sucessfully.
    </div>
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> {{ $type->name }}
          <small class="font-green sbold">List</small>
        </h1>
      </div>
      @can('add_list_pages')
        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="caption pull-right">
            <a href="{{ route('list-page.create', $type->slug ) }}" class="btn btn-sm bold green">
              <i class="fa fa-plus"></i> Add new
            </a>
          </div>
        </div>
      @endcan

      @include('backend.list-page._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
          <th>#</th>
          <th>
            <a href="{{ route('list-page.index', array_merge(Request::all(), ['page_type' => $type->slug, 'sort_by' => 'criteria', 'criteria' => 'name-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Name

            <a href="{{ route('list-page.index', array_merge(Request::all(), ['page_type' => $type->slug, 'sort_by' => 'criteria', 'criteria' => 'name-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>

          </th>

          <th>
            <a href="{{ route('list-page.index', array_merge(Request::all(), ['page_type' => $type->slug, 'sort_by' => 'criteria', 'criteria' => 'order-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Order
              
            <a href="{{ route('list-page.index', array_merge(Request::all(), ['page_type' => $type->slug, 'sort_by' => 'criteria', 'criteria' => 'order-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>

          <th>Created By</th>
          <th>Updated By</th>
          <th class="text-center">Status</th>
          @if(auth()->user()->can('edit_list_pages') || auth()->user()->can('delete_list_pages'))
            <th class="text-center">Actions</th>
          @endif
        </tr>
        </thead>
        <tbody>
          @forelse($list_pages as $list_page)
            <tr>
              <td>
                @if($type->order_by == array_flip($order_by_lists)['Ascending Order'])
                  {{ pagination($list_pages, $loop) }}
                @else
                  {{ reversePagination($list_pages, $loop) }}
                @endif
              </td>                      
              <td>{{ $list_page->name }}</td>
              <td>{{ $list_page->order }}</td>
              <td>{{ $list_page->createdBy->name }}</td>
              <td>{{ $list_page->updatedBy->name }}</td>

              @can('edit_list_pages')
                <td class="text-center">
                  <label class="toggle-switch">
                    <input type="checkbox" data-route-name="{{ route('list-page.changeStatus', ['page_type' => $type->slug, 'id' => $list_page->id ]) }}" class="changeStatus{{$list_page->id}}" @if($list_page->status == 1) checked @endif>
                    <span class="toggle-slider round"></span>
                  </label>
                </td>
              @else
                <td class="text-center">
                  @if($list_page->status == 1)
                    <span style="font-size: 12px;" class="label label-success">Active</span>
                  @else
                    <span style="font-size: 12px;" class="label label-danger">Inactive</span>
                  @endif
                </td>
              @endif

              @if(auth()->user()->can('view_list_pages') || auth()->user()->can('edit_list_pages') || auth()->user()->can('delete_list_pages'))
                <td class="text-center">
                  @can('edit_list_pages')
                    <a href="{{ route('list-page.edit', ['page_type' => $type->slug, 'id' => $list_page->id ]) }}" class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                      <i class="fa fa-edit"></i>
                    </a>
                  @endcan
                  @can('delete_list_pages')
                    @if($list_page->deleted_at == null)
                      {!! Form::open(['route' => ['list-page.destroy', $type->slug, $list_page->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                        <button  class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-delete"
                            title="Delete">
                          <i class="fa fa-trash-o"></i>
                        </button>
                      {!! Form::close() !!}
                    @else
                      {!! Form::open(['route' => ['list-page.restore', $type->slug, $list_page->id], 'method' => 'POST', 'class' => 'form-edit-button']) !!}
                        <button
                            class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-restore"
                            title="Restore"
                        >
                          <i class="fa fa-recycle"></i>
                        </button>
                      {!! Form::close() !!}

                      {!! Form::open(['route' => ['list-page.forceDestroy', $type->slug, $list_page->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                        <button class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-force-delete"  title="Force Delete">
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
    {{ $list_pages->appends(request()->input())->links() }}
  </div>
@endsection

@section('backend-script')
  <script type="text/javascript">
    $(document).ready(function(){
      @foreach($list_pages as $list_page)
        $('.changeStatus'+'{{$list_page->id}}').click(function () {
          var singlePageId = {{$list_page->id}};
          var val = $(this).prop('checked') == false ? 0 : 1;
          var route_name = $(this).attr("data-route-name");
          $.ajax({
            type     : "POST",
            headers  : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url      : route_name,
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
