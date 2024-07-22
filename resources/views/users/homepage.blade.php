<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Homepage</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/usersNav.css')}}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/a4c00a89bc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
</head>
<style>
    .scroll-container {
        display: flex;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        /* For smooth scrolling on iOS */
        scrollbar-width: none;
        /* Firefox */
    }

    .scroll-container::-webkit-scrollbar {
        display: none;
        /* Safari and Chrome */
    }

    .scroll-container .col-sm-3 {
        flex: 0 0 auto;
    }
</style>

<body>
    @include('usersNavBar');

    <div class="container">
        <img src="{{asset('herobanner/PRIME_SERIES_PC.jpg')}}" alt="Image de naruto usada de fondo"
            style="height: 100%; width:100%">
    </div>

    <div class="container">
        <div class="row mt-5">
            <div class="maintitle" style="display: flex; justify-content:space-between">
                <div class="usertitle">
                    <h1>Categories</h1>
                </div>
    
            </div>
            <div class="scroll-container" style="display: flex; overflow:scroll;">
            @foreach ($allCategories as $category)
                <div class="col-sm-2 text-center mt-4" style="padding:20px">
                    <a href="{{route('users.products',['cat_id'=>$category->id])}}" style="text-decoration: none;color:black">
                        <div class="category-item" >
                            <img src="{{ $category->logo ?? 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAMFBMVEXh6vH////5+vrl7fPv8/f0+fzt9Pbf6vD+/f/j6/Lf6vL///3f6fLr8fbv8/by9vm0HxD7AAACbUlEQVR4nO3c65abIBRAYVHTDALx/d+2VBuDII6zLHro2t/fmEn2HETn2jQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADkG29irNHa4I9G9+qu83B2BTauu01JIIYUUUkghhbcX/ipFTGH3LKOTUmi6Qq/QGQrLovA8Ckuj8LzqC/98A2ZX5YXd2Lajf6beOaTmwm5+tnnsBNZc+NTt/OaNanWT/U5hzYWjWjzyh1VSqK1ONpTPW/fyz66kcHCqixJtHwSqPvvUKgq1D/Rjik61MZzhWPd5aJ3fTfwR6yn+P4XzBFU8RevCwvzPJCoo9IFmepdmPUUdFuqaZzgt0fcUw8T+88Ar/wrSC/UywemgcKE+7Tg/ZNRY8V2bDScYT9G6r+mdu+fOK8guXE8wmaK/Vet6980PPmUXDvEEVXLRCL942lwGkguny0RSmF76//ILuh/SE1JyYXIObk/xzfn17NJH5BZ+LvSHpmjno10yRbmFySYTDHFjivONnZ9iHC+3MLNE31NcJy7zNsn9m9DC9DIRTXG9UD977jTF1UIVWpjbZDJTDM/YeLsRWfjdBKMprj8d8RRFFm5d6Dca31OM99z1diOwMHehT01TTBe0WV00BBYem+AyRbdxcDhFgYX6YN80RZu5LTCSZ9gcLzSqz+xIZvloAgt/MsN8u+QZUkghhRRSSCGFFFJIIYWXFKqv85Towr3fcDpKSy78xygsjcLzKCyNwvPEFCpthxKsVlIKXVeGE1NYHoUUUkghhRRSeFfh2D6u0o53BOpmuOz/RA17f8MHAAAAAAAAAAAAAAAAAAAAAAAAAAAAALjcb3yLQG5tF3tgAAAAAElFTkSuQmCC' }}" alt="{{ $category->category_name }}" class="rounded-circle" width="100" height="100">
                            <p>{{ $category->category_name }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="maintitle" style="display: flex; justify-content:space-between">
            <div class="usertitle">
                <h1>New Launch</h1>
            </div>
            <div class="addUser">
                <a href="{{route('users.products')}}" class="btn btn-primary">See all</a>
            </div>

        </div>
        <div class="row mb-5">
            <div class="scroll-container" style="display: flex; overflow:scroll;">
                @foreach ($newLaunched as $product)
                <div class="col-sm-3 mt-3" style="padding:20px;">
                    <div class="card" style="width: 15rem; box-shadow: 10px 10px;">
                        @php
                        $images = explode(',',$product->images);
                        // print_r($images);
                        $firstImage = $images[0];
                        @endphp
                        <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
                            @if($firstImage)
                            <img src="{{ asset($firstImage) }}" class="card-img-top" alt="..."
                                style="width: 200px; height: 200px;">
                            @else
                            <img src="https://www.incathlab.com/images/products/default_product.png"
                                class="card-img-top" alt="..." style="width: 200px; height: 200px;">
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
                            <p class="card-text" style="margin-bottom:10px"><b>Category</b> - {{$category_name}}</p>
                            --}}
                            @php
                            $getCompanyName =
                            DB::table('companies')->where('id',$product->company_id)->select()->first();
                            $company_name = $getCompanyName->company_name ?? 'N/A';
                            @endphp
                            <p class="card-text mt-2" style="margin-bottom:10px;color:gray;font-size:17px">
                                {{$company_name}}
                            </p>
                            @if(auth()->user()->role != 3)
                        <p class="card-text" @if ($product->quantity == 0)
                            style="color:red"
                        @endif><b>Quantity - {{$product->quantity}}</b></p>
                        @endif
                            <h5 class="card-text mt-4">₹{{$product->product_price}}</h5>
                            <div class="allBtns" style="display: flex; flex-wrap:wrap">
                                <div>
                                    <a id="addToCart{{$product->id}}" onclick="addToCart({{$product->id}})"
                                        title="Add to cart" class="btn btn-sm btn-link" style="margin-top: 09px;">
                                        <span class="material-symbols-outlined">
                                            shopping_cart
                                        </span>
                                    </a>
                                    <input type="text" class="form-control" name="" placeholder="Enter Quantity"
                                        id="pro_quan{{$product->id}}" style="display: none;width:100%">
                                    <div class="btns"
                                        style="display: flex;flex-wrap:wrap;justify-content:space-between">
                                        <div>
                                            <button onclick="addToCartButton({{$product->id}})"
                                                style="display: none;width:100%" title="Add to cart"
                                                class="btn btn-sm btn-primary" id="addBtn{{$product->id}}"><i
                                                    class='fas fa-plus'></i></button>
                                        </div>
                                        <div>
                                            <button onclick="cancelCartButton({{$product->id}})"
                                                style="display: none;width:100%" title="Cancel"
                                                class="btn btn-sm btn-danger" id="cancelBtn{{$product->id}}"><i
                                                    class='fas fa-times'></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    @php
                                    $getFav =
                                    DB::table('favourites')->where('product_id',$product->id)->select()->first();
                                    $FavList = $getFav->user_id ?? '';
                                    $FavArray = explode(',', $FavList); // Convert comma-separated list to array
                                    $userId = auth()->user()->id;
                                    @endphp
                                    <a onclick="addFavoriteProduct({{$product->id}})" title="View"
                                        class="btn btn-sm btn-link mt-1">
                                        <i class='fas fa-heart mt-2' style='font-size:23px;color:red;display:none'
                                            id="filled_heart_{{$product->id}}"></i>
                                        @if(in_array($userId, $FavArray))
                                        <i class='fas fa-heart mt-1' style='font-size:25px;color:red'></i>
                                        @else
                                        <span id="unFilled_heart_{{$product->id}}" class="material-symbols-outlined"
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
            </div>
            <input type="hidden" id="cart_product">
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset('js/user_product.js')}}"></script>
     <script>
        var fav_pro_route = '{{route('users.fav_pro')}}';
        var csrf = '{{ csrf_token() }}';
        var addToCart_route = '{{route('users.add_to_cart')}}';
        // alert(csrf);
    </script>
</body>

</html>