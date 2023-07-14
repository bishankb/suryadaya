<footer>
  <div class="container-fluid" style="background-color: #336600; color: white;">
    <div class="row">
      <div class="container">
        <div class="row">
          <div class="footer-menu">

            <div class="col-sm-3" style="margin-top: 1%">
              <h4>HEAD OFFICE</h4>
              <ul style="padding-left: 0; list-style: none;">
                @if(config('suryadaya.address'))
                  <li>
                    <i class="fa fa-map-pin"></i>{{ config('suryadaya.address') }}
                  </li>
                @endif
                @if(config('suryadaya.phone'))
                  <li>
                    <i class="fa fa-phone"></i>{{ config('suryadaya.phone') }}
                  </li>
                @endif
                @if(config('suryadaya.email'))
                  <li>
                    <i class="fa fa-envelope"></i>{{ config('suryadaya.email') }}
                  </li>
                @endif
                @if(config('suryadaya.fax'))
                  <li>
                    <i class="fa fa-fax"></i>{{ config('suryadaya.fax') }}
                  </li>
                @endif
              </ul>
            </div>

            <div class="col-sm-3" style="margin-top: 1%">
              <h4>SERVICES</h4>
              <ul>
                @foreach($services as $service)
                  @if($service->has_sub_menu == 0)
                    <li>
                      <a href="@if($service->menu_for == array_flip(\App\Models\Menu::MenuFor)['Single Page']) {{ route('frontend.page', $service->slug) }} @else {{ route('frontend.page', $service->slug) }} @endif">
                        {{ $service->name}}
                      </a>
                    </li>
                  @else
                    @foreach($service->singlePages as $singlePageKey => $singlePage)
                      <li>
                        <a href="{{ route('frontend.singlePage', $singlePage->slug) }}">
                          {{ $singlePage->name }}
                        </a>
                      </li>
                    @endforeach
                    @foreach($service->pageTypes as $pageTypeKey => $pageType)
                      <li>
                        <a href="{{ route('frontend.listPage', $pageType->slug) }}">
                          {{ $pageType->name }}
                        </a>
                      </li>
                    @endforeach
                  @endif
                @endforeach
              </ul>
            </div> 
            
            <div class="col-sm-3" style="margin-top: 1%">
              <h4>NAVIGATION</h4>
              <ul>
                <li>
                  <a href="{{ route('frontend.home') }}">Home</a>
                </li>
                @foreach($menus as $menu)
                  @if($menu->slug == 'about-us')
                    @foreach($menu->singlePages as $singlePageKey => $singlePage)
                      <li>
                        <a href="{{ route('frontend.singlePage', $singlePage->slug) }}">
                          {{ $singlePage->name }}
                        </a>
                      </li>
                    @endforeach
                    @foreach($menu->pageTypes as $pageTypeKey => $pageType)
                      <li>
                        <a href="{{ route('frontend.listPage', $pageType->slug) }}">
                          {{ $pageType->name }}
                        </a>
                      </li>
                    @endforeach
                  @endif
                @endforeach
                @foreach($menus as $menu)
                  @if($menu->slug != 'about-us' && $menu->slug != 'download')
                    @if($menu->has_sub_menu == 0)
                      <li>
                        <a href="@if($menu->menu_for == array_flip(\App\Models\Menu::MenuFor)['Single Page']) {{ route('frontend.page', $menu->slug) }} @else {{ route('frontend.page', $menu->slug) }} @endif">
                          {{ $menu->name}}
                        </a>
                      </li>
                    @else
                      @foreach($menu->singlePages as $singlePageKey => $singlePage)
                        <li>
                          <a href="{{ route('frontend.singlePage', $singlePage->slug) }}">
                            {{ $singlePage->name }}
                          </a>
                        </li>
                      @endforeach
                      @foreach($menu->pageTypes as $pageTypeKey => $pageType)
                        <li>
                          <a href="{{ route('frontend.listPage', $pageType->slug) }}">
                            {{ $pageType->name }}
                          </a>
                        </li>
                      @endforeach
                    @endif
                  @endif
                @endforeach
                <li>
                  <a href="{{ route('gallery.index') }}">Gallery</a>
                </li>
                @foreach($menus as $menu)
                  @if($menu->slug == 'download')
                    <li>
                      <a href="@if($menu->menu_for == array_flip(\App\Models\Menu::MenuFor)['Single Page']) {{ route('frontend.page', $menu->slug) }} @else {{ route('frontend.page', $menu->slug) }} @endif">{{ $menu->name }}</a>
                    </li>
                  @endif
                @endforeach
                <li>
                  <a href="{{ route('contact-us.index') }}">Contact Us</a>
                </li>
              </ul>
            </div> 

            <div class="col-sm-3" style="margin-top: 1%">
              <h4>IMPORTANT LINKS</h4>
              <ul>
                @foreach($important_links as $important_link)
                  <li>
                    <a target="__blank" href="{{ $important_link->url }}">{{ $important_link->name }}</a>
                  </li>
                @endforeach
              </ul>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <footer style="background-color: #28460a; color: white;">
        <center>Copyright &copy; All rights reserved. Zerone Technology, {{ date('Y') }}</center>
      </footer>
    </div>
  </div>
</footer>