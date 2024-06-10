<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Get email and password from the request
        $credentials = $request->only('email', 'password');
        // dd($credentials);
        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $user = Auth::user(); // Now you can access the authenticated user
            if ($user->role == 1) {
                return redirect('/admin-dashboard')->with('user', $user);
                // return view('admin.dashboard', ['user' => $user]);
            } else {
                return redirect('/homepage')->with('user',$user);
            }

            return response()->json(['message' => 'Login successful', 'user' => $user]);
        } else {
            // Authentication failed...
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function user_homepage(){
        return view('users.homepage');
    }
}
