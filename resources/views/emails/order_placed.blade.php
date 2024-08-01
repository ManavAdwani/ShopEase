<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Placed</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .email-header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        .email-body {
            padding: 20px;
        }

        .email-footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <h2>New Order Notification</h2>
        </div>
        <div class="email-body">
            <p>Dear Admin,</p>
            <p>A new order has been placed on your website. Here are the details:</p>
            <table class="table table-bordered">
                <tr>
                    <th>Order ID</th>
                    <td>{{ $order->id }}</td>
                </tr>
                <tr>
                    <th>Customer Name</th>
                    @php
                    $getUserName = DB::table('users')->where('id',$order->user_id)->select('name','email')->first();
                    @endphp
                    <td>{{ $getUserName->name }}</td>
                </tr>
                <tr>
                    <th>Party Name</th>
                    <td>{{ $order->cmp_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Customer Email</th>
                    <td>{{ $getUserName->email }}</td>
                </tr>
                <tr>
                    <th>Total Amount</th>
                    @php
                    $cartIds = $order->cart_ids ?? '0';

                    // Split the comma-separated values into an array
                    $cartIdsArray = explode(',', $cartIds);
                    foreach($cartIdsArray as $cartId){
                        $getProduct = DB::table('carts')->where('id',$cartId)->select('product_id','quantity')->first();
                        $getProductAmt = DB::table('products')->where('id',$getProduct->product_id ?? 0)->select('product_price')->first();
                        $productPrice = $getProductAmt->product_price ?? 0;
                        $TotalAmt = $productPrice * $getProduct->quantity ?? 0;
                    }
                    @endphp
                    <td>₹{{ $TotalAmt }}</td>
                </tr>
            </table>
            <p>Please check the admin panel for more details.</p>
            <p>Thank you!</p>
        </div>
        <div class="email-footer">
            &copy; {{ date('Y') }} Your Company. All rights reserved.
        </div>
    </div>
</body>

</html>