<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\location;

class passengerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function show(){
        $time=(new \DateTime())->format('Y-m-d h:i:s');
        $time1=new \DateTime($time);
        $time1->modify('- 10 day');
        $online_passengers=location::where('last_on_line_time','>',$time1)->pluck('user_id')->toArray();
        $passengers=User::where('kind','=','passanger')
            ->whereIn('id',$online_passengers)->get();

        $passenger_ids=$passengers->pluck('id');
        $locations=location::whereIn('user_id',$passenger_ids)->get(['lat','lan']);
        return view('admin.passengers.show',compact('passengers','locations'));
    }


}
