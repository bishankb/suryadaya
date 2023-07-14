<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('backend.dashboard');
    }

    public function markAsRead()
    {
        try {
            if (Auth::user()->unreadNotifications) {

                Auth::user()->notifications->markAsRead();
                Auth::user()->readNotifications()->delete();

                flash('Notification(s) cleared successfully.')->success();
                return redirect()->back();
            }
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while clearing the notification(s).')->error();
        }

        return redirect()->back();
    }
}
