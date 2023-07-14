<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ImportantLink;
use Auth;
use Carbon\Carbon;

class ImportantLinkController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_important_links', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_important_links', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_important_links', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_important_links', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $important_links = ImportantLink::search(request('search-item'))
                      ->deletedItemFilter(request('deleted-items'))
                      ->statusFilter(request('status'))
                      ->sort(request('criteria'))
                      ->orderBy('order')
                      ->paginate(request('show-items') ? request('show-items') : config('suryadaya.table_paginate'));

        $total_important_link = ImportantLink::count();
               
        return view('backend.important-link.index', compact('important_links', 'total_important_link'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.important-link.create');
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
            	'name'  => 'required|string|max:255',
                'url'   => 'required|string|min:2|max:255',
                'order' => 'required|integer|unique:important_links,order'
            ]
        );

        try {
            $important_link = ImportantLink::create(
                [
                    'name'       => request('name'),
                    'url'        => request('url'),
                    'order'      => request('order'),
                    'status' 	 => request('status') ? 1 : 0,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id
                ]
            );

            flash('Important link added successfully.')->success();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while adding the important link.')->error();
        }

        return redirect(route('important-links.index'));
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
        $important_link = ImportantLink::withTrashed()->find($id);
        $menus = Menu::orderBy('order')->pluck('name', 'id');

        return view('backend.important-link.edit', compact('important_link', 'menus'));
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
        $important_link = ImportantLink::withTrashed()->find($id);

        $this->validate($request,
            [
            	'name'  => 'required|string|max:255',
                'url'   => 'required|string|min:2|max:255',
                'order' => 'required|integer|unique:important_links,order,'.$important_link->id,
            ]
        );

        try {
            $important_link->update(
                [
                    'name'       => request('name'),
                    'url'        => request('url'),
                    'order'      => request('order'),
                    'status'     => request('status') ? 1 : 0,
                    'updated_by' => Auth::user()->id
                ]
            );

            flash('Important link updated successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while updating the important link.')->error();
        }

        return redirect(route('important-links.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $important_link = ImportantLink::find($id);

        try {
            $important_link->delete();
            flash('Important link deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the important link.')->error();
        }

        return redirect(route('important-links.index'));
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
        $important_link = ImportantLink::withTrashed()->find($id);

        try {
            $important_link->restore();
            flash('Important link restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the important link.')->error();
        }

        return redirect(route('important-links.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
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
        $important_link = ImportantLink::withTrashed()->find($id);

        try {
            $important_link->forcedelete();
            flash('Important link deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the question set permanently.')->error();
        }

        return redirect(route('important-links.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Change the status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $id)
    {
        $important_link = ImportantLink::withTrashed()->find($id);

        try {
            $important_link->update(
                [
                    'status'=> request('status')
                ]
            );
            return response()->json(['success' => true]);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
        }
    }
}
