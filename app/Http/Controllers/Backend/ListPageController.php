<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ListPage;
use App\Models\PageType;
use App\Models\Category;
use App\Models\Tag;
use Auth;
use DB;
use Carbon\Carbon;

class ListPageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_list_pages', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_list_pages', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_list_pages', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_list_pages', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($page_type)
    {
        $type = PageType::where('slug', $page_type)->first();
        $order_by_lists = PageType::OrderBy;

        $list_pages = ListPage::where('page_type', $type->id)
                          ->search(request('search-item'))
                          ->deletedItemFilter(request('deleted-items'))
                          ->statusFilter(request('status'))
                          ->categoryFilter(request('category'))
                          ->tagFilter(request('tag'))
                          ->sort(request('criteria'));
                          

        if($type->order_by == array_flip($order_by_lists)['Ascending Order']) {
            $list_pages = $list_pages->orderBy('order', 'asc')
                                     ->paginate(request('show-items') ? request('show-items') : config('suryadaya.table_paginate'));
        } else {
            $list_pages = $list_pages->orderBy('order', 'desc')
                                     ->paginate(request('show-items') ? request('show-items') : config('suryadaya.table_paginate'));

        }

        $categories = Category::where('page_type', $type->id)->get();
        $tags = Tag::where('page_type', $type->id)->get();

        $total_list_page = ListPage::where('page_type', $type->id)->count();

        return view('backend.list-page.index', compact('list_pages', 'type', 'order_by_lists', 'categories', 'tags', 'total_list_page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($page_type)
    {
        $type = PageType::where('slug', $page_type)->first();
        $categories = Category::where('page_type', $type->id)->pluck('name', 'id');
        $tags = Tag::where('page_type', $type->id)->pluck('name', 'id');

        return view('backend.list-page.create', compact('type', 'categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $page_type)
    {       
        $type = PageType::where('slug', $page_type)->first();

        $this->validate($request,
            [
                'name'        => 'required|string|max:255',
                'order'       => 'nullable|numeric|unique:list_pages,order,NULL,id,page_type,'.$type->id,
                'description' => 'nullable|string|min:2|max:655356',
                'category_id' => 'nullable|numeric',
                'file_id'     => 'nullable|mimes:jpg,png,jpeg,gif,pdf|max:10240',
            ]
        );

        DB::beginTransaction();
        try {
            $list_page = ListPage::create(
                [
                    'page_type'   => $type->id,
                    'name'        => request('name'),
                    'slug'        => (str_slug($request->name) != '') ? $this->setSlugAttribute(request('name')) : $this->generateRandomNumber(),
                    'order'       => request('order'),
                    'description' => request('description'),
                    'category_id' => request('category_id'),
                    'status'      => request('status') ? 1 : 0,
                    'created_by'  => Auth::user()->id,
                    'updated_by'  => Auth::user()->id
                ]
            );

            if ($request->file('file_id')) {
                $file = $request->file('file_id');
                $list_page_file = saveFile($file, $type->name, $list_page->id);
            }

            $list_page->update([
                'file_id' => isset($list_page_file->id) ? $list_page_file->id : null
            ]);

            if (isset($request->tags)) {
                $list_page->tags()->attach($request->tags);
            }

            flash($type->name.' added successfully.')->success();

            DB::commit();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            DB::rollback();
            flash('There was some intenal error while adding the page.')->error();
        }

        return redirect(route('list-page.index', $page_type));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($page_type, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($page_type, $id)
    {
        $type = PageType::where('slug', $page_type)->first();
        $list_page = ListPage::withTrashed()->where('page_type', $type->id)->find($id);
        $categories = Category::where('page_type', $type->id)->pluck('name', 'id');
        $tags = Tag::where('page_type', $type->id)->pluck('name', 'id');

        return view('backend.list-page.edit', compact('type', 'list_page', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($page_type, Request $request, $id)
    {
        $type = PageType::where('slug', $page_type)->first();
        $list_page = ListPage::withTrashed()->where('page_type', $type->id)->find($id);

        $this->validate($request,
            [
                'name'        => 'required|string|max:255',
                'order'       => 'nullable|numeric|unique:list_pages,order,'.$id.',id,page_type,'.$type->id,
                'description' => 'nullable|string|min:2|max:655356',
                'category_id' => 'nullable|numeric',
                'file_id'     => 'nullable|mimes:jpg,png,jpeg,gif,pdf|max:10240',
            ]
        );

        DB::beginTransaction();
        try {
            if ($list_page->name != request('name')) {
                $list_page->update(
                  [
                    'slug' => (str_slug($request->name) != '') ? $this->setSlugAttribute(request('name')) : $this->generateRandomNumber()
                  ]
                );
            }
            
            $list_page->update(
                [
                    'name'        => request('name'),
                    'order'       => request('order'),
                    'description' => request('description'),
                    'category_id' => request('category_id'),
                    'status'      => request('status') ? 1 : 0,
                    'updated_by'  => Auth::user()->id
                ]
            );

            if ($request->file('file_id')) {
                $file = $request->file('file_id');
                $list_page_file = saveFile($file, $type->name, $list_page->id);
            }

            if(isset($list_page_file->id) && !empty($list_page->file_id)) {
                removeFile($list_page->file_id);
            }

            if (isset($list_page_file->id)) {
                $list_page->update(['file_id' => $list_page_file->id]);
            }

            if (isset($request->tags)) {
                $list_page->tags()->detach();
                $list_page->tags()->attach($request->tags);
            }

            flash($type->name.' updated successfully.')->info();

            DB::commit();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            DB::rollback();
            flash('There was some intenal error while updating the '. $list_page->name.'.')->error();
        }

        return redirect(route('list-page.index', $page_type));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($page_type, $id)
    {
        $type = PageType::where('slug', $page_type)->first();
        $list_page = ListPage::where('page_type', $type->id)->find($id);

        try {
            $list_page->delete();
            flash($type->name.' deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the '. $list_page->name.'.')->error();
        }

        return redirect(route('list-page.index', $page_type));
    }

    /**
     * Restore the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($page_type, $id)
    {
        $type = PageType::where('slug', $page_type)->first();
        $list_page = ListPage::withTrashed()->where('page_type', $type->id)->find($id);

        try {
            $list_page->restore();
            flash($type->name.' restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the '. $list_page->name.'.')->error();
        }

        return redirect(route('list-page.index', ['page_type' => $page_type, 'filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Force remove the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy($page_type, $id)
    {
        $type = PageType::where('slug', $page_type)->first();
        $list_page = ListPage::withTrashed()->where('page_type', $type->id)->find($id);

        try {
            $list_page->forcedelete();
            flash($type->name.' deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the question permanently.')->error();
        }

        return redirect(route('list-page.index', ['page_type' => $page_type, 'filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Change the status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $page_type, $id)
    {
        $type = PageType::where('slug', $page_type)->first();
        $list_page = ListPage::withTrashed()->where('page_type', $type->id)->find($id);

        try {
            $list_page->update(
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
        $list_page = ListPage::withTrashed()->find($fileId);
        
        try {
            removeFile($list_page->file_id);
            $list_page->update(['file_id' => null]);

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
        $slugs = ListPage::whereRaw("slug RLIKE '^{$slug}(-[0-9]*)?$'")
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
