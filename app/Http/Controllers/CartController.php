<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Mail\OrderPlaced;
use Illuminate\Support\Facades\Mail;


class CartController extends Controller
{
    public function cart_index()
    {
        $cartProducts = Cart::join('products', 'products.id', '=', 'carts.product_id')->select('products.id as productId', 'products.product_name', 'products.product_price', 'products.images', 'products.company_id', 'carts.*')->where('user_id', auth()->user()->id)->where('status', '=', 'pending')->get();
        return view('users.cart.cart_page', compact('cartProducts'));
    }

    public function update_cart(Request $request)
    {
        $cart_id = $request->cart_id ?? 0;
        $product_quantity = $request->cart_quantity ?? 0;
        try {
            $cart = Cart::findOrFail($cart_id);
            if ($product_quantity == 0) {
                $cart->delete();
                return response()->json(['status' => 'success', 'message' => 'Cart deleted successfully!']);
            } else {
                $cart->quantity = $product_quantity;
                $cart->save();
                return response()->json(['data' => $cart, 'status' => 'success', 'message' => 'Cart quantity updated successfully!']);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Cart not found!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong! Please try again later.']);
        }
    }

    public function user_address()
    {
        $user_address = UserAddress::where('user_id', auth()->user()->id)->get();
        return view('users.address.address', compact('user_address'));
    }

    public function store_address(Request $request)
    {
        // dd("HI");
        $user = auth()->user()->id;
        $address = $request->input('address') ?? '';
        $country = $request->input('country') ?? '';
        $pincode = $request->input('zipcode') ?? '';
        $city = $request->input('city') ?? '';
        $state = $request->input('state') ?? '';
        $name = $request->input('name') ?? '';
        $phone = $request->input('phone') ?? '';
        $input = [
            'user_id' => $user,
            'address' => $address,
            'zipcode' => $pincode,
            'city' => $city,
            'state' => $state,
            'cmp_name'=>$name,
            'phone'=>$phone
        ];
        $address = UserAddress::create($input);

        $getOrders = Cart::where('user_id', $user)->where('status','pending')->pluck('id')->toArray();
        $cartIdsString = implode(',', $getOrders);

        // Step 2: Check if an order with the same user_id and cart_ids exists
        $existingOrder = Order::where('user_id', $user)
            ->where('cart_ids', $cartIdsString)
            ->first();

        if ($existingOrder) {
            // $data = array('name'=>"Virat Gandhi");
           

            // Mail::to('recipient@example.com')->send(new ExampleMail($data));
            // Step 3: If such an order exists, do not create a new order
            return response()->json(['message' => 'Order already exists'], 200);
        }

        // Step 4: If no such order exists, create a new order
        $orderInput = [
            'user_id' => $user,
            'cart_ids' => $cartIdsString,
            'status' => "pending",
            'address'=>$address->id
        ];
        foreach ($getOrders as $cartId) {
            try {
                $findCartId = Cart::findOrFail($cartId);
                $findCartId->status = "Ordered";
                $findCartId->save();
            } catch (ModelNotFoundException $e) {
                // Handle the case where a cart ID is not found
                // Log the error or handle it as needed
                error_log("Cart ID {$cartId} not found.");
            } catch (\Exception $e) {
                // Handle any other potential errors
                // Log the error or handle it as needed
                error_log("An error occurred while updating Cart ID {$cartId}: {$e->getMessage()}");
            }
        }
        // dd("HI");
        $storeOrder = Order::create($orderInput);
        Mail::to('admin@example.com')->send(new OrderPlaced($storeOrder));

        
        if (!empty($address->id)) {
            return view('users.thank_you.order_placed')->with('storeOrder',$storeOrder->address);
        }
    }

    public function getCityState(Request $request)
    {
        $pinCode = $request->input('pinCode');
        $apiUrl = "http://api.zippopotam.us/in/{$pinCode}";

        $client = new Client();
        try {
            $response = $client->get($apiUrl);
            $data = json_decode($response->getBody(), true);

            if (isset($data['places']) && count($data['places']) > 0) {
                $place = $data['places'][0];
                return response()->json([
                    'city' => $place['place name'],
                    'state' => $place['state']
                ]);
            } else {
                return response()->json(['error' => 'Invalid pin code'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch location data'], 500);
        }
    }

    public function save_order_old($address_id){
        $user = auth()->user()->id;
        $user_ad = $address_id;
        $getOrders = Cart::where('user_id', $user)
                 ->where('status', 'pending')
                 ->pluck('id')
                 ->toArray();
        $cartIdsString = implode(',', $getOrders);
        // dd($getOrders);
        // Step 2: Check if an order with the same user_id and cart_ids exists
        $existingOrder = Order::where('user_id', $user)
            ->where('cart_ids', $cartIdsString)
            ->first();

        if ($existingOrder) {
            // Step 3: If such an order exists, do not create a new order
            return response()->json(['message' => 'Order already exists'], 200);
        }

        // Step 4: If no such order exists, create a new order
        $orderInput = [
            'user_id' => $user,
            'cart_ids' => $cartIdsString,
            'status' => "pending",
            'address'=>$user_ad
        ];
        foreach ($getOrders as $cartId) {
            try {
                $findCartId = Cart::findOrFail($cartId);
                $findCartId->status = "Ordered";
                $findCartId->save();
            } catch (ModelNotFoundException $e) {
                // Handle the case where a cart ID is not found
                // Log the error or handle it as needed
                error_log("Cart ID {$cartId} not found.");
            } catch (\Exception $e) {
                // Handle any other potential errors
                // Log the error or handle it as needed
                error_log("An error occurred while updating Cart ID {$cartId}: {$e->getMessage()}");
            }
        }
        // dd("HI");
        $storeOrder = Order::create($orderInput);

        
        if (!empty($storeOrder->id)) {
            return view('users.thank_you.order_placed')->with('storeOrder',$storeOrder->address);
        }
    }
}
