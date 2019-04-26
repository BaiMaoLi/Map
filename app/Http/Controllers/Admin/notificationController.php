<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class notificationController extends Controller
{
    public function _construct(){
        $this->middleware('auth:admin');
    }
    public function show(){
        $admin= \Auth::guard('admin')->user();
        $notifications=$admin->notifications()->get()->toArray();
        return view('admin.notification',compact('notifications'));
    }

    public function readNotification(){
        $today=new \DateTime();
        $admin= \Auth::guard('admin')->user();
        $notifications=$admin->unreadNotifications()->get()->toArray();
        return response()->json(['notifications'=>$notifications]);
    }

    public function markAsRead(){
        $admin= \Auth::guard('admin')->user();
        $notifications=$admin->unreadNotifications()->get();
        foreach ($notifications as $notification) {
            $notification->markAsRead();

        }
        return response()->json(['Success'=>'Success']);

    }
    




}
