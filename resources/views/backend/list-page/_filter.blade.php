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
            <a href="{{ route('list-page.index', $type->slug) }}">
              Without Deleted
            </a>
        </li>
        <li>
          <a href="{{ route('list-page.index', array_merge(Request::all(), ['page_type' => $type->slug, 'filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted'])) }}">
            Only Deleted
          </a>
        </li>
        <li>
          <a href="{{ route('list-page.index', array_merge(Request::all(), ['page_type' => $type->slug, 'filter_by' => 'deleted-items', 'deleted-items' => 'All'])) }}">
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
            <a href="{{ route('list-page.index', $type->slug) }}">
                All
            </a>
        </li>
        <li>
          <a href="{{ route('list-page.index', array_merge(Request::all(), ['page_type' => $type->slug, 'filter_by' => 'status', 'status' => 'Active'])) }}">
            Active
          </a>
        </li>
        <li>
          <a href="{{ route('list-page.index', array_merge(Request::all(), ['page_type' => $type->slug, 'filter_by' => 'status', 'status' => 'Inactive'])) }}">
            Inactive
          </a>
        </li>
    </ul>
  </li>

  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
      @if(request('category') != null)
        {{ request('category') }}
      @else
        Category
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('list-page.index', $type->slug) }}">
              All
            </a>
        </li>

        @foreach($categories as $category)
          <li>
            <a href="{{ route('list-page.index', array_merge(Request::all(), ['page_type' => $type->slug, 'filter_by' => 'category', 'category' => $category->name ])) }}">
              {{ $category->name }}
            </a>
          </li>
        @endforeach
    </ul>
  </li>

  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
      @if(request('tag') != null)
        {{ request('tag') }}
      @else
        Tag
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('list-page.index', $type->slug) }}">
              All
            </a>
        </li>

        @foreach($tags as $tag)
          <li>
            <a href="{{ route('list-page.index', array_merge(Request::all(), ['page_type' => $type->slug, 'filter_by' => 'tag', 'tag' => $tag->name ])) }}">
              {{ $tag->name }}
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
              <a href="{{ route('list-page.index', $type->slug) }}">
                10 records
              </a>
          </li>
          <li>
              <a href="{{ route('list-page.index', array_merge(Request::all(), ['page_type' => $type->slug, 'show-items' => 25])) }}">
                25 records
              </a>
          </li>
          <li>
              <a href="{{ route('list-page.index', array_merge(Request::all(), ['page_type' => $type->slug, 'show-items' => 50])) }}">
                50 records
              </a>
          </li>
          <li>
              <a href="{{ route('list-page.index', array_merge(Request::all(), ['page_type' => $type->slug, 'show-items' => 100])) }}">
                100 records
              </a>
          </li>
          <li>
              <a href="{{ route('list-page.index', array_merge(Request::all(), ['page_type' => $type->slug, 'show-items' => $total_list_page])) }}">
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