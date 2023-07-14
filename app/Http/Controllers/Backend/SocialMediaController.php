<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Auth;
use Carbon\Carbon;

class SocialMediaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_social_medias', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_social_medias', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_social_medias', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_social_medias', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $social_medias = SocialMedia::search(request('search-item'))
                      ->deletedItemFilter(request('deleted-items'))
                      ->statusFilter(request('status'))
                      ->sort(request('criteria'))
                      ->orderBy('order')
                      ->paginate(request('show-items') ? request('show-items') : config('suryadaya.table_paginate'));

        $total_social_media = SocialMedia::count();
               
        return view('backend.social-media.index', compact('social_medias', 'total_social_media'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.social-media.create');
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
            	'name'     => 'required|string|max:255',
				'url'      => 'nullable|string|min:2|max:255',
				'order'    => 'required|integer|unique:social_media,order',
                'image_id' => 'required|image|mimes:jpg,png,jpeg|max:10240'
            ]
        );

        try {
            $social_media = SocialMedia::create(
                [
                    'name'       => request('name'),
                    'url'        => request('url'),
                    'order'      => request('order'),
                    'status' 	 => request('status') ? 1 : 0,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id
                ]
            );

            if ($request->file('image_id')) {
                $fileImage = $request->file('image_id');
                $social_media_image = saveDefaultImage($fileImage, 'social-media', $social_media->id);
            }

            $social_media->update([
                'image_id' => isset($social_media_image->id) ? $social_media_image->id : null
            ]);

            flash('Social Media added successfully.')->success();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while adding the social media.')->error();
        }

        return redirect(route('social-medias.index'));
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
        $social_media = SocialMedia::withTrashed()->find($id);

        return view('backend.social-media.edit', compact('social_media'));
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
        $social_media = SocialMedia::withTrashed()->find($id);

        $this->validate($request,
            [
            	'name'     => 'required|string|max:255',
                'url'      => 'required|string|min:2|max:255',
                'order'    => 'required|integer|unique:social_media,order,'.$social_media->id,
                'image_id' => 'required|image|mimes:jpg,png,jpeg|max:10240'
            ]
        );

        try {
            $social_media->update(
                [
                    'name'       => request('name'),
                    'url'        => request('url'),
                    'order'      => request('order'),
                    'status'     => request('status') ? 1 : 0,
                    'updated_by' => Auth::user()->id
                ]
            );

            if ($request->file('image_id')) {
                $fileImage = $request->file('image_id');
                $social_media_image = saveDefaultImage($fileImage, 'social-media', $social_media->id);
            }

            if(isset($social_media_image->id) && !empty($social_media->image_id)) {
                removeFile($social_media->image_id);
            }

            if (isset($social_media_image->id)) {
                $social_media->update(['image_id' => $social_media_image->id]);
            }

            flash('Social Media updated successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while updating the social media.')->error();
        }

        return redirect(route('social-medias.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $social_media = SocialMedia::find($id);

        try {
            $social_media->delete();
            flash('Social Media deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the social media.')->error();
        }

        return redirect(route('social-medias.index'));
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
        $social_media = SocialMedia::withTrashed()->find($id);

        try {
            $social_media->restore();
            flash('Social Media restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the social media.')->error();
        }

        return redirect(route('social-medias.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
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
        $social_media = SocialMedia::withTrashed()->find($id);

        try {
            $social_media->forcedelete();
            flash('Social Media deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the question set permanently.')->error();
        }

        return redirect(route('social-medias.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Change the status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $id)
    {
        $social_media = SocialMedia::withTrashed()->find($id);

        try {
            $social_media->update(
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
     * Remove the specified image in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyImage($fileId)
    {
        $social_media = SocialMedia::withTrashed()->find($fileId);
        
        try {
            removeFile($social_media->id);
            $social_media->update(['image_id' => null]);

            return response()->json(['success' => true]);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());    
        }
    }
}