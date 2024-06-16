<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sainath mobiles - Admin</title>
    <link rel="stylesheet" href="{{asset('css/users.css')}}">
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
                                person
                            </span>
                            <!-- <i class="fa fa-user fa-5x" aria-hidden="true"></i> -->
                        </div>
                        <div class="text-value-lg" style="font-size: 20px;">
                            {{$activeUsers ?? 0}}
                        </div>
                        <h5>Total Active Users</h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mt-3">
                <div class="text-white card bg-gradient-info" id="cards">
                    <div class="card-body totalEarnings">
                        <div style="float: left; height:50;">
                            <span class="material-symbols-outlined" style="font-size: 50px; margin-top:2px;">
                                work
                            </span>
                            <!-- <i class="fa fa-user fa-5x" aria-hidden="true"></i> -->
                        </div>
                        <div class="text-value-lg" style="font-size: 20px;">
                            {{$totalSalesPerson ?? 0}}
                        </div>
                        <h5>Total Sales person</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container table-responsive py-5">
        <div class="maintitle" style="display: flex; justify-content:space-between">
            <div class="usertitle">
                <h3>Users</h3>
            </div>
            <div class="addUser">
                <a href="{{route('admin.create')}}" class="btn btn-sm btn-primary">Add User</a>
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
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td class="text-center">
                        @if ($user->profile)
                        <img src="{{ asset('storage/' . $user->profile) }}" alt="" width="50" height="50">
                        @else
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/Windows_10_Default_Profile_Picture.svg/512px-Windows_10_Default_Profile_Picture.svg.png?20221210150350"
                            alt="" width="50" height="50">
                        @endif
                    </td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</tds=>
                    <td>{{$user->phone}}</td=>
                    <td>@if ($user->role == 1)
                        <span class="badge bg-primary">Admin</span>
                        @elseif ($user->role == 2)
                        <span class="badge bg-primary">Sales person</span>
                        @elseif($user->role == 3)
                        <span class="badge bg-primary">User</span>
                        @endif
                    </td>
                    <td>
                        @if ($user->status == 1)
                        <span class="badge bg-success">Active</span>
                        @elseif($user->status == 2)
                        <span class="badge bg-danger">Inactive</span>
                        @else
                        <span class="badge bg-danger">Deleted</span>
                        @endif
                    </td>
                    <td>
                        <a title="Edit user" href="{{ route('admin.edit_user', ['id' => $user->id]) }}"><span
                                class="material-symbols-outlined">
                                edit
                            </span></a>
                        <a href="{{route('admin.change_pass',['id'=>$user->id])}}" title="Change password"><span
                                class="material-symbols-outlined" style="color:green">
                                key
                            </span></a>&nbsp;<a title="Delete user"
                            href="{{route('admin.delete_user',$user->id)}}"><span class="material-symbols-outlined"
                                style="color:red">
                                Delete
                            </span></a>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <script>
        new DataTable('#example');
    </script>
</body>

</html>