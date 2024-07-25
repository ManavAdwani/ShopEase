<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sainath mobiles - Admin</title>
    <link rel="stylesheet" href="{{asset('css/banners.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    {{--
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
</head>

<body>
    @include('navbar')
    <div class="container table-responsive py-5">
        <div class="maintitle" style="display: flex; justify-content:space-between">
            <div class="usertitle">
                <h3>User banners</h3>
            </div>
            <div class="addUser">
                <a href="{{route('admin.create_user_banner')}}" class="btn btn-sm btn-primary">Add Banner</a>
            </div>
        </div>
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
    </div>
    <div class="container" style="display: flex; flex-wrap:wrap; justify-content:space-around;">
        @foreach ($banners as $banner)
        <div class="card mt-5" style="width: 20rem;">
            <img src="{{asset('storage/'.$banner->banner)}}" class="card-img-top" alt="..." width="250px"
                height="200px">
            <div class="card-body">
                <div class="status-container"
                    style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        @if($banner->status == 1)
                        <span class="badge bg-success">Active</span>
                        @else
                        <span class="badge bg-danger">Inactive</span>
                        @endif
                    </div>
                    <span>{{ $banner->created_at->format('d F y') }}</span>
                </div>
                <br><br>
                <div class="changeStatusBtn"
                    style="display: flex; justify-content: space-between; align-items: center;">
                    <a href="{{route('admin.change_banner_status',$banner->id)}}" style="width: 100%" class="btn btn-sm btn-primary"> Change Status</a>
                </div>
            </div>

        </div>
        @endforeach
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <script>
        new DataTable('#example');
    </script>
</body>

</html>