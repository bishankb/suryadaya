<div class="row">
  <nav class="navbar" style="margin:0px;border-radius:0px">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="fa fa-bars fa-2x" style="color:white;"></span>
        </button>
        <a class="navbar-brand" href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li class="active">
            <a href="{{ route('frontend.home') }}">HOME</a>
          </li>
          @foreach($menus as $menu)
            @if($menu->slug == 'about-us')
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                  {{ $menu->name}}<span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  @foreach($menu->singlePages as $singlePageKey => $singlePage)
                    <li>
                      <a href="{{ route('frontend.singlePage', $singlePage->slug) }}">
                        {{ $singlePage->name }}
                      </a>
                    </li>
                    @if ($singlePageKey + 1 != count($menu->singlePages))
                      <li role="separator" class="divider"></li>
                    @endif
                  @endforeach
                  @if(count($menu->singlePages) > 0 && count($menu->pageTypes) > 0)
                    <li role="separator" class="divider"></li>
                  @endif
                  @foreach($menu->pageTypes as $pageTypeKey => $pageType)
                    <li>
                      <a href="{{ route('frontend.listPage', $pageType->slug) }}">
                        {{ $pageType->name }}
                      </a>
                    </li>
                    @if ($pageTypeKey + 1 != count($menu->pageTypes))
                      <li role="separator" class="divider"></li>
                    @endif
                  @endforeach
                </ul>
              </li>
            @endif
          @endforeach

          @foreach($menus as $menu)
            @if($menu->slug == 'services')
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                  {{ $menu->name}}<span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  @foreach($menu->singlePages as $singlePageKey => $singlePage)
                    <li>
                      <a href="{{ route('frontend.singlePage', $singlePage->slug) }}">
                        {{ $singlePage->name }}
                      </a>
                    </li>
                    @if ($singlePageKey + 1 != count($menu->singlePages))
                      <li role="separator" class="divider"></li>
                    @endif
                  @endforeach
                  @if(count($menu->singlePages) > 0 && count($menu->pageTypes) > 0)
                    <li role="separator" class="divider"></li>
                  @endif
                  @foreach($menu->pageTypes as $pageTypeKey => $pageType)
                    <li>
                      <a href="{{ route('frontend.listPage', $pageType->slug) }}">
                        {{ $pageType->name }}
                      </a>
                    </li>
                    @if ($pageTypeKey + 1 != count($menu->pageTypes))
                      <li role="separator" class="divider"></li>
                    @endif
                  @endforeach
                </ul>
              </li>
            @endif
          @endforeach

          @foreach($menus as $menu)
            @if($menu->slug != 'about-us' && $menu->slug != 'download' && $menu->slug != 'services')
              @if($menu->has_sub_menu == 0)
                <li>
                  <a href="@if($menu->menu_for == array_flip(\App\Models\Menu::MenuFor)['Single Page']) {{ route('frontend.page', $menu->slug) }} @else {{ route('frontend.page', $menu->slug) }} @endif">
                    {{ $menu->name}}
                  </a>
                </li>
              @else
                <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    {{ $menu->name}}<span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                    @foreach($menu->singlePages as $singlePageKey => $singlePage)
                      <li>
                        <a href="{{ route('frontend.singlePage', $singlePage->slug) }}">
                          {{ $singlePage->name }}
                        </a>
                      </li>
                      @if ($singlePageKey + 1 != count($menu->singlePages))
                        <li role="separator" class="divider"></li>
                      @endif
                    @endforeach
                    @if(count($menu->singlePages) > 0 && count($menu->pageTypes) > 0)
                      <li role="separator" class="divider"></li>
                    @endif
                    @foreach($menu->pageTypes as $pageTypeKey => $pageType)
                      <li>
                        <a href="{{ route('frontend.listPage', $pageType->slug) }}">
                          {{ $pageType->name }}
                        </a>
                      </li>
                      @if ($pageTypeKey + 1 != count($menu->pageTypes))
                        <li role="separator" class="divider"></li>
                      @endif
                    @endforeach
                  </ul>
                </li>
              @endif
            @endif
          @endforeach

          <li>
            <a href="{{ route('gallery.index') }}">Gallery</a>
          </li>

          @foreach($menus as $menu)
            @if($menu->slug === 'download')
              <li class="active">
                <a href="@if($menu->menu_for == array_flip(\App\Models\Menu::MenuFor)['Single Page']) {{ route('frontend.page', $menu->slug) }} @else {{ route('frontend.page', $menu->slug) }} @endif"><span style="text-transform: uppercase;">{{ $menu->name}}</span></a>
              </li>
            @endif
          @endforeach
          
          <li>
            <a href="{{ route('contact-us.index') }}">CONTACT US</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</div>