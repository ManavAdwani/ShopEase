<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/a4c00a89bc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <script src="{{asset('js/user_cart.js')}}"></script>

</head>

<body>
    @include('usersNavBar');
    <div class="container">
        <section class="mb-5">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col">
                        <p><span class="h2">Shopping Cart </span><span class="h4">({{$cartProducts->count()}} item in
                                your cart)</span></p>
                        @php
                        $orderTotal = 0;
                        @endphp
                        <div class="card mb-4">
                            @foreach ($cartProducts as $cartProduct)
                            <div class="card-body p-4">

                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        @if(!empty($cartProduct->images))
                                        @php
                                        $images = explode(',', $cartProduct->images);
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
                                            <p class="lead fw-normal">{{$cartProduct->product_name}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center">
                                        <div>
                                            <p class="small text-muted">Company</p>
                                            @php
                                            $companies =
                                            DB::table('companies')->where('id',$cartProduct->company_id)->select()->first();
                                            $company_name = $companies->company_name;
                                            @endphp
                                            <p class="lead fw-normal">{{$company_name}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center">
                                        <div>
                                            <p class="small text-muted">Quantity</p>
                                            <input type="text" class="form-control" name=""
                                                onchange="changeCartValue({{$cartProduct->id}})"
                                                value="{{$cartProduct->quantity}}" id="cartQuan{{$cartProduct->id}}"
                                                style="width: 60px">
                                            {{-- <p class="lead fw-normal"></p> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center">
                                        <div>
                                            <p class="small text-muted">Price</p>
                                            <p class="lead fw-normal">₹{{number_format($cartProduct->product_price)}}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center">
                                        <div>
                                            <p class="small text-muted">Total</p>
                                            @php
                                            $orderTotal += $cartProduct->product_price * $cartProduct->quantity;
                                            @endphp
                                            <p class="lead fw-normal">₹{{number_format($cartProduct->product_price *
                                                $cartProduct->quantity)}}</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @endforeach
                        </div>

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

                        <div class="d-flex justify-content-end">
                            <a href="{{route('users.products')}}" type="button" data-mdb-button-init
                                data-mdb-ripple-init class="btn btn-sm btn-danger btn-lg me-2">Back to products</a>
                            <a href="{{route('users.address')}}" type="button" data-mdb-button-init data-mdb-ripple-init
                                class="btn btn-sm btn-primary btn-lg" @if ($cartProducts->isEmpty())
                                style="display:none;" @endif>Order now</a>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="{{asset('js/user_product.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var update_cart = '{{route('users.update_cart')}}';
        var csrf = '{{ csrf_token() }}';
        // alert(csrf);
    </script>
</body>

</html>