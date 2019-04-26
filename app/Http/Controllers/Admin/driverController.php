<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\location;
use phpDocumentor\Reflection\Types\Null_;


class driverController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function show(){
        $time=(new \DateTime())->format('Y-m-d h:i:s');
        $time1=new \DateTime($time);
        $time1->modify('- 10 day');
        $online_drivers=location::where('last_on_line_time','>',$time1)->pluck('user_id')->toArray();
        $drivers=User::where([['suspection','<',$time],['kind','=','driver']])
            ->whereIn('id',$online_drivers)->get();

        $driver_ids=$drivers->pluck('id');
        $locations=location::whereIn('user_id',$driver_ids)->get(['lat','lan']);
        return view('admin.drivers.show',compact('drivers','locations'));
    }

    public function suspect($id){
        $time=(new \DateTime())->format('Y-m-d h:i:s');
        $time1=new \DateTime($time);
        $time1->modify(' +30 day');
        $driver=User::where('id',$id)->first();
        $driver->suspection=$time1->format('Y-m-d h:i:s');
        $driver->save();
        return redirect('/admin/home');
    }
    public function terminate($id){
        $driver=User::where('id',$id)->first();
        $driver->suspection='forever';
        $driver->save();
        return redirect('/admin/home');
    }

    public function edit($id){
        $driver=User::where('id',$id)->first();
        return view('admin.drivers.edit',compact('driver'));
    }

    public function update(Request $request,$id){
        $driver=User::where('id',$id)->first();
        $driver->name=$request->input('name');
        $driver->phone_number=$request->input('phone_number');
        $driver->profile_url=$request->input('profile_url');
        $driver->save();
        return redirect('admin/home');
    }
}
//https://www.google.com/maps/search/?api=1&query=58.698017,-152.522067