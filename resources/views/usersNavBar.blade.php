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
    @php
    $navbardetails = DB::table('admin_nav_bar')->select()->first();
    $website_name = $navbardetails->name ?? 'ShopEase';
    $website_logo = $navbardetails ? $navbardetails->logo : '';
@endphp
        <div class="container-fluid">
        <?php if ($website_logo): ?>
        <img src="{{ asset("storage/".$navbardetails->logo) }}" alt="Logo" class="nav_logo-icon" style="height: 50px; width: auto;">
    <?php else: ?>
        <i class='bx bx-layer nav_logo-icon'></i>
    <?php endif; ?>
            <a class="navbar-brand" href="#">{{$website_name}}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="gap:10px;">
                    <li class="nav-item">
                        <a class="nav-link active d-flex align-items-center" aria-current="page" href="{{route('users.homepage')}}">
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
                            $cartCount = DB::table('carts')->where('user_id',auth()->user()->id ?? 0)->where('status','pending')->count();
                            @endphp
                            @if($cartCount == 0)
                            Cart
                            @else
                            Cart &nbsp;<span class="badge bg-danger">{{$cartCount}}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active d-flex align-items-center" aria-current="page" href="{{route('users.fav_product_page')}}">
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
                    <li class="nav-item">
                        <a onclick="event.preventDefault(); document.getElementById('frm-logout').submit();" class="nav-link active d-flex align-items-center" aria-current="page" href="{{route('users.logout')}}">
                            <span class="material-symbols-outlined me-2">
                                logout
                            </span>
                            Logout
                        </a>
                        <form id="frm-logout" action="{{ route('users.logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
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