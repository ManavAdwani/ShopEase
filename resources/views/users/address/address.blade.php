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
    <script src="{{asset('js/address.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/address.css')}}">

</head>

<body>
    @include('usersNavBar');
    <div class="container">
        <div class="addresses" style="display: flex;flex-warp:wrap;gap:20px">
            @php
                $adCount = 0;
            @endphp
            @foreach ($user_address as $address)
            @php
                $adCount++;
            @endphp
            <div class="card" style="height: auto">
                <div class="title">
                    <h4 style="padding:10px">Address {{$adCount}}</h4>
                </div>
                <div class="body" style="padding:10px">
                    {{$address->address}} &nbsp; {{$address->city}} &nbsp; {{$address->state}} &nbsp; {{$address->zipcode}}
                </div>
                <div class="btn mb-4">
                    <a href="{{route('users.save_address_order',$address->id)}}" class="btn btn-warning" style="width: 100%">Use this</a>
                </div>
            </div>
            @endforeach
        </div>
        <br><br><br>
        <h1>Shipping</h1>
        <p>Please enter your shipping details.</p>
        <hr />
        <div class="form">
            <form action="{{route('users.store_address')}}" method="POST">
                @csrf
            <div class="fields fields">
                <label class="field">
                    <span class="field__label" for="firstname">Name</span>
                    <input class="field__input" type="text" id="firstname" placeholder="Enter Name" name="name" required />
                </label>
            </div>
            <label class="field">
                <span class="field__label" for="address">Address</span>
                <input class="field__input" type="text" id="address" placeholder="Address"  name="address" required />
            </label>
            <label class="field">
                <span class="field__label" for="address">Phone number</span>
                <input class="field__input" type="number" id="number" placeholder="Phone Number"  name="phone" maxlength="10" required />
            </label>
            <label class="field">
                <span class="field__label" for="country">Country</span>
                <select class="field__input" id="country" name="country" required>
                    <option value="">Select Country</option>
                    <option value="india" selected>India</option>
                </select>
            </label>
            <div class="fields fields--3">
                <label class="field">
                    <span class="field__label" for="zipcode">Zip code</span>
                    <input class="field__input" placeholder="Pin Code"  type="number" name="zipcode" id="pinCodeInputs" required/>
                </label>
                <label class="field">
                    <span class="field__label" for="city">City</span>
                    <input class="field__input" placeholder="City"  type="text" name="city" id="city" required/>
                </label>
                <label class="field">
                    <span class="field__label" for="state">State</span>
                    <input class="field__input" placeholder="State" type="text" name="state" id="state" required/>
                </label>
            </div>
            <button type="submit" class="button">Continue</button>
        </form>
        </div>
        <hr>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pinCodeInput = document.getElementById('pinCodeInput');
            const cityField = document.getElementById('city');
            const stateField = document.getElementById('state');
        
            pinCodeInput.addEventListener('blur', function() {
                const pinCode = pinCodeInput.value;
        
                fetch(`/get-city-state?pinCode=${pinCode}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.city && data.state) {
                            cityField.value = data.city;
                            stateField.value = data.state;
                        } else {
                            // alert('Invalid pin code');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching location data:', error);
                        // alert('Failed to fetch location data');
                    });
            });
        });
        </script>
        <script>
            document.getElementById('number').addEventListener('input', function () {
                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10);
                }
            });
            </script>
        
        {{-- <input type="text" id="pinCodeInput" placeholder="Enter pin code">
        <input type="text" id="city" placeholder="City" readonly>
        <input type="text" id="state" placeholder="State" readonly> --}}
        
</body>

</html>