<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SinglePage;
use App\Models\PageType;
use App\Models\ListPage;
use SEOMeta;
use OpenGraph;

class HomeController extends Controller
{
    public function index()
    {
        $this->seoIndex();

    	$account = PageType::where('status', 1)->where('name', 'Account')->first();
        $accounts = ListPage::where('status', 1)->where('page_type', $account->id)->orderBy('order', 'asc')->get();

        $loan = PageType::where('status', 1)->where('name', 'Loan')->first();
        $loans = ListPage::where('status', 1)->where('page_type', $loan->id)->orderBy('order', 'asc')->get();

        $remittance = PageType::where('status', 1)->where('name', 'Remittance')->first();
        $remittances = ListPage::where('status', 1)->where('page_type', $remittance->id)->orderBy('order', 'asc')->get();

        $about_us = SinglePage::where('status', 1)->where('name', 'About Us')->first();

        $achievement = PageType::where('status', 1)->where('name', 'Achievement')->first();
        $achievements = ListPage::where('status', 1)->where('page_type', $achievement->id)->orderBy('order', 'desc')->get();

        return view('frontend.home', compact('accounts', 'loans', 'remittances', 'about_us', 'achievements'));
    }

    public function search(Request $request)
    {
        $this->seoSearch($request->search);

        $list_pages = ListPage::search(request('search-item'))
                          ->where('status', 1)
                          ->search(request('search'))
                          ->paginate(config('suryadaya.list_page_paginate'));

        return view('frontend.search', compact('list_pages'));
    }

    private function seoIndex()
    {
        SEOMeta::setTitle('Home - '.env('APP_NAME'));
        SEOMeta::setDescription(env('APP_NAME').' -View our introduction, loans, remittance, types of accounts, news and achievement history');
        SEOMeta::setCanonical(route('frontend.home'));
        SEOMeta::addKeyword(['suryodaya', 'suryadaya', 'zerone technology', 'nepal', 'sahakari', 'syangja', 'pokhara', 'kathmandu', 'home', 'loans', 'remittance', 'accounts']);
        
        OpenGraph::setTitle('Home - '.env('APP_NAME'));
        OpenGraph::setDescription(env('APP_NAME').' -View our introduction, loans, remittance, types of accounts, news and achievement history');
        OpenGraph::setUrl(route('frontend.home'));
    }

    private function seoSearch($search)
    {
        SEOMeta::setTitle('Search -'.env('APP_NAME'));
        SEOMeta::setDescription('Item searched by "'. $search .'" keyword on '.env('APP_NAME').'.');
        SEOMeta::setCanonical(route('frontend.search', ['search' => $search]));
        SEOMeta::addKeyword(['suryodaya', 'suryadaya', 'zerone technology', 'nepal', 'sahakari', 'syangja', 'pokhara', 'kathmandu', 'search', $search]);
        
        OpenGraph::setTitle('Search -'.env('APP_NAME'));
        OpenGraph::setDescription('Item searched by "'. $search .'" keyword on '.env('APP_NAME').'.');
        OpenGraph::setUrl(route('frontend.search', ['search' => $search]));
    }
}