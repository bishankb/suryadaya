<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Gallery;
use App\Models\PageType;
use App\Models\ListPage;
use App\Models\Category;
use App\Models\Tag;
use SEOMeta;
use OpenGraph;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->seoIndex();

    	$galleries = Gallery::whereHas('images')->where('status', 1)->get();

        return view('frontend.gallery.index', compact('galleries'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $gallery = Gallery::where('status', 1)->where('slug', $slug)->first();
     
        $this->seoShow($gallery);

        return view('frontend.gallery.show', compact('gallery'));
    }

    private function seoIndex()
    {
        SEOMeta::setTitle('Gallery - '.env('APP_NAME'));
        SEOMeta::setDescription(env('APP_NAME').' -View our gallery of events or occasaion.');
        SEOMeta::setCanonical(route('gallery.index'));
        SEOMeta::addKeyword(['suryodaya', 'suryadaya', 'zerone technology', 'nepal', 'sahakari', 'syangja', 'pokhara', 'kathmandu', 'gallery']);
        
        OpenGraph::setTitle('Home - '.env('APP_NAME'));
        OpenGraph::setDescription(env('APP_NAME').' -View our gallery of events or occasaion.');
        OpenGraph::setUrl(route('gallery.index'));
    }

    private function seoShow($gallery)
    {
        SEOMeta::setTitle('Gallery - '.env('APP_NAME'));
        SEOMeta::setDescription(env('APP_NAME').' -View related images of the gallery.');
        SEOMeta::setCanonical(route('gallery.show', $gallery->slug));
        SEOMeta::addKeyword(['suryodaya', 'suryadaya', 'zerone technology', 'nepal', 'sahakari', 'syangja', 'pokhara', 'kathmandu', 'images']);
        
        OpenGraph::setTitle('Gallery - '.env('APP_NAME'));
        OpenGraph::setDescription(env('APP_NAME').' -View related images of the gallery.');
        OpenGraph::setUrl(route('gallery.show', $gallery->slug));

        OpenGraph::addImage(env('APP_URL').'/storage/media/gallery/'.$gallery->id.'/'.$gallery->images->first()->filename);
    }
}