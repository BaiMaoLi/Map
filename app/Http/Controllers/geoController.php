<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\location;
use App\bookTable;
use App\Admin;
use App\Notifications\RejectNotification;
use Illuminate\Support\Facades\Hash;


class geoController extends Controller
{

    public function geoUpdate(Request $request)
    {

        $user = auth::user();
        $kind = $user->kind;
        if ($kind == 'passanger') {

            //-------------------Updating Passenger Himself location------------------------------//

            $id = $user->id;
            $location = location::where('user_id', $id)->first();
            $time2 = (new \DateTime)->format('Y-m-d h:i');
            if (!is_null($request['lat']) && !is_null($request['lng'])) {
                if (is_null($location)) {
                    $location = new location;
                    $location->user_id = $id;
                    $location->last_on_line_time = (new \DateTime())->format('Y-m-d h:i:s');
                    $location->lat = $request['lat'];
                    $location->lan = $request['lng'];
                    $location->save();
                } else {
                    $location->last_on_line_time = (new \DateTime())->format('Y-m-d h:i:s');
                    $location->lat = $request['lat'];
                    $location->lan = $request['lng'];
                    $location->save();
                }
            }
            //------------------------------------------------End Updating---------------------------------------------------//

            //-------------------Getting the drivers in rainge 2Km-----------------------------------------------------------//
            $time = (new \DateTime())->format('Y-m-d h:i:s');
            $time1 = new \DateTime($time);
            $time1->modify('- 10 day');
            $online_drivers = location::where('last_on_line_time', '>', $time1)->pluck('user_id')->toArray();
            $users = User::where([['suspection', '<', $time], ['kind', '=', 'driver']])->whereIn('id', $online_drivers)->get();
            $user_lat = $location['lat'];
            $user_lan = $location['lan'];
//                        $users=user::where('kind','driver')->get();
            $driver_lats = Array();
            $driver_lans = Array();
            $driver_phone = Array();
            $driver_ids = Array();
            $driver_profiles = Array();
            $i = 0;
            foreach ($users as $user1) {
                $driver_location = location::where('user_id', $user1->id)->first();
                if (abs(floatval($user_lat) - $driver_location['lat']) < 5 / 111 && abs(floatval($user_lan) - $driver_location['lan']) < 5 / 111) {
//                    if (is_null(bookTable::where('driver_id','=',$user1['id'])->first()) || !is_null(bookTable::where([['passenger_id','=',$id],['cancell_by_passenger','=',0]])->first())){    //That is, driver is not booked now.
                    if (is_null(bookTable::where([['driver_id', '=', $user1['id']], ['passenger_id', '!=', $id]])->first())) {    //That is, driver is not booked now.
                        $driver_lats[$i] = $driver_location['lat'];
                        $driver_lans[$i] = $driver_location['lan'];
                        $driver_phone[$i] = $user1['phone_number'];
                        $driver_profiles[$i] = $user1['profile_url'];
                        $driver_ids[$i] = $user1['id'];
                        $i++;
                        //}
                    }
                }
            }
            //----------------------------End Getting-------------------------------------------------------------------------//

            //---------------------------Getting Booked Driver----------------------------------------------------------------//
            $booked_driver_id = 0;
            $cancell_by_driver = 0;
            $booktable = bookTable::where([['passenger_id', '=', $id], ['cancell_by_passenger', '!=', 1]])->first();
            if (!is_null($booktable)) {
                $booked_driver_id = $booktable->driver_id;
                $cancell_by_driver = $booktable->cancell_by_driver;
            }


            return response()->json(['lat' => $request['lat'], 'lng' => $request['lng'], 'time' => (new \DateTime())->format('i:s'), 'driver_lats' => $driver_lats,
                'driver_lans' => $driver_lans, 'phone_number' => $driver_phone, 'driver_ids' => $driver_ids, 'kind' => $kind, 'booked_driver_id' => $booked_driver_id, 'cancell_by_driver' => $cancell_by_driver, 'profile_url' => $driver_profiles]);

        } else {
            $id = $user->id;
            //------------------Getting location of driver himself------------//
            $location = location::where('user_id', $id)->first();
            if (!is_null($request['lat']) && !is_null($request['lng'])) {
                if (is_null($location)) {
                    $location = new location;
                    $location->user_id = $id;
                    $location->last_on_line_time = (new \DateTime())->format('Y-m-d h:i:s');
                    $location->lat = $request['lat'];
                    $location->lan = $request['lng'];
                    $location->save();
                } else {
                    $location->last_on_line_time = (new \DateTime())->format('Y-m-d h:i:s');
                    $location->lat = $request['lat'];
                    $location->lan = $request['lng'];
                    $location->save();
                }
            }
            $user_lat = $location['lat'];
            $user_lan = $location['lan'];
            //--------------------------End Getting Location---------------------//

            //------------------Getting Booked Passenger-------------------------//
            $booktable = bookTable::where([['driver_id', '=', $user->id], ['cancell_by_driver', '!=', 1]])->first();
            if (is_null($booktable)) {
                $passenger_id = 0;
                $passenger_lat = 0;
                $passenger_lng = 0;
                $phone_number = 0;
                $cancell_by_passenger = 0;
                $driver_confirm_state = 0;
            } else {
                $passenger_id = $booktable->passenger_id;
                $passenger_lat = location::where('user_id', $passenger_id)->first()->lat;
                $passenger_lng = location::where('user_id', $passenger_id)->first()->lan;
                $phone_number = user::where('id', $passenger_id)->first()->phone_number;
                $cancell_by_passenger = $booktable->cancell_by_passenger;
                $driver_confirm_state = $booktable->driver_confirm_state;
            }

            return response()->json(['kind' => $kind, 'passenger_lat' => $passenger_lat, 'passenger_lng' => $passenger_lng, 'passenger_id' => $passenger_id, 'lat' => $user_lat, 'lng' => $user_lan, 'phone_number' => $phone_number,
                'cancell_by_passenger' => $cancell_by_passenger, 'driver_confirm_state' => $driver_confirm_state]);
        }
    }

