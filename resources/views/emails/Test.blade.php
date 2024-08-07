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
                    {{-- <td>{{ $order->id }}</td> --}}
                </tr>
                <tr>
                    <th>Customer Name</th>
                    {{-- <td>{{ $order->customer_name }}</td> --}}
                </tr>
                <tr>
                    <th>Customer Email</th>
                    {{-- <td>{{ $order->customer_email }}</td> --}}
                </tr>
                <tr>
                    <th>Total Amount</th>
                    {{-- <td>${{ $order->total }}</td> --}}
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
