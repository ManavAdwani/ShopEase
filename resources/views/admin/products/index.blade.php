<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sainath mobiles - Admin</title>
    <link rel="stylesheet" href="{{asset('css/products.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
</head>

<body>
    @include('navbar')
    <div class="container">
        <div class="row">
            <div class="col-sm-4 mt-3">
                <div class="text-white card bg-gradient-info" id="cards">
                    <div class="card-body totalUsers">
                        <div style="float: left; height:50;">
                            <span class="material-symbols-outlined" style="font-size: 50px; margin-top:2px;">
                                work
                            </span>
                            <!-- <i class="fa fa-user fa-5x" aria-hidden="true"></i> -->
                        </div>
                        <div class="text-value-lg" style="font-size: 20px;">
                            {{$TotalProducts ?? 0}}
                        </div>
                        <h5>Total Products</h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mt-3">
                <div class="text-white card bg-gradient-info" id="cards">
                    <div class="card-body totalRestaurants">
                        <div style="float: left; height:50;">
                            <span class="material-symbols-outlined" style="font-size: 50px; margin-top:2px;">
                                store
                            </span>
                            <!-- <i class="fa fa-user fa-5x" aria-hidden="true"></i> -->
                        </div>
                        <div class="text-value-lg" style="font-size: 20px;">
                            {{$TotalCompanies ?? 0}}
                        </div>
                        <h5>Total Companies</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container table-responsive py-5">
        <div class="maintitle" style="display: flex; justify-content:space-between">
            <div class="usertitle">
                <h3>Products</h3>
            </div>
            <div class="addUser">
                <a href="{{route('admin.create_product')}}" class="btn btn-sm btn-primary">Add Product</a>
                <a href="{{route('admin.upload_products')}}" class="btn btn-sm btn-danger">Upload products csv</a>
            </div>
            
        </div>
        <br><br>
        @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
                @endforeach
            </ul>
        </div>
        @endif

        @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif
        <div class="container" style="display: flex; flex-wrap:wrap; justify-content:left; gap:20px;">
            @foreach ($products as $item)
            <div class="card mt-4" style="width: 18rem;">
            @if ($item->images)
                @php
                    // Split the comma-separated string into an array
                    $imagesArray = explode(',', $item->images);
                    // Get the first image path
                    $firstImage = $imagesArray;
                    // echo "<h3>{{$firstImage}}</h3>";
                    $cnt = 1;
                @endphp
                @foreach ($imagesArray as $img)
                @if ($cnt == 1)
                {{-- {{$img}} --}}
                <img src="{{ $img }}" alt="" style="width:auto;height:300px">
                @endif
               <p style="display: none">{{$cnt++}}</p> 
                @endforeach
            @else
                <img src="https://www.incathlab.com/images/products/default_product.png" alt="" style="width:auto;height:300px">
            @endif
            
                <div class="card-body">
                  <h5 class="card-title">{{$item->product_name}}</h5>
                  @php
                      $companydeets = DB::table('companies')->where('id','=',$item->company_id)->select('company_name')->first();
                      $company_name = $companydeets->company_name ?? 'N/A';
                  @endphp
                  <p class="card-text"><b>Company - {{$company_name}}</b></p>
                  <p class="card-text" style="font-size:20px;"><b>{{$item->product_price}}/-</b></p>
                  <div class="btns" style="display: flex; justify-content:space-between">
                    <div class="editBtn">
                        <a href="{{route('admin.edit_product',$item->id)}}" class="btn btn-primary" style="display: flex; align-item:center;gap:10px">
                            <span class="material-symbols-outlined" style="font-size: 18px;display:inline-flex;align-items:center;">
                                edit
                            </span> Edit
                        </a>
                    </div>
                    <div class="dltBtn">
                        <a href="{{route('admin.delete_product',$item->id)}}" class="btn btn-danger" style="display: flex; align-item:center;gap:10px">
                            <span class="material-symbols-outlined" style="font-size: 18px;display:inline-flex;align-items:center;">
                                Delete
                            </span> Delete
                        </a>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <script>
        new DataTable('#example');
    </script>
</body>

</html>