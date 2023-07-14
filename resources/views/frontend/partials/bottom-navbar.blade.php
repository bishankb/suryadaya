<div class="row" style="background:#D0D0D0">
  <center>
    <div class="row" style="margin-left:85px; margin-right:64px">
      @foreach($menus as $menu)
        <div class="col-lg-3 col-md-4 col-sm-4">
          <p class="navbar-text" style="cursor:pointer">
            <a style="color: #333;" href="@if($menu->menu_for == array_flip(\App\Models\Menu::MenuFor)['Single Page']) {{ route('frontend.page', $menu->slug) }} @else {{ route('frontend.page', $menu->slug) }} @endif">
              <i class="{{ ($menu->icon) ? $menu->icon : '' }}"></i> {{ $menu->name }}
            </a>
          </p>
        </div>
      @endforeach
      
      <div class="col-lg-3 col-md-12 col-sm-12">

        <form class="navbar-form navbar-left" method="get" action="{{ route('frontend.search') }}">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search" name="search" value="{{ request('search') }}" required>
            <div class="input-group-btn">
              <button class="btn btn-default" type="submit">
                <i class="glyphicon glyphicon-search"></i>
              </button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </center>
</div>