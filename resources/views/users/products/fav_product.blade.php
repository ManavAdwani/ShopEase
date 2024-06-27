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

</head>

<body>
    @include('usersNavBar');

    <div class="container mt-5">
        <h4 class="mb-5">Favorite Products</h4>
        <div class="row mb-5">
            @if ($products->isEmpty())
            <center>
                <div class="alert alert-info" role="alert">
                    <h4 class="alert-heading">No Favorites</h4>
                    <p>You have no products in your favorites list.</p>
                    <hr>
                    <a href="{{ route('users.products') }}" class="btn btn-primary">Browse Products</a>
                  </div>
            </center>
            @else
            @foreach ($products as $product)
            <div class="col-sm-3 mt-3 d-flex justify-content-center">
                <div class="card" style="width: 15rem; box-shadow: 10px 10px;">
                    @php
                    $images = explode(',',$product->images);
                    // print_r($images);
                    $firstImage = $images[0];
                    @endphp
                    <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
                        @if($firstImage)
                        <img src="{{ asset("Laravel/public/".$firstImage) }}" class="card-img-top" alt="..."
                            style="width: 200px; height: 200px;">
                        @else
                        <img src="https://www.incathlab.com/images/products/default_product.png" class="card-img-top"
                            alt="..." style="width: 200px; height: 200px;">
                        @endif
                    </div>
                    <div class="card-body">
                        <p class="card-title"
                            style="font-size: 20px; max-width: 200px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                            {{$product->product_name}}
                        </p>
                        {{-- @php
                        $getCategoryName =
                        DB::table('categories')->where('id',$product->category_id)->select()->first();
                        $category_name = $getCategoryName->category_name ?? 'N/A';
                        @endphp
                        <p class="card-text" style="margin-bottom:10px"><b>Category</b> - {{$category_name}}</p> --}}
                        @php
                        $getCompanyName = DB::table('companies')->where('id',$product->company_id)->select()->first();
                        $company_name = $getCompanyName->company_name ?? 'N/A';
                        @endphp
                        <p class="card-text mt-2" style="margin-bottom:10px;color:gray;font-size:17px">{{$company_name}}
                        </p>
                        <h5 class="card-text mt-4">₹{{$product->product_price}}</h5>
                        <div class="allBtns" style="display: flex; flex-wrap:wrap">
                            <div>
                                <a id="addToCart{{$product->pid}}" onclick="addToCart({{$product->pid}})"
                                    title="Add to cart" class="btn btn-sm btn-link" style="margin-top: 09px;">
                                    <span class="material-symbols-outlined">
                                        shopping_cart
                                    </span>
                                </a>
                                <input type="text" class="form-control" name="" placeholder="Enter Quantity"
                                    id="pro_quan{{$product->pid}}" style="display: none;width:100%">
                                <div class="btns" style="display: flex;flex-wrap:wrap;justify-content:space-between">
                                    <div>
                                        <button onclick="addToCartButton({{$product->pid}})"
                                            style="display: none;width:100%" title="Add to cart"
                                            class="btn btn-sm btn-primary" id="addBtn{{$product->pid}}"><i
                                                class='fas fa-plus'></i></button>
                                    </div>
                                    <div>
                                        <button onclick="cancelCartButton({{$product->pid}})"
                                            style="display: none;width:100%" title="Cancel"
                                            class="btn btn-sm btn-danger" id="cancelBtn{{$product->pid}}"><i
                                                class='fas fa-times'></i></button>
                                    </div>
                                </div>
                            </div>
                            <div>
                                @php
                                $getFav = DB::table('favourites')->where('product_id',$product->pid)->select()->first();
                                
                                $FavList = $getFav->user_id ?? '';
                                $FavArray = explode(',', $FavList); // Convert comma-separated list to array
                                $userId = auth()->user()->id;
                                @endphp
                                <a onclick="addFavoriteProduct({{$product->pid}})" title="View"
                                    class="btn btn-sm btn-link mt-1">
                                    <i class='fas fa-heart mt-2' style='font-size:23px;color:red;display:none'
                                        id="filled_heart_{{$product->pid}}"></i>
                                    @if(in_array($userId, $FavArray))
                                    <i class='fas fa-heart mt-1' style='font-size:25px;color:red'></i>
                                    @else
                                    <span id="unFilled_heart_{{$product->pid}}" class="material-symbols-outlined"
                                        style="margin-top:5px;color:red">
                                        favorite
                                    </span>
                                    @endif
                                </a>
                                <input type="hidden" id="user_id" value="{{auth()->user()->id}}">
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            @endif
           
            <input type="hidden" id="cart_product">
        </div>
        {{ $products->links() }}

    </div>



    <script src="{{asset('js/fav_page.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var fav_pro_route = '{{route('users.fav_pro')}}';
        var csrf = '{{ csrf_token() }}';
        var addToCart_route = '{{route('users.add_to_cart')}}';
        // alert(csrf);
    </script>
</body>

</html>