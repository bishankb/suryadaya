<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Auth;
use Carbon\Carbon;

class SliderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_sliders', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_sliders', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_sliders', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_sliders', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::search(request('search-item'))
                      ->deletedItemFilter(request('deleted-items'))
                      ->statusFilter(request('status'))
                      ->sort(request('criteria'))
                      ->orderBy('order')
                      ->paginate(request('show-items') ? request('show-items') : config('suryadaya.table_paginate'));

        $total_slider = Slider::count();
               
        return view('backend.slider.index', compact('sliders', 'total_slider'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.slider.create');
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
				'description'     => 'nullable|string|min:2|max:655356',
				'order' 	      => 'required|integer|unique:sliders,order',
                'slider_image_id' => 'required|image|mimes:jpg,png,jpeg|max:10240'
            ]
        );

        try {
            $slider = Slider::create(
                [
                    'name'         => request('name'),
                    'description'  => request('description'),
                    'order'        => request('order'),
                    'status' 	   => request('status') ? 1 : 0,
                    'created_by'   => Auth::user()->id,
                    'updated_by'   => Auth::user()->id
                ]
            );

            if ($request->file('slider_image_id')) {
                $fileImage = $request->file('slider_image_id');
                $slider_image = saveDefaultImage($fileImage, 'slider', $slider->id);
            }

            $slider->update([
                'slider_image_id' => isset($slider_image->id) ? $slider_image->id : null
            ]);

            flash('Slider added successfully.')->success();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while adding the slider.')->error();
        }

        return redirect(route('sliders.index'));
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
        $slider = Slider::withTrashed()->find($id);

        return view('backend.slider.edit', compact('slider'));
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
        $slider = Slider::withTrashed()->find($id);

        $this->validate($request,
            [
            	'name'            => 'required|string|max:255',
                'description'     => 'nullable|string|min:2|max:655356',
                'order'           => 'required|integer|unique:sliders,order,'.$slider->id,
                'slider_image_id' => 'required|image|mimes:jpg,png,jpeg|max:10240'
            ]
        );

        try {
            $slider->update(
                [
                    'name'        => request('name'),
                    'description' => request('description'),
                    'order'       => request('order'),
                    'status'      => request('status') ? 1 : 0,
                    'updated_by'  => Auth::user()->id
                ]
            );

            if ($request->file('slider_image_id')) {
                $fileImage = $request->file('slider_image_id');
                $slider_image = saveDefaultImage($fileImage, 'slider', $slider->id);
            }

            if(isset($slider_image->id) && !empty($slider->slider_image_id)) {
                removeFile($slider->slider_image_id);
            }

            if (isset($slider_image->id)) {
                $slider->update(['slider_image_id' => $slider_image->id]);
            }

            flash('Slider updated successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while updating the slider.')->error();
        }

        return redirect(route('sliders.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::find($id);

        try {
            $slider->delete();
            flash('Slider deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the slider.')->error();
        }

        return redirect(route('sliders.index'));
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
        $slider = Slider::withTrashed()->find($id);

        try {
            $slider->restore();
            flash('Slider restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the slider.')->error();
        }

        return redirect(route('sliders.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
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
        $slider = Slider::withTrashed()->find($id);

        try {
            $slider->forcedelete();
            flash('Slider deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the question set permanently.')->error();
        }

        return redirect(route('sliders.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Change the status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $id)
    {
        $slider = Slider::withTrashed()->find($id);

        try {
            $slider->update(
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
        $slider = Slider::withTrashed()->find($fileId);
        
        try {
            removeFile($slider->id);
            $slider->update(['slider_image_id' => null]);

            return response()->json(['success' => true]);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());    
        }
    }
}