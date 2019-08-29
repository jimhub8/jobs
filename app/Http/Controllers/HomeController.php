<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Spatie\Permission\Models\Permission;
class HomeController extends Controller
{
    public function courier()
    {
        $permissions = [];
        foreach (Permission::all() as $permission) {
            if (Auth::user()->can($permission->name)) {
                $permissions[$permission->name] = true;
            } else {
                $permissions[$permission->name] = false;
            }
        }
        // $country = Country::find($user->country_id);
        // // dd($country);
        // $user->country_name = $country->country_name;
        // $users->transform(function ($user, $key) {
        //     $country = Country::find($user->country_id);
        //     $user->country_name = $country->name;
		// 	return $user;
        // });
        // dd(json_decode(json_encode((Auth::user()), false)));
        $user = Auth::user();
        $auth_user = array_prepend($user->toArray(), $permissions, 'can');
        // $auth_user = Auth::user();
        return view('welcome', compact('auth_user'));
    }
    public function courierHome()
    {
        return redirect('/')->where('name', '[A-Za-z]+');
    }
    /**
     * Load homepage
     *
     * @param  Request $request
     * @return view
     */
    public function index(Request $request)
    {
        // return redirect('/login');
        if (Auth::check()) {
            return redirect('/');
        }
    }

    public function passport()
    {
        return view('passport/passport');
    }

}
