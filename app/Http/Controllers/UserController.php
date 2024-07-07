<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;


class UserController extends Controller
{
    public function login_page(Request $request)
    {
        // dd($request->cookie('guest_user_token'));
        $userToken = $request->cookie('guest_user_token');
        // dd($userToken);
        if ($userToken) {
            $lastMonth = Carbon::now()->subMonth();
            $newLaunched = Product::where('created_at', '>=', $lastMonth)->get();
            return view('users.homepage', compact('newLaunched'));
        } else {
            return view('welcome');
        }
    }
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
                return redirect('/homepage')->with('user', $user);
            }

            return response()->json(['message' => 'Login successful', 'user' => $user]);
        } else {
            // Authentication failed...
            // return response()->json(['message' => 'Invalid credentials'], 401);
            return back()->with('error', 'Invalid credentials');
        }
    }

    public function user_homepage()
    {
        $lastMonth = Carbon::now()->subMonth();
        $newLaunched = Product::where('created_at', '>=', $lastMonth)->paginate(5);
        return view('users.homepage', compact('newLaunched'));
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function check_email(Request $request)
    {
        $email = $request->email ?? '';
        $exists = User::where('email', $email)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function check_phone(Request $request)
    {
        $phone = $request->phone ?? '';
        $exists = User::where('phone', $phone)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function guest_login(Request $request)
    {
        $user = null;

        if (!Auth::check()) {
            $userToken = $request->cookie('guest_user_token');
            // dd($userToken);
            if ($userToken) {
                // Find the user by token
                $user = User::where('temporary', true)->where('guest_token', $userToken)->first();

                if (!$user) {
                    // Create a new temporary user if token is invalid
                    $user = $this->createTemporaryUser();
                }
                Cookie::queue('guest_user_token', $userToken, 60 * 24 * 7); // 1 week
                Auth::login($user);
            } else {
                // Create a new temporary user if no token
                $user = $this->createTemporaryUser();
                // dd($user);
                Cookie::queue('guest_user_token', $user->guest_token, 60 * 24 * 7); // 1 week
                Auth::login($user);
            }
        } else {
            $user = Auth::user();
        }

        return redirect('/homepage');
    }

    private function createTemporaryUser()
    {
        $userToken = Str::random(60);
        $phone = rand(1, 9);
        $user = User::create([
            'name' => 'Guest',
            'email' => 'guest_' . Str::random(10) . '@example.com',
            'password' => bcrypt(Str::random(16)),
            'temporary' => true,
            'guest_token' => $userToken,
            'role' => 3,
            'phone' => $phone,
        ]);

        return $user;
    }
}
