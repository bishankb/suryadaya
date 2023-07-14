<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserProfile;
use App\Media;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_users', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_users', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_users', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_users', ['only' => 'destroy']);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $redirectTo = '/login';

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::statusFilter(request('status'))
                        ->search(request('search-item'))
                        ->deletedItemFilter(request('deleted-items'))
                        ->roleFilter(request('role'))
                        ->sort(request('criteria'))
                        ->paginate(request('show-items') ? request('show-items') : config('suryadaya.table_paginate'));

        $roles = Role::select('name', 'display_name')->get();
        $total_user = User::count();

        return view('backend.user.index', compact('users', 'roles', 'total_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name'     => 'required|string|min:2|max:255',
                'email'    => 'required|string|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
                'password' => 'required|string|min:6|confirmed'
            ]
        );

        try {
            $user = User::create(
                [
                    'name'       => request('name'),
                    'email'      => request('email'),
                    'password'   => Hash::make(request('password')),
                    'updated_by' => Auth::user()->id,
                    'created_by' => Auth::user()->id,
                    'active'     => request('active') ? 1 : 0
                ]
            );
            flash('User added successfully.')->success();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while adding the user.')->error();
        }

        return redirect(route('users.index'));
        
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
        $user = User::withTrashed()->find($id);
        $userProfile = $user->profile;
        $roles = Role::get();

        return view('backend.user.edit', compact('user', 'userProfile', 'roles'));
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
        $user = User::find($id);

        if(Auth::user()->hasRole('admin')) {
            $this->validate(
                $request,
                [
                    'name'    => 'required|string|min:2|max:255',
                    'email'   => 'required|string|email|max:255|unique:users,email,'.$id.',id,deleted_at,NULL',
                    'role'    => 'required'
                ]
            );
        } elseif (Auth::user()->id == $user->id) {
            $this->validate(
                $request,
                [
                    'name'    => 'required|string|min:2|max:255',
                    'email'   => 'required|string|email|max:255|unique:users,email,'.$id.',id,deleted_at,NULL',
                ]
            );
        } else {
            $this->validate(
                $request,
                [
                    'name'    => 'required|string|min:2|max:255',
                ]
            );
        }

        try {
            if(Auth::user()->hasRole('admin')) {
                $user->update(
                    [
                        'name'       => request('name'),
                        'email'      => request('email'),
                        'role_id'    => request('role'),
                        'active'     => request('active') ? 1 : 0,
                        'updated_by' => Auth::user()->id,
                    ]
                );
                $role = request('role');
                $user->syncRoles($role);
            } elseif (Auth::user()->id == $user->id) {
                $user->update(
                    [
                        'name'       => request('name'),
                        'email'      => request('email'),
                        'active'     => request('active') ? 1 : 0,
                        'updated_by' => Auth::user()->id,
                    ]
                );
            } else {
                $user->update(
                    [
                        'name'       => request('name'),
                        'active'     => request('active') ? 1 : 0,
                        'updated_by' => Auth::user()->id,
                    ]
                );
            }
            flash('User added successfully.')->success();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while adding the user.')->error();
        }

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        try {
            $user->delete();
            flash('User deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the user.')->error();
        }

        return redirect(route('users.index'));
    }

    /**
     * Change the status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $id)
    {
        $user = User::withTrashed()->find($id);

        try {
            $user->update(
                [
                    'active'=> request('status')
                ]
            );
            return response()->json(['success' => true]);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
        }
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
        $user = User::withTrashed()->find($id);

        $users = User::withTrashed()->where('email', $user->email)->get();

        try {
            if(count($users) > 1) {
                flash('Email with '. $user->email . 'already exists. Please rename the email before restoring.')->error();
                return redirect(route('users.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
            }

            $user->restore();
            flash('User restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the user.')->error();
        }

        return redirect(route('users.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
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
        $user = User::withTrashed()->find($id);

        try {
            $user->forcedelete();
            flash('User deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the user permanently.')->error();
        }

        return redirect(route('users.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Edit the profile of the user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editProfile(Request $request, $id)
    {
        $user = User::withTrashed()->find($id);

        $validator = Validator::make($request->all(), [
            'position'    => 'nullable|max:100',
            'phone1'      => 'nullable|min:5|max:20',
            'phone2'      => 'nullable|min:5|max:20',
            'address'     => 'nullable|min:2|max:100',
            'city'        => 'nullable',
            'user_image'  => 'nullable|image|mimes:jpg,png,jpeg|max:10240'
        ]);
         
        if ($validator->fails()) {
            return redirect(route('users.edit', [$user->id]). '#profile')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            if ($request->file('user_image')) {
                $fileData = $request->file('user_image');
                $user_image = saveImage($fileData, 'user', $id);
            }

            if(isset($user_image->id) && !empty($user->profile->user_image_id)) {
                removeFile($user->profile->user_image_id);
            }

            if (!$user->profile) {
                $userProfile = UserProfile::create(
                    [
                        'user_id'       => $id,
                        'position'      => request('position'),
                        'phone1'        => request('phone1'),
                        'phone2'        => request('phone2'),
                        'address'       => request('address'),
                        'city'          => request('city'),
                        'user_image_id' => isset($user_image->id) ? $user_image->id : null
                    ]
                );
            } else {
                if (isset($user_image->id)) {
                    $user->profile->update(['user_image_id' => $user_image->id]);
                }

                $user->profile->update(
                    [
                        'user_id'  => $id,
                        'position' => request('position'),
                        'phone1'   => request('phone1'),
                        'phone2'   => request('phone2'),
                        'address'  => request('address'),
                        'city'     => request('city'),
                    ]
                );
            }
            flash('Profile updated successfully.')->success();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while updating the profile.')->error();
        }

        return redirect(route('users.index'));
    }

    /**
     * Change the password of the user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request, $id)
    {
        $user = User::withTrashed()->find($id);

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6|confirmed'
        ]);
         
        if ($validator->fails()) {
            return redirect(route('users.edit', [$user->id]). '#change-password')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            if (!(Auth::user()->id == $user->id || Auth::user()->role->name == 'admin')) {
                flash('You dont have authorization to change the password')->error();
                return redirect()->route('users.index');
            } else {
                $user->update(
                    [
                        'password' => Hash::make(request('password'))
                    ]
                );
                flash('Password changed successfully.')->success();
            }
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while changing the password.')->error();
        }        

        return redirect(route('users.index'));
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
        $userProfile = UserProfile::withTrashed()->where('user_image_id', $fileId)->first();
        try {
            removeFile($fileId);
            $userProfile->update(['user_image_id' => null]);

            return response()->json(['success' => true]);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());    
        }
    }
}
