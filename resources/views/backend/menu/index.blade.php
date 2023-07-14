@extends('layouts.backend')

@section('title')
  Menus
@endsection

@section('content')
  <div class="portlet-title">
    <div class="alert alert-success" id="status-change-alert">
      Status Changed Sucessfully.
    </div>
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> Menus
          <small class="font-green sbold">List</small>
        </h1>
      </div>
      @can('add_menus')
        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="caption pull-right">
            <a href="{{ route('menus.create') }}" class="btn btn-sm bold green">
              <i class="fa fa-plus"></i> Add New
            </a>
          </div>
        </div>
      @endcan

      @include('backend.menu._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered" id="pi-academy-transaction">
      <thead>
        <tr>
          <th>#</th>
          <th>
            <a href="{{ route('menus.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'name-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Name

            <a href="{{ route('menus.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'name-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>

          </th>

          <th>Position</th>
          <th>Menu For</th>

          <th>
            <a href="{{ route('menus.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'order-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Order
              
            <a href="{{ route('menus.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'order-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>

          <th>Created By</th>
          <th>Updated By</th>
          <th class="text-center">Status</th>
          @if(auth()->user()->can('edit_menus') || auth()->user()->can('delete_menus'))
            <th class="text-center">Actions</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @forelse($menus as $menu)
          <tr>
            <td>{{ pagination($menus, $loop) }}</td>                      
            <td>{{ $menu->name }}</td>
            <td>
              @isset($menu)
                  @php
                    $positionsData = explode(",", $menu->positions);
                  @endphp
              @endisset
              @foreach($positionsData as $position)
                <span class="badge badge-danger">{{ $positions[$position] }}</span> 
              @endforeach
            </td>
            <td>
              @if($menu->has_sub_menu == 1)
                Sub Menu
              @else
                {{ $menu_for_lists[$menu->menu_for] }}
              @endif
            </td>
            <td>{{ $menu->order }}</td>
            <td>{{ $menu->createdBy->name }}</td>
            <td>{{ $menu->updatedBy->name }}</td>
            @can('edit_menus')
              <td class="text-center">
                <label class="toggle-switch">
                  <input type="checkbox" class="changeStatus{{$menu->id}}" @if($menu->status == 1) checked @endif>
                  <span class="toggle-slider round"></span>
                </label>
              </td>
            @else
              <td class="text-center">
                @if($menu->status == 1)
                  <span style="font-size: 12px;" class="label label-success">Active</span>
                @else
                  <span style="font-size: 12px;" class="label label-danger">Inactive</span>
                @endif
              </td>
            @endif
            @if(auth()->user()->can('view_menus') || auth()->user()->can('edit_menus') || auth()->user()->can('delete_menus'))
              <td class="text-center">
                @can('edit_menus')
                  <a href="{{ route('menus.edit', $menu->id) }}"
                     class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                    <i class="fa fa-edit"></i>
                  </a>
                @endcan
                @can('delete_menus')
                  @if($menu->deleted_at == null)
                    {!! Form::open(['route' => ['menus.destroy', $menu->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-delete"
                          title="Delete"
                      >
                        <i class="fa fa-trash-o"></i>
                      </button>
                    {!! Form::close() !!}
                  @else
                    {!! Form::open(['route' => ['menus.restore', $menu->id], 'method' => 'POST', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-restore"
                          title="Restore"
                      >
                        <i class="fa fa-recycle"></i>
                      </button>
                    {!! Form::close() !!}

                    {!! Form::open(['route' => ['menus.forceDestroy', $menu->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
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
            <td colspan="8">No data available in table</td>
          </tr>
        @endforelse
      </tbody>
      </table>
    </div>
  </div>
  <div class="portlet-footer text-center">
    {{ $menus->appends(request()->input())->links() }}    
  </div>
@endsection

@section('backend-script')
  <script type="text/javascript">
    $(document).ready(function(){
      @foreach($menus as $menu)
        $('.changeStatus'+'{{$menu->id}}').click(function () {
          var menuId = {{$menu->id}};
          var val = $(this).prop('checked') == false ? 0 : 1;
          $.ajax({
            type     : "POST",
            headers  : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url      : "{{route('menus.changeStatus', '')}}/"+menuId,
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