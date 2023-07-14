@extends('layouts.backend')

@section('title')
  User
@endsection

@section('content')
  <div class="portlet-title">
    <div class="alert alert-success" id="status-change-alert">
      Status Changed Sucessfully.
    </div>
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> Users
          <small class="font-green sbold">List</small>
        </h1>
      </div>
      @can('add_users')
        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="caption pull-right">
            <a href="{{ route('users.create') }}" class="btn btn-sm bold green">
              <i class="fa fa-plus"></i> Add new User
            </a>
          </div>
        </div>
      @endcan

      @include('backend.user._filter')

    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>
            <a href="{{ route('users.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'name-high-low'])) }}" style="margin-right: 5px;">
              <i class="fa fa-arrow-up"></i>
            </a>

              Name

            <a href="{{ route('users.index', array_merge(Request::all(), ['sort_by' => 'criteria', 'criteria' => 'name-low-high'])) }}" style="margin-left: 5px;"> 
              <i class="fa fa-arrow-down"></i>
            </a>
          </th>
          <th>Role</th>
          <th>Created By</th>
          <th>Updated By</th>
          <th class="text-center">Active</th>
          <th>Created At</th>
          @if(auth()->user()->can('edit_users') || auth()->user()->can('delete_users'))
            <th class="text-center">Actions</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
          <tr>
            <td>{{ pagination($users, $loop) }}</td>                      
            <td>{{$user->name}}</td>
            <td>
              @isset($user->role)
                {{$user->role->display_name}}
              @endisset
            </td>
            <td>{{$user->createdBy->name }}</td>
            <td>{{$user->updatedBy->name }}</td>
            @if(auth()->user()->can('edit_users'))
              <td class="text-center">
                <label class="toggle-switch">
                  <input type="checkbox" class="changeStatus{{$user->id}}" @if($user->active == 1) checked @endif>
                  <span class="toggle-slider round"></span>
                </label>
              </td>
            @else
              <td class="text-center">
                @if($user->active == 1)
                  <span style="font-size: 12px;" class="label label-success">Active</span>
                @else
                  <span style="font-size: 12px;" class="label label-danger">Inactive</span>
                @endif
              </td>
            @endif
            <td>
              {{$user->created_at->format('d M, Y')}}<br>
              {{$user->created_at->format('h:m:s a')}}
            </td>
            @if(auth()->user()->can('edit_users') || auth()->user()->can('delete_users'))
              <td class="text-center"Username>
                @can('edit_users')
                  <a href="{{ route('users.edit', $user->id) }}"
                     class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                    <i class="fa fa-edit"></i>
                  </a>
                @endcan
                @can('delete_users')
                  @if($user->deleted_at == null)
                    {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-delete"
                          title="Delete"
                      >
                        <i class="fa fa-trash-o"></i>
                      </button>
                    {!! Form::close() !!}
                  @else
                    {!! Form::open(['route' => ['users.restore', $user->id], 'method' => 'POST', 'class' => 'form-edit-button']) !!}
                      <button
                          class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-restore"
                          title="Restore"
                      >
                        <i class="fa fa-recycle"></i>
                      </button>
                    {!! Form::close() !!}

                    {!! Form::open(['route' => ['users.forceDestroy', $user->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
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
    {{ $users->appends(request()->input())->links() }}    
  </div>
@endsection

@section('backend-script')
  <script type="text/javascript">
    $(document).ready(function(){
      @foreach($users as $user)
        $('.changeStatus'+'{{$user->id}}').click(function () {
          var userId = {{$user->id}};
          var val = $(this).prop('checked') == false ? 0 : 1;
          $.ajax({
            type     : "POST",
            headers  : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url      : "{{route('users.changeStatus', '')}}/"+userId,
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