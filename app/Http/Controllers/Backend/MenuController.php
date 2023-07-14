<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Auth;
use Carbon\Carbon;

class MenuController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_menus', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_menus', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_menus', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_menus', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::search(request('search-item'))
                      ->deletedItemFilter(request('deleted-items'))
                      ->statusFilter(request('status'))
                      ->positionFilter(request('position'))
                      ->menuFor(request('menu_for'))
                      ->sort(request('criteria'))
                      ->orderBy('order')
                      ->paginate(request('show-items') ? request('show-items') : config('suryadaya.table_paginate'));

        $positions = Menu::Positions;
        $menu_for_lists = Menu::MenuFor;
        $total_menu = Menu::count();
               
        return view('backend.menu.index', compact('menus', 'positions', 'menu_for_lists', 'total_menu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = Menu::Positions;
        $menu_for_lists = Menu::MenuFor;

        return view('backend.menu.create', compact('positions', 'menu_for_lists'));
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
            	'name'      => 'required|string|max:255',
				'icon' 		=> 'nullable|string|min:2|max:255',
                'positions' => 'required',
                'menu_for'  => 'nullable|numeric',
				'order' 	=> 'required|integer|unique:menus,order',
            ]
        );

        try {
        	if(request('positions')) {
                $positions = implode(",", $request->get('positions'));
            } else {
                $positions = null;
            }

            $menu = Menu::create(
                [
                    'name'         => request('name'),
                    'slug'         => (str_slug($request->name) != '') ? $this->setSlugAttribute(request('name')) : $this->generateRandomNumber(),
                    'icon'         => request('icon'),
                    'positions'    => $positions,
                    'menu_for'     => request('menu_for'),
                    'has_sub_menu' => request('has_sub_menu') ? 1 : 0,
                    'order'        => request('order'),
                    'status' 	   => request('status') ? 1 : 0,
                    'created_by'   => Auth::user()->id,
                    'updated_by'   => Auth::user()->id
                ]
            );

            flash('Menu added successfully.')->success();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while adding the menu.')->error();
        }

        return redirect(route('menus.index'));
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
        $menu = Menu::withTrashed()->find($id);
        $positions = Menu::Positions;
        $menu_for_lists = Menu::MenuFor;

        return view('backend.menu.edit', compact('menu', 'positions', 'menu_for_lists'));
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
        $menu = Menu::withTrashed()->find($id);

        $this->validate($request,
            [
            	'name'      => 'required|string|max:255',
				'icon' 		=> 'nullable|string|min:2|max:255',
                'positions' => 'required',
                'menu_for'  => 'nullable|numeric',
                'order'     => 'required|integer|unique:menus,order,'.$menu->id,
            ]
        );

        try {
            if ($menu->name != request('name')) {
                $menu->update(
                  [
                    'slug' => (str_slug($request->name) != '') ? $this->setSlugAttribute(request('name')) : $this->generateRandomNumber()
                  ]
                );
            }

            if(request('positions')) {
                $positions = implode(",", $request->get('positions'));
            } else {
                $positions = null;
            }

            $menu->update(
                [
                    'name'         => request('name'),
                    'icon'         => request('icon'),
                    'positions'    => $positions,
                    'menu_for'     => request('menu_for'),
                    'has_sub_menu' => request('has_sub_menu') ? 1 : 0,
                    'order'        => request('order'),
                    'status' 	   => request('status') ? 1 : 0,
                    'updated_by'   => Auth::user()->id
                ]
            );

            flash('Menu updated successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while updating the menu.')->error();
        }

        return redirect(route('menus.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::find($id);

        try {
            $menu->delete();
            flash('Menu deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the menu.')->error();
        }

        return redirect(route('menus.index'));
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
        $menu = Menu::withTrashed()->find($id);

        try {
            $menu->restore();
            flash('Menu restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the menu.')->error();
        }

        return redirect(route('menus.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
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
        $menu = Menu::withTrashed()->find($id);

        try {
            $menu->forcedelete();
            flash('Menu deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the question set permanently.')->error();
        }

        return redirect(route('menus.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Change the status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $id)
    {
        $menu = Menu::withTrashed()->find($id);

        try {
            $menu->update(
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
        $slugs = Menu::whereRaw("slug RLIKE '^{$slug}(-[0-9]*)?$'")
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
        return Menu::where('slug', $number)->exists();
    }
}
