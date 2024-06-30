<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
            // return response()->json(['message' => 'Invalid credentials'], 401);
            return back()->with('error','Invalid credentials');
        }
    }

    public function user_homepage(){
        $lastMonth = Carbon::now()->subMonth();
        $newLaunched = Product::where('created_at', '>=', $lastMonth)->get();
        return view('users.homepage', compact('newLaunched'));
    }
    

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function check_email(Request $request){
        $email = $request->email ?? '';
        $exists = User::where('email', $email)->exists();
    return response()->json(['exists' => $exists]);
    }

    public function check_phone(Request $request){
        $phone = $request->phone ?? '';
        $exists = User::where('phone', $phone)->exists();
        return response()->json(['exists' => $exists]);
    }
}
