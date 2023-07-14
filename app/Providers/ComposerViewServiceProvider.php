<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\SinglePage;
use App\Models\PageType;
use App\Models\Menu;
use App\Models\ListPage;
use App\Models\ImportantLink;
use App\Models\Slider;
use App\User;
use DB;

class ComposerViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            ['backend.partials.sidebar'],
            function ($view) {
                $page_types = PageType::where('status', 1)
                                        ->orderBy('order')
                                        ->get();

                $view->with('page_types', $page_types);
            }
        );

        view()->composer(
            ['frontend.partials.top-header'],
            function ($view) {
                $top_header = array_flip(Menu::Positions)['Top Header'];
                $menus = Menu::where('status', 1)
                                ->orderBy('order')
                                ->whereRaw("find_in_set($top_header, positions)")
                                ->get();

                $view->with('menus', $menus);
            }
        );

        view()->composer(
            ['frontend.partials.top-header'],
            function ($view) {
                $zerone_ads = SinglePage::where('status', 1)->where('name', 'Zerone Ads')->first();

                $view->with('zerone_ads', $zerone_ads);
            }
        );

        view()->composer(
            ['frontend.partials.top-navbar'],
            function ($view) {
                $top_navbar = array_flip(Menu::Positions)['Top Navbar'];
                $menus = Menu::where('status', 1)
                                ->orderBy('order')
                                ->whereRaw("find_in_set($top_navbar, positions)")
                                ->get();

                $view->with('menus', $menus);
            }
        );

        view()->composer(
            ['frontend.partials.bottom-navbar'],
            function ($view) {
                $bottom_navbar = array_flip(Menu::Positions)['Bottom Navbar'];
                $menus = Menu::where('status', 1)
                                ->orderBy('order')
                                ->whereRaw("find_in_set($bottom_navbar, positions)")
                                ->get();

                $view->with('menus', $menus);
            }
        );

        view()->composer(
            ['frontend.partials.home-slider-notice'],
            function ($view) {
                $notice = array_flip(Menu::Positions)['Notices'];
                $menus = Menu::where('status', 1)
                                ->orderBy('order')
                                ->whereRaw("find_in_set($notice, positions)")
                                ->get();

                $view->with('menus', $menus);
            }
        );

        view()->composer(
            ['frontend.partials.footer'],
            function ($view) {
                $footer = array_flip(Menu::Positions)['Footer Navigation'];
                $menus = Menu::where('status', 1)
                                ->orderBy('order')
                                ->whereRaw("find_in_set($footer, positions)")
                                ->get();

                $view->with('menus', $menus);
            }
        );

        view()->composer(
            ['frontend.partials.footer'],
            function ($view) {
                $footer_service = array_flip(Menu::Positions)['Footer Service'];
                $services = Menu::where('status', 1)
                                    ->orderBy('order')
                                    ->whereRaw("find_in_set($footer_service, positions)")
                                    ->get();

                $view->with('services', $services);
            }
        );

        view()->composer(
            ['frontend.partials.footer'],
            function ($view) {
                $important_links = ImportantLink::where('status', 1)
                                                    ->orderBy('order')
                                                    ->get();

                $view->with('important_links', $important_links);
            }
        );

        view()->composer(
            ['frontend.partials.home-slider-notice'],
            function ($view) {
                $sliders = Slider::where('status', 1)
                                    ->orderBy('order')
                                    ->where('status', 1)
                                    ->get();

                $view->with('sliders', $sliders);
            }
        );

        view()->composer(
            ['frontend.partials.sidebar'],
            function ($view) {
                $news = PageType::where('status', 1)->where('name', 'News')->first();
                $news_lists = ListPage::where('status', 1)
                                        ->where('page_type', $news->id)
                                        ->orderBy('order', 'desc')
                                        ->get();

                $view->with('news_lists', $news_lists);
            }
        );

        view()->composer(
            ['frontend.partials.sidebar'],
            function ($view) {
                $staffs = User::whereHas('role', function ($r) {
                                $r->where('name', 'staff');
                             })
                            ->get();
                            
                $view->with('staffs', $staffs);
            }
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
