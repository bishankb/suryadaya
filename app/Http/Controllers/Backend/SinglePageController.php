<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SinglePage;
use App\Models\Menu;
use Auth;
use Carbon\Carbon;

class SinglePageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_single_pages', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_single_pages', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_single_pages', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_single_pages', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $single_pages = SinglePage::search(request('search-item'))
                      ->deletedItemFilter(request('deleted-items'))
                      ->statusFilter(request('status'))
                      ->sort(request('criteria'))
                      ->orderBy('order')
                      ->paginate(request('show-items') ? request('show-items') : config('suryadaya.table_paginate'));

        $total_single_page = SinglePage::count();
               
        return view('backend.single-page.index', compact('single_pages', 'total_single_page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu_for_lists = Menu::MenuFor;
        $menus = Menu::where('menu_for', array_flip($menu_for_lists)['Single Page'])
                        ->orWhere('has_sub_menu', 1)
                        ->orderBy('order')
                        ->get();

        return view('backend.single-page.create', compact('menus'));
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
            	'name'        => 'required|string|max:255',
				'description' => 'nullable|string|min:2|max:655356',
                'order'       => 'required|integer|unique:single_pages,order',
                'file_id'     => 'nullable|mimes:jpg,png,jpeg,gif,pdf|max:10240',
            ]
        );

        try {
            $single_page = SinglePage::create(
                [
                    'name'        => request('name'),
                    'slug'        => (str_slug($request->name) != '') ? $this->setSlugAttribute(request('name')) : $this->generateRandomNumber(),
                    'description' => request('description'),
                    'order'       => request('order'),
                    'menu_id'     => request('menu_id'),
                    'status' 	  => request('status') ? 1 : 0,
                    'created_by'  => Auth::user()->id,
                    'updated_by'  => Auth::user()->id
                ]
            );

            if ($request->file('file_id')) {
                $file = $request->file('file_id');
                $single_page_file = saveFile($file, $single_page->name, $single_page->id);
            }

            $single_page->update([
                'file_id' => isset($single_page_file->id) ? $single_page_file->id : null
            ]);

            flash('Single Page added successfully.')->success();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while adding the single page.')->error();
        }

        return redirect(route('single-page.index'));
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
        $single_page = SinglePage::withTrashed()->find($id);
        $menu_for_lists = Menu::MenuFor;
        $menus = Menu::where('menu_for', array_flip($menu_for_lists)['Single Page'])
                        ->orWhere('has_sub_menu', 1)
                        ->orderBy('order')
                        ->get();

        return view('backend.single-page.edit', compact('single_page', 'menus'));
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
        $single_page = SinglePage::withTrashed()->find($id);

        $this->validate($request,
            [
            	'name'        => 'required|string|max:255',
                'description' => 'nullable|string|min:2|max:655356',
                'order'       => 'required|integer|unique:single_pages,order,'.$single_page->id,
                'file_id'     => 'nullable|mimes:jpg,png,jpeg,gif,pdf|max:10240'
            ]
        );

        try {
            if ($single_page->name != request('name')) {
                $single_page->update(
                  [
                    'slug' => (str_slug($request->name) != '') ? $this->setSlugAttribute(request('name')) : $this->generateRandomNumber()
                  ]
                );
            }

            $single_page->update(
                [
                    'name'        => request('name'),
                    'description' => request('description'),
                    'order'       => request('order'),
                    'menu_id'     => request('menu_id'),
                    'status'      => request('status') ? 1 : 0,
                    'updated_by'  => Auth::user()->id
                ]
            );

            if ($request->file('file_id')) {
                $file = $request->file('file_id');
                $single_page_file = saveFile($file, $single_page->name, $single_page->id);
            }

            if(isset($single_page_file->id) && !empty($single_page->file_id)) {
                removeFile($single_page->file_id);
            }

            if (isset($single_page_file->id)) {
                $single_page->update(['file_id' => $single_page_file->id]);
            }

            flash('Single Page updated successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while updating the single page.')->error();
        }

        return redirect(route('single-page.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $single_page = SinglePage::find($id);

        try {
            $single_page->delete();
            flash('Single Page deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the single page.')->error();
        }

        return redirect(route('single-page.index'));
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
        $single_page = SinglePage::withTrashed()->find($id);

        try {
            $single_page->restore();
            flash('Single Page restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the single page.')->error();
        }

        return redirect(route('single-page.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
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
        $single_page = SinglePage::withTrashed()->find($id);

        try {
            $single_page->forcedelete();
            flash('Single Page deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the question set permanently.')->error();
        }

        return redirect(route('single-page.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Change the status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $id)
    {
        $single_page = SinglePage::withTrashed()->find($id);

        try {
            $single_page->update(
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
     * Remove the specified file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyFile($fileId)
    {
        $single_page = SinglePage::withTrashed()->find($fileId);
        
        try {
            removeFile($single_page->file_id);
            $single_page->update(['file_id' => null]);

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
        $slugs = SinglePage::whereRaw("slug RLIKE '^{$slug}(-[0-9]*)?$'")
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
        return SinglePage::where('slug', $number)->exists();
    }
}
