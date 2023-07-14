<div class="filter">
  <label>&nbsp Filters: </label>
  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
      @if(request('deleted-items') != null)
        {{ request('deleted-items') }}
      @else
        Filter by Deleted Items
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('users.index') }}">
              Without Deleted
            </a>
        </li>
        <li>
          <a href="{{ route('users.index', array_merge(Request::all(), ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted'])) }}">
            Only Deleted
          </a>
        </li>
        <li>
          <a href="{{ route('users.index', array_merge(Request::all(), ['filter_by' => 'deleted-items', 'deleted-items' => 'All'])) }}">
            All
          </a>
        </li>
    </ul>
  </li>

  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
      @if(request('status') != null)
        {{ request('status') }}
      @else
        Filter by Status
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('users.index') }}">
                All
            </a>
        </li>
        <li>
          <a href="{{ route('users.index', array_merge(Request::all(), ['filter_by' => 'status', 'status' => 'Active'])) }}">
            Active
          </a>
        </li>
        <li>
          <a href="{{ route('users.index', array_merge(Request::all(), ['filter_by' => 'status', 'status' => 'Inactive'])) }}">
            Inactive
          </a>
        </li>
    </ul>
  </li>

  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
      @if(request('role') != null)
        {{ request('role') }}
      @else
        Filter by Roles
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('users.index') }}">
              All
            </a>
        </li>
        @foreach($roles as $role)
          <li>
            <a href="{{ route('users.index', array_merge(Request::all(), ['filter_by' => 'role', 'role' => $role->name ])) }}">
              {{ $role->display_name }}
            </a>
          </li>
        @endforeach
    </ul>
  </li>
</div>

<div class="show-search">
  <div class="show-records">
    <li class="dropdown dropdown-inline">
      <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
        @if(request('show-items') != null)
          {{ request('show-items') }}
        @else
          10
        @endif
        <span class="caret"></span>
      </button>
      records
      <ul class="dropdown-menu">
          <li>
              <a href="{{ route('users.index') }}">
                10 records
              </a>
          </li>
          <li>
              <a href="{{ route('users.index', array_merge(Request::all(), ['show-items' => 25])) }}">
                25 records
              </a>
          </li>
          <li>
              <a href="{{ route('users.index', array_merge(Request::all(), ['show-items' => 50])) }}">
                50 records
              </a>
          </li>
          <li>
              <a href="{{ route('users.index', array_merge(Request::all(), ['show-items' => 100])) }}">
                100 records
              </a>
          </li>
          <li>
              <a href="{{ route('users.index', array_merge(Request::all(), ['show-items' => $total_user])) }}">
                All
              </a>
          </li>
      </ul>
    </li>
  </div>

  <div class="search">
    <form>
      <div class="input-group input-group-sm">
        <input type="text" name="search-item" value="{{ request('search-item') }}" class="form-control pull-right" placeholder="Search">
        <span class="input-group-btn">
          <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </form>
  </div>
</div>