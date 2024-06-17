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
    {{--
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    @include('navbar')
    <div class="container">
        <h3>
            Hello {{auth()->user()->name}}
        </h3>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-4 mt-3">
                <div class="text-white card bg-gradient-info" id="cards">
                    <div class="card-body totalUsers">
                        <div style="float: left; height:50;">
                            <span class="material-symbols-outlined" style="font-size: 50px; margin-top:2px;">
                                group
                            </span>
                            <!-- <i class="fa fa-user fa-5x" aria-hidden="true"></i> -->
                        </div>
                        <div class="text-value-lg" style="font-size: 20px;">
                            {{$totalUsers ?? 0}}
                        </div>
                        <h5>Total Users</h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mt-3">
                <div class="text-white card bg-gradient-info" id="cards">
                    <div class="card-body totalRestaurants">
                        <div style="float: left; height:50;">
                            <span class="material-symbols-outlined" style="font-size: 50px; margin-top:2px;">
                                shopping_cart
                            </span>
                            <!-- <i class="fa fa-user fa-5x" aria-hidden="true"></i> -->
                        </div>
                        <div class="text-value-lg" style="font-size: 20px;">
                            {{$totalOrders ?? 0}}
                        </div>
                        <h5>Total Orders</h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mt-3">
                <div class="text-white card bg-gradient-info" id="cards">
                    <div class="card-body totalEarnings">
                        <div style="float: left; height:50;">
                            <span class="material-symbols-outlined" style="font-size: 50px; margin-top:2px;">
                                manage_accounts
                            </span>
                            <!-- <i class="fa fa-user fa-5x" aria-hidden="true"></i> -->
                        </div>
                        <div class="text-value-lg" style="font-size: 20px;">
                            {{$totalSalesman ?? 0}}
                        </div>
                        <h5>Total Salesman</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container m-5">
        <div
            style="width: 100%; margin: auto;margin-bottom:100px;box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;position: relative;">
            <canvas id="monthlyOrderData"></canvas>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var ctx = document.getElementById('monthlyOrderData').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($OrderschartData['labels']),
            datasets: [{
                label: 'Orders',
                data: @json($OrderschartData['data']),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: true,
            plugins: {
            title: {
                display: true,
                text: 'Monthly Orders',
            },
            
        }
        }
    });
    
    </script>
</body>

</html>