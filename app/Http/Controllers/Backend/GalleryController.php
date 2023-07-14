<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Auth;
use Carbon\Carbon;

class GalleryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_galleries', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_galleries', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_galleries', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_galleries', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = Gallery::search(request('search-item'))
                      ->deletedItemFilter(request('deleted-items'))
                      ->statusFilter(request('status'))
                      ->sort(request('criteria'))
                      ->orderBy('order')
                      ->paginate(request('show-items') ? request('show-items') : config('suryadaya.table_paginate'));

        $total_gallery = Gallery::count();
               
        return view('backend.gallery.index', compact('galleries', 'total_gallery'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
            	'name'            => 'required|string|max:255',
				'order' 	      => 'required|integer|unique:galleries,order',
            ]
        );

        try {
            $gallery = Gallery::create(
                [
                    'name'         => request('name'),
                    'slug'         => (str_slug($request->name) != '') ? $this->setSlugAttribute(request('name')) : $this->generateRandomNumber(),
                    'order'        => request('order'),
                    'status' 	   => request('status') ? 1 : 0,
                    'created_by'   => Auth::user()->id,
                    'updated_by'   => Auth::user()->id
                ]
            );

            flash('Gallery added successfully.')->success();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while adding the gallery.')->error();
        }

        return redirect(route('galleries.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gallery = Gallery::withTrashed()->find($id);

        return view('backend.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $gallery = Gallery::withTrashed()->find($id);

        $this->validate($request,
            [
            	'name'            => 'required|string|max:255',
                'order'           => 'required|integer|unique:galleries,order,'.$gallery->id,
            ]
        );

        try {
            if ($gallery->name != request('name')) {
                $gallery->update(
                  [
                    'slug' => (str_slug($request->name) != '') ? $this->setSlugAttribute(request('name')) : $this->generateRandomNumber()
                  ]
                );
            }

            $gallery->update([
                'name'        => request('name'),
                'order'       => request('order'),
                'status'      => request('status') ? 1 : 0,
                'updated_by'  => Auth::user()->id
            ]);

            flash('Gallery updated successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while updating the gallery.')->error();
        }

        return redirect(route('galleries.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gallery = Gallery::find($id);

        try {
            $gallery->delete();
            flash('Gallery deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the gallery.')->error();
        }

        return redirect(route('galleries.index'));
    }

    /**
     * Restore the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $gallery = Gallery::withTrashed()->find($id);

        try {
            $gallery->restore();
            flash('Gallery restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the gallery.')->error();
        }

        return redirect(route('galleries.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Force remove the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy($id)
    {
        $gallery = Gallery::withTrashed()->find($id);

        try {
            $gallery->forcedelete();
            flash('Gallery deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the question set permanently.')->error();
        }

        return redirect(route('galleries.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Change the status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $id)
    {
        $gallery = Gallery::withTrashed()->find($id);

        try {
            $gallery->update(
                [
                    'status'=> request('status')
                ]
            );
            return response()->json(['success' => true]);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
        }
    }

    /**
     * Creating the unique slug.
     *
     */
    private function setSlugAttribute($slug)
    {
        $slug = str_slug($slug);
        $slugs = Gallery::whereRaw("slug RLIKE '^{$slug}(-[0-9]*)?$'")
                    ->orderBy('id')
                    ->pluck('slug');
        if (count($slugs) == 0) {
            return $slug;
        } elseif (! $slugs->isEmpty()) {
            $pieces = explode('-', $slugs);
            $number = (int) end($pieces);
            return $slug .= '-' . ($number + 1);
        }
    }

    /**
     * Generate Random Number.
     *
    */
    private function generateRandomNumber() {
        $number = mt_rand(10000, mt_getrandmax());

        if ($this->randomNumberExists($number) && $number > $number + 23) {
            return generateRandomNumber();
        }

        return $number;
    }

    private function randomNumberExists($number) {
        return Gallery::where('slug', $number)->exists();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addImages($gallerySlug)
    {
        $gallery = Gallery::withTrashed()->where('slug', $gallerySlug)->first();
        $galleryImages = $gallery->images;
        $galleryId = $gallery->id;
        $galleryImagesUrls = [];
        $galleryImagesInformations = [];

        foreach ($galleryImages as $key => $galleryImage) {
            array_push($galleryImagesInformations, [
                'caption' => $galleryImage->original_filename,

                'url' => route('galleries.destroyImages', ['galleryId' => $galleryId, 'imageId' => $galleryImage->id])
            ]);
            array_push($galleryImagesUrls,"/storage/media/gallery/".$galleryId."/".$galleryImage->filename);
        }

        return view('backend.gallery.add-image', compact('galleryId', 'gallerySlug', 'galleryImagesUrls', 'galleryImagesInformations'));
    }

    /**
     * Upload and save images.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveImages(Request $request, $galleryId)
    {
        if ($request->file('gallery_image')) {
            $fileData = $request->file('gallery_image');
            $galleryImage = saveImage($fileData, 'gallery', $galleryId);

            $galleryImage->galleries()->attach($galleryId);
        }

        $data = [
            'caption' => $galleryImage->original_filename,
            'url' => route('galleries.destroyImages', ['galleryId' => $galleryId, 'imageId' => $galleryImage->id])
        ];

        return response()->json([
            'initialPreview' => "/storage/media/gallery/".$galleryId."/".$galleryImage->filename,
            'initialPreviewConfig' => [
                $data
            ]
        ]);
    }

    /**
     * Destroy the specified image.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destoryImages($galleryId, $imageId)
    {
        try {
            $galleryImage = removeFile($imageId);
            $galleryImage->galleries()->detach($galleryId);

            return response()->json(['success' => true]);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());    
        }
    }
}
