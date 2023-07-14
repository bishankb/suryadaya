<div class="row">
  <div class="container" style="background:#31D11B; height:500px; color: white;">
    <div class="row">
      <div id="slider" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          @foreach ($sliders as $key => $slider)
            <li data-target="#slider" data-slide-to="{{ $key }}" class="{{ $loop->first ? 'active' : '' }}"></li>
          @endforeach
        </ol>

        <div class="carousel-inner">
          @foreach ($sliders as $key => $slider)
            <div class="item {{ $loop->first ? 'active' : '' }}">
              <img src="@if(isset($slider->image)) /storage/media/slider/{{ $slider->id }}/{{ $slider->image->filename }} @endif" class="img-responsive" style="width:100%; height: 500px;">
              <div class="carousel-caption">
                  <h3>{{ $slider->name }}</h3>
                  <p>{{ $slider->description }}</p>
                </div>
            </div>
          @endforeach
        </div>

        <a class="left carousel-control" href="#slider" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#slider" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <center>
    <div class="container" style="font-family:verdana">
      <div class="row" style="background:#D0D0D0;">
        <div class="col-md-2 hidden-sm hidden-xs" style="background-image: url('images/notice1.png'); background-repeat:no-repeat; background-size:cover; background-position: center;">
          <h3 style="color: white; margin-top: 15px; margin-bottom: 15px; margin-right: 35px;">Notices:</h3>
        </div>
        <marquee class="col-lg-10 col-md-10 col-sm-12 col-xs-12"  onmouseover="this.stop()" onmouseout="this.start()" direction="left" behavior="scroll">
          @foreach($menus as $key => $menu)
             <p class="navbar-text notices-navbar">
                <a style="color: #333;" href="@if($menu->menu_for == array_flip(\App\Models\Menu::MenuFor)['Single Page']) {{ route('frontend.page', $menu->slug) }} @else {{ route('frontend.page', $menu->slug) }} @endif">
                  </i>{{ $menu->name }}
                </a>
              </p>
          @endforeach
        </marquee>
      </div>
    </div>
  </center>
</div>
