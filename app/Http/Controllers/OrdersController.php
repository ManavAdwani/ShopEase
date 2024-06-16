<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function orders()
    {
        $activePage = "orders";
        $orders = Order::orderBy('id', 'DESC')->get();
        return view('admin.orders.orders', compact('activePage', 'orders'));
    }

    public function edit_order($order_id)
    {
        $activePage = "orders";
        $getOrderDetails = Order::where('id', $order_id ?? 0)->select()->first();
        $cartIds = explode(',', $getOrderDetails->cart_ids);
        $status = $getOrderDetails->status;
        return view('admin.orders.edit_order', compact('getOrderDetails', 'cartIds','order_id','activePage','status'));
    }

    public function update_cart_admin(Request $request){
        $cart_id = $request->cart_id ?? 0;
        $updated_quantity = $request->cart_quantity ?? 0;
        $cartDetails = Cart::findOrFail($cart_id);
        if(!empty($cartDetails->id)){
            if($updated_quantity == 0){
                $cartDetails->updated_quantity = null;
                $cartDetails->update();

            }else{
                $cartDetails->updated_quantity = $updated_quantity;
                $cartDetails->update();
            }
            return response()->json(['data' => $cartDetails, 'status' => 'success', 'message' => 'Cart quantity updated successfully!']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'Cart not found!']);
        }
    }

    public function accept_order(Request $request,$order_id){
        $order = Order::findOrFail($order_id);
        if(!empty($order->id)){
            $order->status = "accepted";
            $order->update();
            return redirect()->route('admin.orders');
        }else{
            return back()->with('error','Something went wrong !');
        }
    }

    public function reject_order($order_id){
        $order = Order::findOrFail($order_id);
        if(!empty($order->id)){
            $order->status = "rejected";
            $order->update();
            return redirect()->route('admin.orders');
        }else{
            return back()->with('error','Something went wrong !');
        }
    }
}
