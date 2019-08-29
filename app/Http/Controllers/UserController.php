<?php

namespace App\Http\Controllers;

use App\Notifications\SignupActivate;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        // return $request->all();
        // return User::with(['roles'])->get();
        if (Auth::user()->hasRole('Super admin')) {
            $users = User::paginate(500);
        } else {
            $super_admin = User::FirmId()->paginate(500);
            $users = $super_admin->reject(function ($user, $key) {
                return $user->hasRole('Super admin');
            });
            $id = [];
            foreach ($users as $value) {
                $id[] = $value->id;
            }
            $users = User::whereIn('id', $id)->paginate(500);
        }
        // $users = User::FirmId()->orderBy('name')->with('roles')->paginate(500);
        $users->transform(function ($user, $key) {
            $user->status = 'active';
            return $user;
        });
        // return $users;
        return response()->json($users);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $this->generateRandomString();
        // return $request->all();
        // return $request->all();
        // $this->Validate($request, [
        //     'name' => 'required',
        //     'email' => 'required|email',
        //     'phone' => 'required',
        //     'role_id' => 'required',
        // ]);
        $user = new User;
        $password = $this->generateRandomString();
        $password_hash = Hash::make($password);
        $user->password = $password_hash;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->department = $request->department;
        $user->address = $request->address;
        $user->position = $request->position;
        if (Auth::user()->hasRole('Super admin')) {
            $user->firm_id = $request->firm_id;
        } else {
            $user->firm_id = Auth::user()->firm_id;
        }
        // $user->country_id = $request->countryList;
        // $user->activation_token = str_random(60);
        $user->assignRole($request->role_id);
        $user->save();
        $user->notify(new SignupActivate($user, $password));
        return $user;
    }
    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request->all();
        // return $request->selected;
        $this->Validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            // 'phone' => 'required|numeric',
            // 'branch_id' => 'required',
            // 'address' => 'required',
            // 'city' => 'required',
            // 'country' => 'required',
            // 'role_id' => 'required'
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->department = $request->department;
        $user->address = $request->address;
        $user->position = $request->position;
        $user->save();
        $user->syncRoles($request->role_id);

        return $user;
    }

    public function AuthUserUp(Request $request)
    {
        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->branch_id = $request->branch_id;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->country = $request->country;
        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::find($user->id)->delete();
    }

    public function getLogedinUsers()
    {
        return Auth::user();
    }

    // public function profile(Request $request, $id)
    // {
    //     $upload = User::find($request->id);
    //     if ($request->hasFile('image')) {
    //         // return('test');
    //         // $imagename = time() . $request->image->getClientOriginalName();
    //         // $request->image->storeAs('public/test', $imagename);
    //         $img = $request->profile;
    //         // $image_path = ;
    //         if (!empty($upload->profile)) {
    //             $image_file_arr = explode('/', $upload->profile);
    //             $image_file = $image_file_arr[3];

    //             if (File::exists('storage/profile/' . $image_file)) {
    //                 $image_path = 'storage/profile/' . $image_file;
    //                 File::delete($image_path);
    //             }
    //             // return('image_filtgtre_arr');

    //             $imagename = Storage::disk('uploads')->put('profile', $img);
    //                 // return 'ppp';
    //         } else {
    //             $imagename = Storage::disk('uploads')->put('profile', $img);
    //         }
    //         return $imagename;
    //         $imgArr = explode('/', $imagename);
    //         $image_name = $imgArr[1];
    //         $upload->profile = '/storage/profile/' . $image_name;
    //         // $upload->image = '/storage/profile/'.$image_name;
    //         $upload->save();
    //         return $upload;
    //         // $imagename =  Storage::disk('uploads')->put('profile', $img);
    //     }
    //     return;

    // }

    public function profile(Request $request, $id)
    {
        $upload = User::find($request->id);
        if ($request->hasFile('image')) {
            // return('test');
            // $imagename = time() . $request->image->getClientOriginalName();
            // $request->image->storeAs('public/test', $imagename);
            $img = $request->image;
            // $image_path = ;

            if (File::exists('storage/profile/' . $upload->image)) {

                // return('test');
                $image_path = 'storage/profile/' . $upload->image;

                File::delete($image_path);
                // return $image_path;
            }
            // $imagename =  Storage::disk('uploads')->put('profile', $img);
            $imagename = Storage::disk('public')->put('profile', $img);
        }

        // return('noop');
        $imgArr = explode('/', $imagename);
        $image_name = $imgArr[1];
        $upload->profile = '/storage/profile/' . $image_name;
        // $upload->profile = '/healthwise/products/'.$image_name;
        $upload->save();
        return $upload;
    }


    public function getSorted(Request $request)
    {
        // return $request->all();
        $roles = User::all();
        $users_id = [];
        $users = User::all();
        $userArr = [];
        foreach ($users as $user) {
            if ($user->hasRole($request->name)) {
                $userArr[] = $user;
            }
        }
        return $userArr;
    }


    public function getUserPerm(Request $request, $id)
    {
        $user = User::find($id);
        $permissions = $user->getAllPermissions();
        $can = [];
        foreach ($permissions as $perm) {
            $can[] = $perm->name;
        }
        return $can;
    }

    public function password(Request $request)
    {
        $this->Validate($request, [
            'password' => 'required|string|min:6',
            // 'password' => 'required|string|min:6|confirmed',
        ]);
        $user = User::find(Auth::id());
        $user->password = Hash::make($request->password);
        $user->save();
        return $user;
    }

    public function logoutOther()
    {
        return view('auth.Logout');
    }

    public function logOtherDevices(Request $request)
    {
        Auth::logoutOtherDevices($request->password);
        return redirect('/courier');
    }

    public function permisions(Request $request, $id)
    {
        // return $request->all();
        $user = User::find($id);
        $user->syncPermissions($request->selected);
        return $user;
    }


    public function undeletedUser($id)
    {
        return User::find($id)->restore();
    }

    public function delete_user($id)
    {
        User::withTrashed()->where('id', $id)->first()->forceDelete();
    }

    public function deletedUsers()
    {
        return $users = User::onlyTrashed()->get();
        return $users;
    }

    public function filter_users($search)
    {
        return User::where('name', 'LIKE', "%{$search}%" )->get();
    }
}
