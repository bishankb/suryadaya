<div class="page-sidebar-wrapper">
  <div class="page-sidebar navbar-collapse collapse">
    <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
      <li class="sidebar-toggler-wrapper hide">
        <div class="sidebar-toggler">
          <span></span>
        </div>
      </li>

      <li class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
        <a href="{{ route('backend.dashboard') }}" class="nav-link nav-toggle">
          <i class="fa fa-tachometer"></i>
          <span class="title">Dashboard</span>
        </a>
      </li>
      
      @can('view_menus')
        <li class="nav-item {{ Request::is('admin/menus*') ? 'active' : '' }}">
          <a href="{{ route('menus.index') }}" class="nav-link nav-toggle">
            <i class="fa fa-list-alt"></i>
            <span class="title">Menu</span>
          </a>
        </li>
      @endcan

      @can('view_sliders')
        <li class="nav-item {{ Request::is('admin/sliders*') ? 'active' : '' }}">
          <a href="{{ route('sliders.index') }}" class="nav-link nav-toggle">
            <i class="fa fa-file-image-o"></i>
            <span class="title">Slider</span>
          </a>
        </li>
      @endcan

      @can('view_single_pages')
        <li class="nav-item {{ Request::is('admin/single-page*') ? 'active' : '' }}">
          <a href="{{ route('single-page.index') }}" class="nav-link nav-toggle">
            <i class="fa fa-file-o"></i>
            <span class="title">Single Page</span>
          </a>
        </li>
      @endcan

      @if(auth()->user()->can('view_page_types') ||
          auth()->user()->can('view_categories') ||
          auth()->user()->can('view_tags') ||
          auth()->user()->can('view_list_pages')
      )
        @php
          $selectedPageType = request('page_type');
        @endphp
        <li class="nav-item {{ Request::is('admin/page-types*') ||
                               Request::is('admin/categories*') ||
                               Request::is('admin/tags*') ||
                               Request::is('admin/'.$selectedPageType.'/list-page*') ? 'start active open' : '' }}">
          <a href="#" class="nav-link nav-toggle">
            <i class="fa fa-files-o"></i>
            <span class="title">List Pages</span>
            <span class="arrow"></span>
          </a>
          
          <ul class="sub-menu">
            @can('view_page_types')
              <li class="nav-item {{ Request::is('admin/page-types*') ? 'active' : '' }}">
                <a href="{{ route('page-types.index') }}" class="nav-link nav-toggle">
                  <i class="fa fa-file-text"></i>
                  <span class="title">Page Type</span>
                </a>
              </li>
            @endcan

            @can('view_categories')
              <li class="nav-item {{ Request::is('admin/categories*') ? 'active' : '' }}">
                <a href="{{ route('categories.index') }}" class="nav-link nav-toggle">
                  <i class="fa fa-list"></i>
                  <span class="title">Category</span>
                </a>
              </li>
            @endcan

            @can('view_tags')
              <li class="nav-item {{ Request::is('admin/tags*') ? 'active' : '' }}">
                <a href="{{ route('tags.index') }}" class="nav-link nav-toggle">
                  <i class="fa fa-tags"></i>
                  <span class="title">Tag</span>
                </a>
              </li>
            @endcan
            
            @can('view_list_pages')
              @if(count($page_types) > 0)
                @foreach($page_types as $page_type)
                  <li class="nav-item @if($page_type->slug == request('page_type')) active @endif">
                    <a href="{{ route('list-page.index', $page_type->slug)}}" class="nav-link ">
                      <i class="{{ isset($page_type->icon) ? $page_type->icon : 'fa fa-arrow-right' }}"></i>
                      <span class="title">{{ $page_type->name }}</span>
                    </a>
                  </li>
                @endforeach
              @endif
            @endcan
          </ul>
        </li>
      @endif

      @can('view_galleries')
        <li class="nav-item {{ Request::is('admin/galleries*') ? 'active' : '' }}">
          <a href="{{ route('galleries.index') }}" class="nav-link nav-toggle">
            <i class="fa fa-image"></i>
            <span class="title">Gallery</span>
          </a>
        </li>
      @endcan

      @can('view_important_links')
        <li class="nav-item {{ Request::is('admin/important-links*') ? 'active' : '' }}">
          <a href="{{ route('important-links.index') }}" class="nav-link nav-toggle">
            <i class="fa fa-globe"></i>
            <span class="title">Important Link</span>
          </a>
        </li>
      @endcan

      @can('view_social_medias')
        <li class="nav-item {{ Request::is('admin/social-medias*') ? 'active' : '' }}">
          <a href="{{ route('social-medias.index') }}" class="nav-link nav-toggle">
            <i class="fa fa-star"></i>
            <span class="title">Social Media</span>
          </a>
        </li>
      @endcan

      @can('view_users')
        <li class="nav-item {{ Request::is('admin/users*') ? 'active' : '' }}">
          <a href="{{ route('users.index') }}" class="nav-link nav-toggle">
            <i class="fa fa-user"></i>
            <span class="title">User</span>
          </a>
        </li>
      @endcan

      @can('view_roles')
        <li class="nav-item {{ Request::is('admin/roles*') ? 'active' : '' }}">
          <a href="{{ route('roles.index') }}" class="nav-link nav-toggle">
            <i class="fa fa-adn"></i>
            <span class="title">Roles</span>
          </a>
        </li>
      @endcan     
    </ul>
  </div>
</div>

@section('backend-script')
  <script>
    $("#item_id li a").click(function() {
        $('#item_li').parent().addClass('start active open').siblings().removeClass('start active open');
    });
  </script>
@endsection
