<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Placed</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f7; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;">
    <div style="max-width: 600px; margin: 20px auto; padding: 20px; border-radius: 8px; background-color: #ffffff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <div style="background-color: #007bff; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0;">
            <h2 style="margin: 0; font-size: 24px;">New Order Notification</h2>
        </div>
        <div style="padding: 30px;">
            <p style="font-size: 16px; color: #333; line-height: 1.5;">Dear Admin,</p>
            <p style="font-size: 16px; color: #333; line-height: 1.5;">A new order has been placed on your website. Here are the details:</p>
            <table style="width: 100%; margin: 20px 0; word-wrap: break-word; border-collapse: collapse;">
                <tr>
                    <th style="padding: 12px; border: 1px solid #ddd; background-color: #f4f4f7; color: #333;">Order ID</th>
                    <td style="padding: 12px; border: 1px solid #ddd;">{{ $order->id }}</td>
                </tr>
                <tr>
                    <th style="padding: 12px; border: 1px solid #ddd; background-color: #f4f4f7; color: #333;">Customer Name</th>
                    @php
                    $getUserName = DB::table('users')->where('id',$order->user_id)->select('name','email')->first();
                    @endphp
                    <td style="padding: 12px; border: 1px solid #ddd;">{{ $getUserName->name }}</td>
                </tr>
                <tr>
                    <th style="padding: 12px; border: 1px solid #ddd; background-color: #f4f4f7; color: #333;">Party Name</th>
                    @php
                    $getCmpName = DB::table('user_address')->where('id',$order->address)->select('cmp_name')->first();
                    $cmpName = $getCmpName->cmp_name ?? 'N/A';
                    @endphp
                    <td style="padding: 12px; border: 1px solid #ddd;">{{ $cmpName }}</td>
                </tr>
                <tr>
                    <th style="padding: 12px; border: 1px solid #ddd; background-color: #f4f4f7; color: #333;">Customer Email</th>
                    <td style="padding: 12px; border: 1px solid #ddd;">{{ $getUserName->email }}</td>
                </tr>
                <tr>
                    <th style="padding: 12px; border: 1px solid #ddd; background-color: #f4f4f7; color: #333;">Total Amount</th>
                    @php
                    $cartIds = $order->cart_ids ?? '0';
                    $totalAmount = 0;
                    $cartIdsArray = explode(',', $cartIds);
                    foreach($cartIdsArray as $cartId){
                        $getProduct = DB::table('carts')->where('id',$cartId)->select('product_id','quantity')->first();
                        $getProductAmt = DB::table('products')->where('id',$getProduct->product_id ?? 0)->select('product_price')->first();
                        $productPrice = $getProductAmt->product_price ?? 0;
                        $totalAmount += $productPrice * ($getProduct->quantity ?? 0);
                    }
                    @endphp
                    <td style="padding: 12px; border: 1px solid #ddd;">₹{{ $totalAmount }}</td>
                </tr>
            </table>
            <p style="font-size: 16px; color: #333; line-height: 1.5;">Please check the admin panel for more details.</p>
            <p style="font-size: 16px; color: #333; line-height: 1.5;">Thank you!</p>
        </div>
        <div style="text-align: center; padding: 20px; font-size: 14px; color: #999;">
            &copy; {{ date('Y') }} Sairaj mobiles. All rights reserved.
        </div>
    </div>
</body>

</html>
