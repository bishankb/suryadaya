<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\PageType;
use Auth;
use Carbon\Carbon;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_categories', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_categories', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_categories', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_categories', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::search(request('search-item'))
                      ->deletedItemFilter(request('deleted-items'))
                      ->statusFilter(request('status'))
                      ->pageTypeFilter(request('page_type'))
                      ->sort(request('criteria'))
                      ->latest()
                      ->paginate(request('show-items') ? request('show-items') : config('suryadaya.table_paginate'));

        $page_types = PageType::whereHas('category')->get();
        $total_category = Category::count();
               
        return view('backend.category.index', compact('categories', 'page_types', 'total_category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_types = PageType::pluck('name', 'id');

        return view('backend.category.create', compact('page_types'));
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
                'icon'      => 'nullable|string|min:2|max:255'
            ]
        );

        try {
            $category = Category::create(
                [
                    'page_type'  => request('page_type'),
                    'name'       => request('name'),
                    'slug'       => (str_slug($request->name) != '') ? $this->setSlugAttribute(request('name')) : $this->generateRandomNumber(),
                    'status' 	 => request('status') ? 1 : 0,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id
                ]
            );

            flash('Category added successfully.')->success();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while adding the category.')->error();
        }

        return redirect(route('categories.index'));
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
        $category = Category::withTrashed()->find($id);
        $page_types = PageType::pluck('name', 'id');

        return view('backend.category.edit', compact('category', 'page_types'));
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
        $category = Category::withTrashed()->find($id);

        $this->validate($request,
            [
                'page_type' => 'required|numeric',
            	'name'      => 'required|string|max:255'
            ]
        );

        try {
            if ($category->name != request('name')) {
                $category->update(
                  [
                    'slug' => (str_slug($request->name) != '') ? $this->setSlugAttribute(request('name')) : $this->generateRandomNumber()
                  ]
                );
            }

            $category->update(
                [    
                    'page_type'  => request('page_type'),
                    'name'       => request('name'),
                    'status'     => request('status') ? 1 : 0,
                    'updated_by' => Auth::user()->id
                ]
            );

            flash('Category updated successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while updating the category.')->error();
        }

        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        try {
            $category->delete();
            flash('Category deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the category.')->error();
        }

        return redirect(route('categories.index'));
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
        $category = Category::withTrashed()->find($id);

        try {
            $category->restore();
            flash('Category restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the category.')->error();
        }

        return redirect(route('categories.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
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
        $category = Category::withTrashed()->find($id);

        try {
            $category->forcedelete();
            flash('Category deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the question set permanently.')->error();
        }

        return redirect(route('categories.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Change the status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $id)
    {
        $category = Category::withTrashed()->find($id);

        try {
            $category->update(
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
        $slugs = Category::whereRaw("slug RLIKE '^{$slug}(-[0-9]*)?$'")
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
        return Category::where('slug', $number)->exists();
    }
}
