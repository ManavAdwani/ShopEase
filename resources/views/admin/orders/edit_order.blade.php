<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Order</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/a4c00a89bc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <script src="{{asset('js/edit_order.js')}}"></script>

</head>

<body>
    @include('navbar')
    <div class="container mb-3">
        <h4>
            Order details
        </h4>
    </div>
    @php
    $orderTotal = 0;
    @endphp
    @foreach ($cartIds as $cartId)
    @php
    $cartDetails = DB::table('carts')->where('id', $cartId)->select()->first();
    @endphp
    <div class="container">
        <div class="card mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-2">
                        @php
                        $productDetails =
                        DB::table('products')->where('id',$cartDetails->product_id)->select()->first();
                        @endphp
                        <img src="{{asset($productDetails->images)}}" class="img-fluid" alt="Generic placeholder image">
                    </div>
                    <div class="col-md-2 d-flex justify-content-center">
                        <div>
                            <p class="small text-muted">Name</p>
                            <p class="fw-normal">{{$productDetails->product_name}}</p>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex justify-content-center">
                        <div>
                            <p class="small text-muted">Company</p>
                            @php
                            $companies =
                            DB::table('companies')->where('id',$productDetails->company_id)->select()->first();
                            $company_name = $companies->company_name;
                            @endphp
                            <p class=" fw-normal">{{$company_name}}</p>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex justify-content-center">
                        <div>
                            <p class="small text-muted">Quantity</p>
                            <input type="text" class="form-control" name=""
                                onchange="changeCartValue({{$cartDetails->id}})" @if($cartDetails->updated_quantity !=
                            null || $cartDetails->updated_quantity != 0)
                            value="{{$cartDetails->updated_quantity}}"
                            @else
                            value="{{$cartDetails->quantity}}"
                            @endif
                            id="cartQuan{{$cartDetails->id}}" style="width: 60px">
                            {{-- <p class="lead fw-normal"></p> --}}
                        </div>
                    </div>
                    <div class="col-md-2 d-flex justify-content-center">
                        <div>
                            <p class="small text-muted">Price</p>
                            <p class=" fw-normal">₹{{number_format($productDetails->product_price)}}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex justify-content-center">
                        <div>
                            <p class="small text-muted">Total</p>
                            @php
                            $orderTotal += $productDetails->product_price * $cartDetails->quantity;
                            @endphp
                            <p class="fw-normal">₹{{number_format($productDetails->product_price *
                                $cartDetails->quantity)}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <div class="container">
        <div class="card mb-5">
            <div class="card-body p-4">
                <div class="btns d-flex float-end" style="gap:20px">
                    @if($status != "accepted")
                    <div class="acceptBtn">
                        <a href="{{route('admin.accept_order',$order_id)}}" class="btn btn-primary">Accept Order</a>
                    </div>
                    @endif
                    @if($status != "rejected")
                    <div class="rejectBtn">
                        <a href="{{route('admin.reject_order',$order_id)}}" class="btn btn-danger">Reject Order</a>
                    </div>
                    @endif
                </div>
                <div class="float-start">
                    <p class="mb-0 me-5 d-flex align-items-center">
                        <span class="text-muted me-2">Order total:</span> <span
                            class="lead fw-normal">₹{{number_format($orderTotal)}}</span>
                    </p>
                </div>

            </div>
        </div>
    </div>
    <div class="container mb-5">

    </div>

    <script src="{{asset('js/user_product.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var update_cart = '{{route('admin.update_cart')}}';
        var csrf = '{{ csrf_token() }}';
        // alert(csrf);
    </script>
</body>

</html>