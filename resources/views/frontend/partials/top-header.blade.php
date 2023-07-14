<div class="row" style="padding:0px;margin:0px;">
    <div class="col-sm-6 col-xs-12">
        <div class="logo">
            <a href="{{ route('frontend.home') }}">
                <img src="{{ asset('images/logo.png') }}" class="logo"/>
            </a>
        </div>
    </div>

    <div class="col-sm-6 col-xs-12" style="font-size:13px" id="motto">
        <div class="row" style="background-image: url('{{ asset('images/layout.png') }}'); background-repeat:no-repeat; background-size: 600px">
            <div class="row" style="height:60px; padding:7.5px">
                <div class="col-sm-5  col-xs-1 text-center">
                    <span class="topHeader-motto">साठी रुपियाँ देखि को सुरुवात !!!</span>
                </div>

                @foreach($menus as $menu)
                    <div class="col-sm-3 col-xs-1 text-left">
                        <a href="@if($menu->menu_for == array_flip(\App\Models\Menu::MenuFor)['Single Page']) {{ route('frontend.page', $menu->slug) }} @else {{ route('frontend.page', $menu->slug) }} @endif" style="text-decoration: none; color: green;">
                            <span class="{{ ($menu->icon) ? $menu->icon : ''  }}"></span> {{ $menu->name }}
                        </a>
                    </div>
                @endforeach
                @isset($zerone_ads->file)
                    @if($zerone_ads->file->extension != 'pdf')
                        <div class="col-sm-3 col-xs-1 text-left hidden-md">
                            <div class="zerone-ads">
                                <img src="/storage/media/{{ $zerone_ads->name}}/{{ $zerone_ads->id }}/{{ $zerone_ads->file->filename }}">
                            </div>
                        </div>
                    @endif
                @endisset
            </div>
        </div>
    </div>
</div>
<br/>
