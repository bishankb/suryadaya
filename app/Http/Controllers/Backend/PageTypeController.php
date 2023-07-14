<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PageType;
use App\Models\Menu;
use Auth;
use Carbon\Carbon;

class PageTypeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_page_types', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_page_types', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_page_types', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_page_types', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_types = PageType::search(request('search-item'))
                      ->deletedItemFilter(request('deleted-items'))
                      ->statusFilter(request('status'))
                      ->sort(request('criteria'))
                      ->orderBy('order')
                      ->paginate(request('show-items') ? request('show-items') : config('suryadaya.table_paginate'));

        $total_page_type = PageType::count();
               
        return view('backend.page-type.index', compact('page_types', 'total_page_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $order_by_lists = PageType::OrderBy;
        $menu_for_lists = Menu::MenuFor;
        $menus = Menu::where('menu_for', array_flip($menu_for_lists)['List Page'])
                        ->orWhere('has_sub_menu', 1)
                        ->orderBy('order')
                        ->get();

        return view('backend.page-type.create', compact('order_by_lists', 'menus'));
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
                'icon'     => 'nullable|string|min:2|max:255',
                'order'    => 'required|integer|unique:page_types,order',
                'order_by' => 'required|numeric',
                'menu_id'  => 'nullable|numeric'
            ]
        );

        try {
            $page_type = PageType::create(
                [
                    'name'       => request('name'),
                    'slug'       => (str_slug($request->name) != '') ? $this->setSlugAttribute(request('name')) : $this->generateRandomNumber(),
                    'icon'       => request('icon'),
                    'order'      => request('order'),
                    'order_by'   => request('order_by'),
                    'menu_id'    => request('menu_id'),
                    'status' 	 => request('status') ? 1 : 0,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id
                ]
            );

            flash('Page type added successfully.')->success();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while adding the page type.')->error();
        }

        return redirect(route('page-types.index'));
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
        $page_type = PageType::withTrashed()->find($id);
        $order_by_lists = PageType::OrderBy;
        $menu_for_lists = Menu::MenuFor;
        $menus = Menu::where('menu_for', array_flip($menu_for_lists)['List Page'])
                        ->orWhere('has_sub_menu', 1)
                        ->orderBy('order')
                        ->get();

        return view('backend.page-type.edit', compact('page_type', 'order_by_lists', 'menus'));
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
        $page_type = PageType::withTrashed()->find($id);

        $this->validate($request,
            [
            	'name'     => 'required|string|max:255',
                'icon'     => 'nullable|string|min:2|max:255',
                'order'    => 'required|integer|unique:page_types,order,'.$page_type->id,
                'order_by' => 'required|numeric',
                'menu_id'  => 'nullable|numeric'
            ]
        );

        try {
            if ($page_type->name != request('name')) {
                $page_type->update(
                  [
                    'slug' => (str_slug($request->name) != '') ? $this->setSlugAttribute(request('name')) : $this->generateRandomNumber()
                  ]
                );
            }

            $page_type->update(
                [
                    'name'       => request('name'),
                    'icon'       => request('icon'),
                    'order'      => request('order'),
                    'order'      => request('order'),
                    'order_by'   => request('order_by'),
                    'menu_id'    => request('menu_id'),
                    'status'     => request('status') ? 1 : 0,
                    'updated_by' => Auth::user()->id
                ]
            );

            flash('Page type updated successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while updating the page type.')->error();
        }

        return redirect(route('page-types.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page_type = PageType::find($id);

        try {
            $page_type->delete();
            flash('Page type deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the page type.')->error();
        }

        return redirect(route('page-types.index'));
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
        $page_type = PageType::withTrashed()->find($id);

        try {
            $page_type->restore();
            flash('Page type restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the page type.')->error();
        }

        return redirect(route('page-types.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
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
        $page_type = PageType::withTrashed()->find($id);

        try {
            $page_type->forcedelete();
            flash('Page type deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the question set permanently.')->error();
        }

        return redirect(route('page-types.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Change the status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $id)
    {
        $page_type = PageType::withTrashed()->find($id);

        try {
            $page_type->update(
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
        $slugs = PageType::whereRaw("slug RLIKE '^{$slug}(-[0-9]*)?$'")
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
        return PageType::where('slug', $number)->exists();
    }
}
