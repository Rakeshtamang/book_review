<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class AccountController extends Controller
{
    public function register()
    {
        return view('account.register');
    }

    public function RegisterUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }

        // Code to register the user goes here
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

           return redirect()->route('account.login')->with('success', 'User registered successfully!');
    }
    public function login()
    {
        return view('account.login');
    }
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('account.login')->withInput()->withErrors($validator);
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('account.profile');
        } else {
            return redirect()->route('account.login')->with('error', 'Invalid email or password');
        }
    }
    public function profile()
    {
        $user=User::find(Auth::user()->id);
        return view('account.profile',['user'=>$user]);
    }
    public function updateProfile(Request $request)
{
    $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email,' . Auth::user()->id,
    ];

    if ($request->hasFile('image')) {
        $rules['image'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';  // Adjusted to include mime types and max size
    }

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return redirect()->route('account.profile')->withErrors($validator)->withInput();
    }

    $user = User::find(Auth::user()->id);

    if (!$user) {
        return redirect()->route('account.profile')->with('error', 'User not found');
    }

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->hasFile('image')) {
        File::delete(public_path('uploads/profile/' . $user->image));
        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/profile'), $image_name);
        $user->image = $image_name;
    }

    $user->save();

    return redirect()->route('account.profile')->with('success', 'Profile updated successfully');
}

    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }
}
