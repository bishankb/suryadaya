<div class="page-wrapper">
  <div class="page-header navbar navbar-fixed-top">
    <div class="page-header-inner ">
      <div class="page-logo">
        <a target="__blank" href="{{ route('frontend.home') }}">
          <img src="{{ asset('images/admin-logo.png') }}" alt="logo" class="logo-default"/>
        </a>
        <div class="menu-toggler sidebar-toggler">
          <span></span>
        </div>
      </div>
      <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
        <span></span>
      </a>
      <div class="top-menu">
        <ul class="nav navbar-nav pull-right">
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              @if(Auth::user()->unreadNotifications->count())
               <span class="label label-warning">{{ Auth::user()->unreadNotifications->count() }}</span>
              @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-default">
              @if(Auth::user()->unreadNotifications->count() > 0)
                <li>
                  <ul class="menu">
                    <li>
                      @if(Auth::user()->unreadNotifications->count())
                      <a href="{{ route('viewer-messages.markAsRead') }}" style="color: #d42222; font-size:12px">Mark all as Read</a>
                      @endif
                    </li>
                    @foreach(Auth::user()->unreadNotifications->take(10) as $unreadNotification)
                    @if(isset($unreadNotification->data['data']))
                    <li>
                      <a>
                        {{ $unreadNotification->data['data'] }}
                      </a>
                    </li>
                    @endif
                    @endforeach
                  </ul>
                </li>

                <li class="footer">
                  <h6 class="check-mail"><i class="fa fa-info-circle"></i> Please check your mail</h6>
                </li>
              @else 
                <li>
                  <h4 class="no-notification"><i class="fa fa-info-circle"></i> No notification</h4>
                </li>
              @endif
            </ul>
          </li>

          <li class="dropdown dropdown-user">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
            data-close-others="true">
              <img alt="" class="img-circle" src="{{asset('images/avatar.png')}}"/>
              <span class="username username-hide-on-mobile"> {{ auth()->user()->name }} </span>
              <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-default">
              <li>
                  <a href="#">
                    <i class="fa fa-bell"></i> Send Notifications
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-info-circle"></i> Edit About App
                  </a>
                </li>
                <hr style="margin-top: -2px; margin-bottom: -2px;">
                <li>
                  <a href="#"
                  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="icon-logout"></i> Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>