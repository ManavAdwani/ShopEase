<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sainath Mobiles</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="gap:10px;">
                    <li class="nav-item">
                        <a class="nav-link active d-flex align-items-center" aria-current="page" href="#">
                            <span class="material-symbols-outlined me-2">
                                home
                            </span>
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active d-flex align-items-center" aria-current="page"
                            href="{{route('users.products')}}">
                            <span class="material-symbols-outlined me-2">
                                phone_iphone
                            </span>
                            Products
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active d-flex align-items-center" aria-current="page" href="{{route('users.cart')}}">
                            <span class="material-symbols-outlined me-2">
                                shopping_cart
                            </span>
                            @php
                            $cartCount = DB::table('carts')->where('user_id',auth()->user()->id)->where('status','pending')->count();
                            @endphp
                            @if($cartCount == 0)
                            Cart
                            @else
                            Cart &nbsp;<span class="badge bg-danger">{{$cartCount}}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active d-flex align-items-center" aria-current="page" href="#">
                            <span class="material-symbols-outlined me-2">
                                favorite
                            </span>
                            favorite
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active d-flex align-items-center" aria-current="page" href="#">
                            <span class="material-symbols-outlined me-2">
                                person
                            </span>
                            Profile
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>