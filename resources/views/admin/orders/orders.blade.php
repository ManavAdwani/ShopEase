<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sainath mobiles - Admin</title>
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    @include('navbar')
    <div class="container table-responsive py-5">
        <div class="maintitle" style="display: flex; justify-content:space-between">
            <div class="usertitle">
                <h3>Orders</h3>
            </div>
        </div>
        <br><br>
        @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
                @endforeach
            </ul>
        </div>
        @endif

        @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Total Amt</th>
                    <th>Status</th>
                    <th>Ordered by</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                $orderCnt = 0;
                @endphp
                @foreach ($orders as $order)
                @php
                $orderCnt++;
                @endphp
                <tr>
                    <td>{{$orderCnt}}</td>
                    @php
                    $cartIds = explode(',', $order->cart_ids); // Convert comma-separated string to an array
                    $cart = DB::table('carts')->whereIn('id', $cartIds)->select()->get();
                    @endphp
                    <td>
                        <ol>
                            @php
                            $totalAmt = 0;
                            @endphp
                            @foreach ($cart as $cartOrder)
                            @php
                            $product = DB::table('products')->where('id', $cartOrder->product_id)->select()->first();
                            @endphp
                            <li>{{$product->product_name}} (Quantity - {{$cartOrder->quantity}})</li>
                            @php
                            $totalAmt += $product->product_price * $cartOrder->quantity;
                            @endphp
                            @endforeach
                        </ol>
                    </td>
                    <td>
                        ₹ {{number_format($totalAmt)}}
                    </td>
                    <td>
                        @if($order->status == "pending")
                        <i class="fa fa-circle me-2" style="color: rgb(234, 215, 10);"></i>Pending
                        @endif
                        @if($order->status == "accepted")
                        <i class="fa fa-circle me-2" style="color: rgb(81, 234, 10);"></i>Accepted
                        @endif
                        @if($order->status == "rejected")
                        <i class="fa fa-circle me-2" style="color: rgb(234, 10, 10);"></i>Rejected
                        @endif
                    </td>
                    <td>
                        @php
                        $userDetails = DB::table('users')->where('id',$order->user_id)->select('name')->first();
                        $username =$userDetails->name ?? '';
                        @endphp
                        {{$username}}
                    </td>
                    <td>
                        <button title="View Order" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                            data-bs-target="#viewModal-{{$order->id}}"><i class="fa fa-eye"
                                style="color: rgb(0, 0, 0);"></i></button>&nbsp;
                        <a href="{{route('admin.edit_order',$order->id)}}" title="Edit Order"
                            class="btn btn-sm btn-primary"><i class="fa fa-edit"
                                style="color: rgb(255, 255, 255);"></i></a>&nbsp;
                        @if($order->status != "accepted")
                        <a href="{{route('admin.accept_order',$order->id)}}" title="Accept Order"
                            class="btn btn-sm btn-success"><i class="fa fa-check"
                                style="color: rgb(255, 255, 255);"></i></a>&nbsp;
                        @endif
                        @if($order->status != "rejected")
                        <a href="{{route('admin.reject_order',$order->id)}}" title="Reject Order"
                            class="btn btn-sm btn-danger"><i class="fa fa-times"
                                style="color: rgb(255, 255, 255);"></i></a>
                        @endif
                    </td>

                </tr>
                <!-- Modal -->
                <div class="modal fade" id="viewModal-{{$order->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Order number {{$order->id}}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @php
                                $cartIds = explode(',',$order->cart_ids);
                                $orderTotal = 0;
                                @endphp
                                @foreach ($cartIds as $cartId)
                                @php
                                $cartDetails = DB::table('carts')->where('id', $cartId)->select()->first();
                                @endphp
                                @if ($cartDetails)
                                <div class="container">
                                    <div class="card mb-4">
                                        <div class="card-body p-4">
                                            <div class="row align-items-center">
                                                <div class="col-md-2">
                                                    @php
                                                    $productDetails = DB::table('products')->where('id',
                                                    $cartDetails->product_id)->select()->first();
                                                    @endphp
                                                    @if (!empty($productDetails->images))
                                                        @php
                                                        $images = explode(',', $productDetails->images);
                                                        $firstImage = $images[0];
                                                        @endphp
                                                        <img src="{{ $firstImage }}" class="img-fluid" alt="Product Image">
                                                    @else
                                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAMFBMVEXh6vH////5+vrl7fPv8/f0+fzt9Pbf6vD+/f/j6/Lf6vL///3f6fLr8fbv8/by9vm0HxD7AAACbUlEQVR4nO3c65abIBRAYVHTDALx/d+2VBuDII6zLHro2t/fmEn2HETn2jQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADkG29irNHa4I9G9+qu83B2BTauu01JIIYUUUkghhbcX/ipFTGH3LKOTUmi6Qq/QGQrLovA8Ckuj8LzqC/98A2ZX5YXd2Lajf6beOaTmwm5+tnnsBNZc+NTt/OaNanWT/U5hzYWjWjzyh1VSqK1ONpTPW/fyz66kcHCqixJtHwSqPvvUKgq1D/Rjik61MZzhWPd5aJ3fTfwR6yn+P4XzBFU8RevCwvzPJCoo9IFmepdmPUUdFuqaZzgt0fcUw8T+88Ar/wrSC/UywemgcKE+7Tg/ZNRY8V2bDScYT9G6r+mdu+fOK8guXE8wmaK/Vet6980PPmUXDvEEVXLRCL942lwGkguny0RSmF76//ILuh/SE1JyYXIObk/xzfn17NJH5BZ+LvSHpmjno10yRbmFySYTDHFjivONnZ9iHC+3MLNE31NcJy7zNsn9m9DC9DIRTXG9UD977jTF1UIVWpjbZDJTDM/YeLsRWfjdBKMprj8d8RRFFm5d6Dca31OM99z1diOwMHehT01TTBe0WV00BBYem+AyRbdxcDhFgYX6YN80RZu5LTCSZ9gcLzSqz+xIZvloAgt/MsN8u+QZUkghhRRSSCGFFFJIIYWXFKqv85Towr3fcDpKSy78xygsjcLzKCyNwvPEFCpthxKsVlIKXVeGE1NYHoUUUkghhRRSeFfh2D6u0o53BOpmuOz/RA17f8MHAAAAAAAAAAAAAAAAAAAAAAAAAAAAALjcb3yLQG5tF3tgAAAAAElFTkSuQmCC"
                                                        class="img-fluid" alt="Generic placeholder image">

                                                    @endif
                                                </div>
                                                <div class="col-md-2 d-flex justify-content-center">
                                                    <div>
                                                        <p class="small text-muted">Name</p>
                                                        <p class="fw-normal">{{ $productDetails->product_name ?? 'N/A'
                                                            }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 d-flex justify-content-center">
                                                    <div>
                                                        <p class="small text-muted">Company</p>
                                                        @php
                                                        $companies = DB::table('companies')->where('id',
                                                        $productDetails->company_id)->select()->first();
                                                        $company_name = $companies->company_name ?? 'N/A';
                                                        @endphp
                                                        <p class="fw-normal">{{ $company_name }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 d-flex justify-content-center">
                                                    <div>
                                                        <p class="small text-muted">Quantity</p>
                                                        <input type="text" class="form-control" name=""
                                                            onchange="changeCartValue({{ $cartDetails->id }})"
                                                            value="{{ $cartDetails->updated_quantity ?? $cartDetails->quantity }}"
                                                            id="cartQuan{{ $cartDetails->id }}" style="width: 60px"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 d-flex justify-content-center">
                                                    <div>
                                                        <p class="small text-muted">Price</p>
                                                        <p class="fw-normal">₹{{
                                                            number_format($productDetails->product_price ?? 0) }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 d-flex justify-content-center">
                                                    <div>
                                                        <p class="small text-muted">Total</p>
                                                        @php
                                                        $orderTotal += ($productDetails->product_price ?? 0) *
                                                        $cartDetails->quantity;
                                                        @endphp
                                                        <p class="fw-normal">₹{{
                                                            number_format(($productDetails->product_price ?? 0) *
                                                            $cartDetails->quantity) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach

                                <div class="container">
                                    <div class="card mb-5">
                                        <div class="card-body p-4">
                                            <div class="float-end">
                                                <p class="mb-0 me-5 d-flex align-items-center">
                                                    <span class="text-muted me-2">Order total:</span> <span
                                                        class="lead fw-normal">₹{{number_format($orderTotal)}}</span>
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>

        </table>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <script>
        new DataTable('#example');
    </script>
</body>

</html>