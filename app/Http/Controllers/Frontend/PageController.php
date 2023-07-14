<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\SinglePage;
use App\Models\PageType;
use App\Models\ListPage;
use App\Models\Category;
use App\Models\Tag;
use SEOMeta;
use OpenGraph;

class PageController extends Controller
{
    public function singlePage($slug)
    {
    	$single_page = SinglePage::where('status', 1)->where('slug', $slug)->first();
     
        $this->seoSinglePage($single_page);

        return view('frontend.page.single-page', compact('single_page'));
    }

    public function listPage($slug)
    {
    	$page_type = PageType::where('status', 1)->where('slug', $slug)->first();

        $this->seoListPage($page_type);

        $order_by_lists = PageType::OrderBy;
    	
        $list_pages = ListPage::where('status', 1)
                                ->where('page_type', $page_type->id);

        if($page_type->order_by == array_flip($order_by_lists)['Ascending Order']) {
            $list_pages = $list_pages->orderBy('order', 'asc')
                                     ->paginate(config('suryadaya.list_page_paginate'));
        } else {
            $list_pages = $list_pages->orderBy('order', 'desc')
                                     ->paginate(config('suryadaya.list_page_paginate'));
        }

        return view('frontend.page.list-page', compact('page_type', 'list_pages'));
    }

    public function page($slug)
    {
    	$menu = Menu::where('status', 1)->where('slug', $slug)->first();

    	if($menu->menu_for == 'Single Page') {
    		$single_page = SinglePage::where('status', 1)->where('menu_id', $menu->id)->first();

            $this->seoSinglePage(($single_page) ? ($single_page) : $menu);

    		return view('frontend.page.single-page', compact('menu', 'single_page'));
    	} else {
    		$page_type = PageType::where('status', 1)->where('menu_id', $menu->id)->first();

            $this->seoSinglePage(($page_type) ? ($page_type) : $menu);

            $order_by_lists = PageType::OrderBy;
    		
            $list_pages = ListPage::where('status', 1)
                                ->where('page_type', $page_type->id);

            if($page_type->order_by == array_flip($order_by_lists)['Ascending Order']) {
                $list_pages = $list_pages->orderBy('order', 'asc')
                                         ->paginate(config('suryadaya.list_page_paginate'));
            } else {
                $list_pages = $list_pages->orderBy('order', 'desc')
                                         ->paginate(config('suryadaya.list_page_paginate'));
            }

    		return view('frontend.page.list-page', compact('page_type', 'menu', 'list_pages'));
    	}
    }

    public function listPageDesc($listPageSlug)
    {
        $list_page = ListPage::where('status', 1)->where('slug', $listPageSlug)->first();

        $this->seoListPageDesc($list_page);

        return view('frontend.page.list-page-desc', compact('list_page'));
    }

    public function categoryListPage($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)
                         ->where('status', 1)
                         ->first();

        $this->seoCategoryListPage($category);

        $page_type = $category->pageType;
        $order_by_lists = PageType::OrderBy;
        $list_pages = Category::where('slug', $categorySlug)
                         ->where('status', 1)
                         ->first()
                         ->listPages();
        
        if($page_type->order_by == array_flip($order_by_lists)['Ascending Order']) {
            $list_pages = $list_pages->orderBy('order', 'asc')
                                     ->paginate(config('suryadaya.list_page_paginate'));
        } else {
            $list_pages = $list_pages->orderBy('order', 'desc')
                                     ->paginate(config('suryadaya.list_page_paginate'));
        }        

