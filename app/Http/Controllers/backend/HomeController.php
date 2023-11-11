<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('backend.dashboard');
    }

    public function profile()
    {
        return view('backend.user.profile');
    }

    public function editProfile($id) {
        return view('backend.user.editProfile');
    }
    
    public function updateProfile(Request $request,$user_id){
        $validation = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = Admin::find($user_id);
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('dashboard.view')->with('success', 'Password updated Successfully');
    }
}
