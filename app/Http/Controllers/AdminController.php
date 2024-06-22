<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\AdminNavBar;
use Illuminate\Http\Request;
// use DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;


class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::where('status', 1)->count();
        $totalOrders = Order::count();
        $totalSalesman = User::where('role', 2)->where('status', 1)->count();
        $activePage = 'dashboard';
        $user = session('user'); // Retrieve the flashed data from the session

        $orders = DB::table('orders')
            ->select(DB::raw('COUNT(*) as order_count'), DB::raw('MONTH(created_at) as month'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
        $months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];

        $orderData = array_fill(1, 12, 0); // Initialize array with 0 values for each month

        foreach ($orders as $order) {
            $orderData[$order->month] = $order->order_count;
        }

        $OrderschartData = [
            'labels' => array_values($months),
            'data' => array_values($orderData),
        ];


        return view('admin.dashboard', compact('user', 'activePage', 'totalUsers', 'totalOrders', 'totalSalesman', 'OrderschartData'));
    }

    public function users()
    {
        $activePage = 'users';
        $users = User::where('status', 1)->get();
        $totalUsers = User::where('status', 1)->count();
        $activeUsers = User::where('status', 1)->count();
        // $notActiveUsers = User::where('status',0)->count();
        $totalSalesPerson = User::where('role', 2)->where('status', 1)->count();
        return view('admin.users.users', compact('activePage', 'users', 'totalUsers', 'activeUsers', 'totalSalesPerson'));
    }

    public function create_user()
    {
        $activePage = 'users';
        return view('admin.users.create_user', compact('activePage'));
    }

    public function store_user(Request $request)
    {
        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8',
            'userRole' => 'required',
            'profile' => 'nullable|max:2048' // Validate the profile picture
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $password = $request->input('password');
        $cpass = $request->input('cpass');
        $user_role = $request->input('userRole');
        // dd($password."_".$cpass);
        if ($password === $cpass) {
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->phone = $phone;
            $user->role = $user_role;
            $user->status = 1;
            $user->password = bcrypt($password); // Hash the password
            // dd($request->file('profile'));
            // Handle profile picture upload
            if ($request->hasFile('profile')) {
                $profile = $request->file('profile');
                $profilePath = $profile->store('profiles', 'public'); // Store the file in the 'public/profiles' directory
                $user->profile = $profilePath; // Save the file path in the database
            }

            $user->save();
            return redirect()->route('admin.users')->with('success', 'User created successfully.');
        } else {
            return back()->withInput()->withErrors(['password' => 'Passwords do not match.']);
        }
    }

    public function edit_user($id)
    {
        $activePage = 'users';
        $user = User::where('id', '=', $id)->select('name', 'email', 'phone', 'profile', 'id', 'role')->first();
        $user_name = $user->name;
        $user_email = $user->email;
        $user_phone = $user->phone;
        $user_pfp = $user->profile;
        $user_id = $user->id;
        $user_role = $user->role;
        // dd($user_pfp);
        return view('admin.users.edit_user', compact('user_role', 'user_name', 'user_email', 'user_phone', 'user_pfp', 'activePage', 'user_id'));
    }

    public function update_user($id, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'profile' => 'nullable|max:2048', // Validate the profile picture
            'userRole' => 'required'
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $user_role = $request->input('userRole');

        $user = User::find($id);
        if ($user) {
            $user->name = $name;
            $user->email = $email;
            $user->phone = $phone;
            $user->role = $user_role;
            if ($request->hasFile('profile')) {
                $profile = $request->file('profile');
                $profilePath = $profile->store('profiles', 'public'); // Store the file in the 'public/profiles' directory
                $user->profile = $profilePath; // Save the file path in the database
            }
            $user->save();
            return redirect()->route('admin.users')->with('success', 'User updated successfully.');
        } else {
            return back()->withInput()->withErrors(['user' => 'Something went wrong ! please try again']);
        }
    }

    public function change_pass($id)
    {
        $activePage = 'user';
        $user = User::find($id);
        $user_id = $id;
        $user_email = $user->email;
        if ($user) {
            return view('admin.users.change_pass', compact('user', 'activePage', 'user_id', 'user_email'));
        } else {
            return back()->withErrors(['user' => 'Something went wrong ! please try again']);
        }
    }

    public function update_pass($id, Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8',
        ]);

        $pass = $request->input('password');
        $cpass = $request->input('cpass');
        $phone = $request->input('phone');


        $user = User::find($id);
        if ($user) {
            if ($pass == $cpass) {
                $user->password = $pass;
                $user->save();
                return redirect()->route('admin.users')->with('success', 'User password updated successfully !');
            } else {
                return back()->withInput()->withErrors(['password' => 'Password should be same !']);
            }
        } else {
            return back()->withInput()->withErrors(['user' => 'Something went wrong ! please try again']);
        }
    }

    public function delete_user($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->status = 2;
            $user->save();
            return redirect()->route('admin.users')->with('success', 'User deleted successfully !');
        } else {
            return back()->withInput()->withErrors(['user' => 'Something went wrong ! please try again']);
        }
    }

    public function upload_users()
    {
        $activePage = "users";
        return view('admin.users.users_csv', compact('activePage'));
    }

    public function store_csv_users(Request $request)
    {
        // dd($request->all());
        $usersData = $request->usersData;
        // dd($usersData);

        foreach ($usersData as $userData) {
            $input = [
                'name' => $userData[0],
                'email' => $userData[1],
                // 'role' will be assigned based on the condition below
                'phone' => $userData[3],
                'password' => bcrypt('secret123'),
                'status' => 1,
            ];

            if ($userData[2] == "User") {
                $input['role'] = 3;
            } elseif ($userData[2] == "Sales person") {
                $input['role'] = 2;
            } else {
                $input['role'] = 1;
            }


            // Save the data into the database
            User::create($input);
        }

        return redirect()->route('admin.users')->with('success', 'Users stored successfully !');
    }

    public function settings()
    {
        $activePage = "settings";
        return view('admin.settings.settings', compact('activePage'));
    }

    public function setting_update(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'website_name' => 'required',
            'website_logo' => 'required'
        ]);

        // Retrieve the website name from the request
        $website_name = $request->input('website_name') ?? '';

        // Attempt to find the existing setting record in the database
        $setting = AdminNavBar::first();

        // If no existing record is found, create a new instance
        if (!$setting) {
            $setting = new AdminNavBar();
        }

        // Update the setting's name
        $setting->name = $website_name;

        // If a new logo file is provided, handle the file upload
        if ($request->hasFile('website_logo')) {
            $website_logo = $request->file('website_logo');
            $website_logoPath = $website_logo->store('website_logo', 'public'); // Store the file in the 'public/website_logo' directory
            $setting->logo = $website_logoPath; // Save the file path in the database
        }

        // Save the updated setting record to the database
        $setting->save();

        // Redirect back with a success message
        return back()->with('success', 'Website setting updated');
    }

    public function download_users_csv()
    {
        $file = public_path('sample_csv/users_sample.csv');

        $headers = array(
            'Content-Type: application/pdf',
        );

        return response()->download($file);
    }
}