        return view('frontend.page.list-page', compact('category', 'page_type', 'menu', 'list_pages'));
    }

    public function tagListPage($tagSlug)
    {
        $tag = Tag::where('slug', $tagSlug)
                         ->where('status', 1)
                         ->first();

        $this->seoTagListPage($tag);

        $page_type = $tag->pageType;
        $order_by_lists = PageType::OrderBy;
        $list_pages = Tag::where('slug', $tagSlug)
                         ->where('status', 1)
                         ->first()
                         ->listPages();
        
        if($page_type->order_by == array_flip($order_by_lists)['Ascending Order']) {
            $list_pages = $list_pages->orderBy('order', 'asc')
                                     ->paginate(config('suryadaya.list_page_paginate'));
        } else {
            $list_pages = $list_pages->orderBy('order', 'desc')
                                     ->paginate(config('suryadaya.list_page_paginate'));
        }  

        return view('frontend.page.list-page', compact('tag', 'page_type', 'menu', 'list_pages'));
    }

    private function seoSinglePage($single_page)
    {
        SEOMeta::setTitle($single_page->name. ' - '.env('APP_NAME'));
        SEOMeta::setDescription(env('APP_NAME').' - View our organization ' . $single_page->name .'.');
        SEOMeta::setCanonical(route('frontend.singlePage', $single_page->slug));
        SEOMeta::addKeyword(['suryodaya', 'suryadaya', 'zerone technology', 'nepal', 'sahakari', 'syangja', 'pokhara', 'kathmandu', $single_page->name]);
        
        OpenGraph::setTitle($single_page->name. ' - '.env('APP_NAME'));
        OpenGraph::setDescription(env('APP_NAME').' -View our organization '. $single_page->name .'.');
        OpenGraph::setUrl(route('frontend.singlePage', $single_page->slug));

        if(isset($single_page->file)) {
            if($single_page->file->extension != 'pdf') {
                OpenGraph::addImage(env('APP_URL').'/storage/media/'.$single_page->name.'/'.$single_page->id.'/'.$single_page->file->filename);
            }
        }
    }

    private function seoListPage($page_type)
    {
        SEOMeta::setTitle($page_type->name. ' - '.env('APP_NAME'));
        SEOMeta::setDescription(env('APP_NAME').' - View our organization ' . $page_type->name .'.');
        SEOMeta::setCanonical(route('frontend.listPage', $page_type->slug));
        SEOMeta::addKeyword(['suryodaya', 'suryadaya', 'zerone technology', 'nepal', 'sahakari', 'syangja', 'pokhara', 'kathmandu', $page_type->name]);
        
        OpenGraph::setTitle($page_type->name. ' - '.env('APP_NAME'));
        OpenGraph::setDescription(env('APP_NAME').' -View our organization '. $page_type->name .'.');
        OpenGraph::setUrl(route('frontend.listPage', $page_type->slug));
    }

    private function seoListPageDesc($list_page)
    {
        SEOMeta::setTitle($list_page->name. ' - '.env('APP_NAME'));
        SEOMeta::setDescription(env('APP_NAME').' - View the description of ' . $list_page->name .'.');
        SEOMeta::setCanonical(route('frontend.listPageDesc', $list_page->slug));
        SEOMeta::addKeyword(['suryodaya', 'suryadaya', 'zerone technology', 'nepal', 'sahakari', 'syangja', 'pokhara', 'kathmandu', $list_page->pageType->name, $list_page->name]);
        
        OpenGraph::setTitle($list_page->name. ' - '.env('APP_NAME'));
        OpenGraph::setDescription(env('APP_NAME').' - View the description of '. $list_page->name .'.');
        OpenGraph::setUrl(route('frontend.listPageDesc', $list_page->slug));

        if(isset($list_page->file)) {
            if($list_page->file->extension != 'pdf') {
                OpenGraph::addImage(env('APP_URL').'/storage/media/'.$list_page->pageType->name.'/'.$list_page->id.'/'.$list_page->file->filename);
            }
        }
    }

    private function seoCategoryListPage($category)
    {
        SEOMeta::setTitle($category->name. ' - '.env('APP_NAME'));
        SEOMeta::setDescription(env('APP_NAME').' - View the list of '.$category->pageType->name.' according to the category '.$category->name.'.');
        SEOMeta::setCanonical(route('frontend.categoryListPage', $category->slug));
        SEOMeta::addKeyword(['suryodaya', 'suryadaya', 'zerone technology', 'nepal', 'sahakari', 'syangja', 'pokhara', 'kathmandu', 'category', $category->name, $category->pageType->name]);
        
        OpenGraph::setTitle($category->name. ' - '.env('APP_NAME'));
        OpenGraph::setDescription(env('APP_NAME').' - View the list of '.$category->pageType->name.' according to the category '.$category->name.'.');
        OpenGraph::setUrl(route('frontend.categoryListPage', $category->slug));
    }

    private function seoTagListPage($tag)
    {
        SEOMeta::setTitle($tag->name. ' - '.env('APP_NAME'));
        SEOMeta::setDescription(env('APP_NAME').' - View the list of '.$tag->pageType->name.' according to the tag '.$tag->name.'.');
        SEOMeta::setCanonical(route('frontend.tagListPage', $tag->slug));
        SEOMeta::addKeyword(['suryodaya', 'suryadaya', 'zerone technology', 'nepal', 'sahakari', 'syangja', 'pokhara', 'kathmandu', 'tag', $tag->name, $tag->pageType->name]);
        
        OpenGraph::setTitle($tag->name. ' - '.env('APP_NAME'));
        OpenGraph::setDescription(env('APP_NAME').' - View the list of '.$tag->pageType->name.' according to the tag '.$tag->name.'.');
        OpenGraph::setUrl(route('frontend.tagListPage', $tag->slug));
    }
}