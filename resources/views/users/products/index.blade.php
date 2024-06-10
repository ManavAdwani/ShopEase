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
</head>

<body>
    @include('usersNavBar');
    <div class="container">
        <form action="{{route('users.products')}}" method="GET">
            <div class="row">
                <div class="col-sm-4">
                    <select class="form-select" name="category" aria-label="Default select example">
                        <option value="" selected>Select category</option>
                        @foreach ($categories as $cat)
                        <option value="{{$cat->id}}" @if ($selectedcat == $cat->id)
                            selected
                        @endif>{{$cat->category_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4">
                    <select name="company" class="form-select" aria-label="Default select example">
                        <option value="" selected>Select company</option>
                        @foreach ($companies as $cam)
                        <option value="{{$cam->id}}" @if($selectedcom == $cam->id)
                            selected
                        @endif>{{$cam->company_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4">
                    <input class="form-control" type="text" value="{{$searched}}" name="search" id="search"
                        placeholder="Search by product name">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-4">
                    <button class="btn btn-sm btn-primary">Search</button>
                </div>
            </div>
        </form>
    </div>

    <div class="container mt-5">
        <h4 class="mb-5">Products</h4>
        <div class="row mb-5">
            @foreach ($products as $product)
            <div class="col-sm-3">
                <div class="card" style="width: 15rem; box-shadow: 10px 10px;">
                    @php
                    $images = explode(',',$product->images);
                    // print_r($images);
                    $firstImage = $images[0];
                    @endphp
                    <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
                        <img src="{{ asset($firstImage) }}" class="card-img-top" alt="..."
                            style="width: 200px; height: 200px;">
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
                        <p class="card-text mt-2" style="margin-bottom:10px;color:gray;font-size:17px"">{{$company_name}}</p>
                        <h5 class=" card-text mt-4"> ₹{{$product->product_price}}</h5>
                            <a href="#" title="Add to cart" class="btn btn-sm btn-link mt-2">
                                <span class="material-symbols-outlined" style="margin-top:5px">
                                    shopping_cart
                                </span>
                            </a>
                            @php
                            $getFav = DB::table('favourites')->where('product_id',$product->id)->select()->first();
                            $FavList = $getFav->user_id ?? '';
                            $FavArray = explode(',', $FavList); // Convert comma-separated list to array
                            $userId = auth()->user()->id;
                            @endphp
                            <a onclick="addFavoriteProduct({{$product->id}})" title="View"
                                class="btn btn-sm btn-link mt-2">
                                <i class='fas fa-heart' style='font-size:25px;color:red;display:none'
                                    id="filled_heart_{{$product->id}}"></i>
                                @if(in_array($userId, $FavArray))
                                <i class='fas fa-heart' style='font-size:25px;color:red'></i>
                                @else
                                <span id="unFilled_heart_{{$product->id}}" class="material-symbols-outlined" style="margin-top:5px;color:red">
                                    favorite
                                </span>
                                @endif
                            </a>
                            <input type="hidden" id="user_id" value="{{auth()->user()->id}}">
                            <input type="hidden" id="product_id" value="{{$product->id}}">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{ $products->links() }}

    </div>



    <script src="{{asset('js/user_product.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        var fav_pro_route = '{{route('users.fav_pro')}}';
        var csrf = '{{ csrf_token() }}';
        // alert(csrf);
    </script>
</body>

</html>