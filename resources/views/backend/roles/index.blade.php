@extends('layouts.backend')

@section('title')
  Role
@endsection

@section('content')
  <div class="portlet-title">
    <div class="alert alert-success" id="status-change-alert">
      Status Changed Sucessfully.
    </div>
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
        <h1 class="page-title font-green sbold">
          <i class="fa fa-television font-green"></i> Roles
          <small class="font-green sbold">List</small>
        </h1>
      </div>
      @can('add_roles')
        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="caption pull-right">
            <a href="{{ route('roles.create') }}" class="btn btn-sm bold green">
              <i class="fa fa-plus"></i> Add new Role
            </a>
          </div>
        </div>
      @endcan
    </div>
  </div>
  <div class="portlet-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Display Name</th>
            <th>Identifier</th>
            @if(auth()->user()->can('edit_roles') || auth()->user()->can('delete_roles'))
              <th class="text-center">Actions</th>
            @endif
          </tr>
        </thead>
        <tbody>
        @forelse($roles as $role)
          <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{ $role->display_name }}</td>
            <td>{{ $role->name }}</td>
            @if(auth()->user()->can('edit_roles') || auth()->user()->can('delete_roles'))
              <td class="text-center">
                @can('edit_roles')
                  <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                    <i class="fa fa-edit"></i>
                  </a>
                @endcan

                @can('delete_roles')
                  {!! Form::open(['route' => ['roles.destroy', $role->id], 'method' => 'DELETE', 'class' => 'form-edit-button']) !!}
                      <button class="btn btn-sm red btn-outline filter-submit margin-bottom mt-sweetalert-delete" title="Delete"
                      >
                        <i class="fa fa-trash-o"></i>
                      </button>
                    {!! Form::close() !!}
                @endcan
              </td>
            @endif
          </tr>
        @empty
          <tr class="text-center">
            <td colspan="4">No data available in table</td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="portlet-footer text-center">
    {{ $roles->appends(request()->input())->links() }}    
  </div>
@endsection
