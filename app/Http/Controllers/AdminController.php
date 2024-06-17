<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
// use DB;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard(){
        $totalUsers = User::where('status',1)->count();
        $totalOrders = Order::count();
        $totalSalesman = User::where('role',2)->where('status',1)->count();
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
        

        return view('admin.dashboard', compact('user','activePage','totalUsers','totalOrders','totalSalesman','OrderschartData'));
    }

    public function users(){
        $activePage = 'users';
        $users = User::where('status',1)->get();
        $totalUsers = User::where('status',1)->count();
        $activeUsers = User::where('status',1)->count();
        // $notActiveUsers = User::where('status',0)->count();
        $totalSalesPerson = User::where('role',2)->where('status',1)->count();
        return view('admin.users.users',compact('activePage','users','totalUsers','activeUsers','totalSalesPerson'));
    }

    public function create_user(){
        $activePage = 'users';
        return view('admin.users.create_user',compact('activePage'));
    }

    public function store_user(Request $request) {
        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8',
            'userRole'=>'required',
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

    public function edit_user($id){
        $activePage = 'users';
        $user = User::where('id','=',$id)->select('name','email','phone','profile','id','role')->first();
        $user_name = $user->name;
        $user_email = $user->email;
        $user_phone = $user->phone;
        $user_pfp = $user->profile;
        $user_id = $user->id;
        $user_role = $user->role;
        // dd($user_pfp);
        return view('admin.users.edit_user',compact('user_role','user_name','user_email','user_phone','user_pfp','activePage','user_id'));
    }

    public function update_user($id,Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'profile' => 'nullable|max:2048', // Validate the profile picture
            'userRole'=>'required'
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $user_role = $request->input('userRole');
       
        $user = User::find($id);
        if($user){
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
        }else{
            return back()->withInput()->withErrors(['user' => 'Something went wrong ! please try again']);
        }
    }

    public function change_pass($id){
        $activePage = 'user';
        $user = User::find($id);
        $user_id = $id;
        $user_email = $user->email;
        if($user){
            return view('admin.users.change_pass',compact('user','activePage','user_id','user_email'));
        }else{
            return back()->withErrors(['user' => 'Something went wrong ! please try again']);
        }
    }

    public function update_pass($id, Request $request){
        $request->validate([
            'password' => 'required|string|min:8',
        ]);

        $pass = $request->input('password');
        $cpass = $request->input('cpass');
        $phone = $request->input('phone');

       
        $user = User::find($id);
        if($user){
            if($pass == $cpass){
                $user->password = $pass;
                $user->save();
                return redirect()->route('admin.users')->with('success', 'User password updated successfully !');
            }else{
                return back()->withInput()->withErrors(['password' => 'Password should be same !']);
            }
           
        }else{
            return back()->withInput()->withErrors(['user' => 'Something went wrong ! please try again']);
        }
    }

    public function delete_user($id){
        $user = User::find($id);
        if($user){
            $user->status = 2;
            $user->save();
            return redirect()->route('admin.users')->with('success', 'User deleted successfully !');
        }else{
            return back()->withInput()->withErrors(['user' => 'Something went wrong ! please try again']);
        }
    }

    public function upload_users(){
        $activePage = "users";
        return view('admin.users.users_csv',compact('activePage'));
    }
    
}
