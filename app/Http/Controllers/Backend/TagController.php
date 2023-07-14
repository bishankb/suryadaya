<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\PageType;
use Auth;
use Carbon\Carbon;

class TagController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_tags', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_tags', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_tags', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_tags', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::search(request('search-item'))
                    ->deletedItemFilter(request('deleted-items'))
                    ->statusFilter(request('status'))
                    ->pageTypeFilter(request('page_type'))
                    ->sort(request('criteria'))
                    ->latest()
                    ->paginate(request('show-items') ? request('show-items') : config('suryadaya.table_paginate'));

        $page_types = PageType::whereHas('tag')->get();
        $total_tag = Tag::count();
               
        return view('backend.tag.index', compact('tags', 'page_types', 'total_tag'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_types = PageType::pluck('name', 'id');

        return view('backend.tag.create', compact('page_types'));
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
                'page_type' => 'nullable|numeric',
                'name'      => 'required|string|max:255',
                'icon'      => 'nullable|string|min:2|max:255',
            ]
        );

        try {
            $tag = Tag::create(
                [
                    'page_type'  => request('page_type'),
                    'name'       => request('name'),
                    'slug'       => (str_slug($request->name) != '') ? $this->setSlugAttribute(request('name')) : $this->generateRandomNumber(),
                    'status'     => request('status') ? 1 : 0,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id
                ]
            );

            flash('Tag added successfully.')->success();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while adding the tag.')->error();
        }

        return redirect(route('tags.index'));
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
        $tag = Tag::withTrashed()->find($id);
        $page_types = PageType::pluck('name', 'id');

        return view('backend.tag.edit', compact('tag', 'page_types'));
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
        $tag = Tag::withTrashed()->find($id);

        $this->validate($request,
            [
                'page_type' => 'required|numeric',
                'name'      => 'required|string|max:255',
            ]
        );

        try {
            if ($tag->name != request('name')) {
                $tag->update(
                  [
                    'slug' => (str_slug($request->name) != '') ? $this->setSlugAttribute(request('name')) : $this->generateRandomNumber()
                  ]
                );
            }

            $tag->update(
                [    
                    'page_type'  => request('page_type'),
                    'name'       => request('name'),
                    'status'     => request('status') ? 1 : 0,
                    'updated_by' => Auth::user()->id
                ]
            );

            flash('Tag updated successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while updating the tag.')->error();
        }

        return redirect(route('tags.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);

        try {
            $tag->delete();
            flash('Tag deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the tag.')->error();
        }

        return redirect(route('tags.index'));
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
        $tag = Tag::withTrashed()->find($id);

        try {
            $tag->restore();
            flash('Tag restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the tag.')->error();
        }

        return redirect(route('tags.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
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
        $tag = Tag::withTrashed()->find($id);

        try {
            $tag->forcedelete();
            flash('Tag deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the question set permanently.')->error();
        }

        return redirect(route('tags.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Change the status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $id)
    {
        $tag = Tag::withTrashed()->find($id);

        try {
            $tag->update(
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
        $slugs = Tag::whereRaw("slug RLIKE '^{$slug}(-[0-9]*)?$'")
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
        return Tag::where('slug', $number)->exists();
    }
}
