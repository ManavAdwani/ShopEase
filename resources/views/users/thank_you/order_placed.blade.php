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
    <link rel="stylesheet" href="{{asset('css/thank_you.css')}}">

</head>

<body>
    @include('usersNavBar');
    <div class="container mt-5 d-flex justify-content-center">
        <div class="card p-4 mt-3">
           <div class="first d-flex justify-content-between align-items-center mb-3">
             <div class="info">
                 <span class="d-block name">Thank you, {{auth()->user()->name}}</span>
                 <span class="order">Order - 4554645</span>
             </div>
              <img src="https://i.imgur.com/NiAVkEw.png" width="40"/>
           </div>
               <div class="detail">
           <span class="d-block summery">Your order has been dispatched. we are delivering you order.</span>
               </div>
           <hr>
           <div class="text">
         <span class="d-block new mb-1" >{{auth()->user()->name}}</span>
          </div>
          @php
              $getAddress = DB::table('user_address')->where('id',$storeOrder)->select('address','zipcode','city','state')->first();
          @endphp
         <span class="d-block address mb-3">{{$getAddress->address}} &nbsp; {{$getAddress->city}} &nbsp; {{$getAddress->state}} &nbsp; {{$getAddress->zipcode}}</span>
           <div class="  money d-flex flex-row mt-2 align-items-center">
             <img src="https://i.imgur.com/ppwgjMU.png" width="20" />
         
             <span class="ml-2">Cash on Delivery</span> 
 
                </div>
         </div>
     </div>

    <script src="{{asset('js/user_product.js')}}"></script>
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