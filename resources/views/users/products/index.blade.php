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
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

</head>

<body>
    @include('usersNavBar');
    <div class="container">
        <form action="{{route('users.products')}}" method="GET">
            <div class="row">
                <div class="col-sm-4 mt-2">
                    <select class="form-select" name="category" aria-label="Default select example">
                        <option value="" selected>Select category</option>
                        @foreach ($categories as $cat)
                        <option value="{{$cat->id}}" @if ($selectedcat==$cat->id)
                            selected
                            @endif>{{$cat->category_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4 mt-2">
                    <select name="company" class="form-select" aria-label="Default select example">
                        <option value="" selected>Select company</option>
                        @foreach ($companies as $cam)
                        <option value="{{$cam->id}}" @if($selectedcom==$cam->id)
                            selected
                            @endif>{{$cam->company_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4 mt-2">
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
            <div class="col-sm-3 mt-3 d-flex justify-content-center">
                <div class="card" style="width: 15rem; box-shadow: 10px 10px;">
                    @php
                        $images = explode(',', $product->images);
                        $firstImage = $images[0] ?? null;
                    @endphp
                    <div onclick="getProductData({{$product->id}})" style="display: flex; justify-content: center; align-items: center; height: 100%; cursor: pointer;">
                        <img src="{{ $firstImage ? asset($firstImage) : 'https://www.incathlab.com/images/products/default_product.png' }}" class="card-img-top" alt="Product Image" style="width: 100%; height: 100%;">
                    </div>
                    <div class="card-body">
                        <p style="font-weight: 900">{{$product->model_number}}</p>
                        <p class="card-title" style="font-size: 20px; max-width: 200px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                            {{$product->product_name}}
                        </p>
                        @php
                            $getCompanyName = DB::table('companies')->where('id', $product->company_id)->first();
                            $company_name = $getCompanyName->company_name ?? 'N/A';
                        @endphp
                        <p class="card-text mt-2" style="margin-bottom:10px; color:gray; font-size:17px;">{{$company_name}}</p>
                        @if(auth()->user()->role != 3)
                        <p class="card-text" style="{{ $product->quantity == 0 ? 'color:red' : '' }}">
                            <b>Quantity - {{$product->quantity}}</b>
                        </p>
                        @endif
                        <h5 class="card-text mt-4">₹{{$product->product_price}}</h5>
                        <div class="allBtns" style="display: flex; flex-wrap: wrap;">
                            <div>
                                <a id="addToCart{{$product->id}}" onclick="addToCart({{$product->id}})" title="Add to cart" class="btn btn-sm btn-link" style="margin-top: 9px;">
                                    <span class="material-symbols-outlined">shopping_cart</span>
                                </a>
                                <input type="text" class="form-control" placeholder="Enter Quantity" id="pro_quan{{$product->id}}" style="display: none; width: 100%;">
                                <div class="btns" style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                                    <div>
                                        <button onclick="addToCartButton({{$product->id}})" style="display: none; width: 100%;" title="Add to cart" class="btn btn-sm btn-primary" id="addBtn{{$product->id}}">
                                            <i class='fas fa-plus'></i>
                                        </button>
                                    </div>
                                    <div>
                                        <button onclick="cancelCartButton({{$product->id}})" style="display: none; width: 100%;" title="Cancel" class="btn btn-sm btn-danger" id="cancelBtn{{$product->id}}">
                                            <i class='fas fa-times'></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div>
                                @php
                                    $getFav = DB::table('favourites')->where('product_id', $product->id)->first();
                                    $FavList = $getFav->user_id ?? '';
                                    $FavArray = explode(',', $FavList);
                                    $userId = auth()->user()->id;
                                @endphp
                                <a onclick="addFavoriteProduct({{$product->id}})" title="View" class="btn btn-sm btn-link mt-1">
                                    <i class='fas fa-heart mt-2' style='font-size: 23px; color: red; display: none' id="filled_heart_{{$product->id}}"></i>
                                    @if(in_array($userId, $FavArray))
                                    <i class='fas fa-heart mt-1' style='font-size: 25px; color: red;'></i>
                                    @else
                                    <span id="unFilled_heart_{{$product->id}}" class="material-symbols-outlined" style="margin-top: 5px; color: red;">favorite</span>
                                    @endif
                                </a>
                                <input type="hidden" id="user_id" value="{{auth()->user()->id}}">
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Modal -->
            @endforeach
            <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="swiper modalCarousel">
                                    <div class="swiper-wrapper"></div>
                                    <!-- Add Pagination -->
                                    <div class="swiper-pagination"></div>
                                    <!-- Add Navigation -->
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            
    
            <input type="hidden" id="cart_product">
        </div>
        {{ $products->links() }}
    </div>
    

    <!-- Modal -->
    



    <script src="{{asset('js/user_product.js')}}"></script>
    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <script>
        var fav_pro_route = '{{route('users.fav_pro')}}';
        var csrf = '{{ csrf_token() }}';
        var addToCart_route = '{{route('users.add_to_cart')}}';
        var ProductData = '{{route('users.productData')}}';
        // alert(csrf);
    </script>
</body>

</html>