    public function bookRegister(Request $request)
    {
        $user = auth::user();
        $booktable = bookTable::where('passenger_id', $user->id)->first();
        if (is_null($booktable)) {
            $booktable = new bookTable;
        }
        $booktable->passenger_id = $user->id;
        $booktable->driver_id = (int)$request['driver_id'];

        $booktable->save();
        return response()->json(['success' => $request['driver_id']]);
    }

    public function create_user()
    {

    }

    public function compareTime($time2, $time3)
    {
        if ($time2 < $time3) {
            return true;
        } else return false;
    }

    public function bookCancell(Request $request)
    {
        $user = auth::user();
        $booktable = bookTable::where('driver_id', $request['driver_id'])->first();
        if (!is_null($booktable)) {
            $booktable->cancell_by_passenger = 1;
            $booktable->save();
        }
        return response()->json(['success' => $request['driver_id']]);
    }

    public function passengerConfirmCancell(Request $request)
    {
        $user = auth::user();
        $booktable = bookTable::where('passenger_id', $user->id)->first();
        if (!is_null($booktable)) {
            $booktable->delete();
        }
        return response()->json(['success' => 'Success']);
    }

    public function bookAccept(Request $request)
    {
        $user = auth::user();
        $booktable = bookTable::where('driver_id', $user->id)->first();
        if (!is_null($booktable)) {
            $booktable->driver_confirm_state = 1;

            $booktable->save();

        }
        return response()->json(['success' => 'Success']);
    }

    public function bookReject(Request $request)
    {
        $user = auth::user();
        $booktable = bookTable::where('driver_id', $user->id)->first();
        if (!is_null($booktable)) {
            $booktable->cancell_by_driver = 1;
            $booktable->save();
        }

        $driver_name = $user->name;
        $rejectMessage = " reject booking";
        $rejectTime = (new \DateTime())->format('Y:m:d h:i A');
        //Sending Notification to Admin
        $admins = Admin::all();
        foreach ($admins as $admin) {
            $admin->notify(new RejectNotification($driver_name, $rejectMessage, $rejectTime));
        }
        return response()->json(['success' => $request['driver_id'], 'admin' => $admins]);
    }

    public function driverConfirmCancell(Request $request)
    {
        $user = auth::user();
        $booktable = bookTable::where('driver_id', $user->id)->first();
        if (!is_null($booktable)) {
            $booktable->delete();
        }
        return response()->json(['success' => 'Success']);
    }

}

