<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;

class AuthController extends Controller
{
    
    public function index()
    {
        return view('login-admin-room-911');
    }

    public function login(Request $request){
        // validate user by name and password
        if(!Auth::attempt($request->only('name','password'))){
            return redirect()->back()->withInput()->with('error','Invalid credentials');
        }

        $user = User::where('name', $request['name'])->firstOrFail();

        if(!$user->hasRole('admin_room_911')){
            return redirect()->back()->withInput()->with('error','User does not have permissions');
        }

        return redirect()->route('employees.index');
    }

    public function logout(){
        Auth::logout();
    
        return redirect('/');
    }
}
