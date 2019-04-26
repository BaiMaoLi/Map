<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
//        return Validator::make($data, [
//            'name' => 'required|string|max:255',
//            'email' => 'required|string|email|max:255|unique:users',
//            'kind' => 'string|max:255',
//            'phone_number' => 'required|string|max:255',
//            'profile_url' => 'string|max:255',
//            'password' => 'required|string|min:6|confirmed',
//        ]);


        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:255',
//            'profile_url' => 'string',
            'password' => 'required|string|min:6|confirmed',
        ]);




    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        if ($data['kind']=='driver'){
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'profile_url' => $data['profile_url'],
                'password' => Hash::make($data['password']),
                'phone_number'=>'+234'.$data['phone_number'],
                'kind'=>$data['kind'],
            ]);
        }
        else{
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone_number'=>'+234'.$data['phone_number'],
                'kind'=>$data['kind'],
            ]);
        }
    }
}
