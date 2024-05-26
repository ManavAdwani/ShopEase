<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sainath mobiles - Create Users</title>
    <link rel="stylesheet" href="{{asset('css/create_users.css')}}">
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
        <h3>Create User</h3>
        @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="color:red">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <form action="{{route('admin.store_user')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="avatar-upload">
                <div class="avatar-edit">
                    <input type='file' name="profile" id="imageUpload" accept=".png, .jpg, .jpeg" />
                    <label for="imageUpload"></label>
                </div>
                <div class="avatar-preview">
                    <div id="imagePreview"
                        style="background-image: url(https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/Windows_10_Default_Profile_Picture.svg/2048px-Windows_10_Default_Profile_Picture.svg.png);">
                    </div>
                </div>
            </div>
            <!-- 2 column grid layout with text inputs for the first and last names -->
            <!-- Text input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form6Example3">Name</label>
                <input type="text" id="form6Example3" placeholder="Name"  value="{{ old('name') }}" name="name" class="form-control" required />
            </div>

            <div class="row mb-4">
                <div class="col">
                    <div data-mdb-input-init class="form-outline">
                        <label class="form-label" for="form6Example1">Email</label>
                        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" id="form6Example1" class="form-control"
                            required />
                    </div>
                </div>
                <div class="col">
                    <div data-mdb-input-init class="form-outline">
                        <label class="form-label" for="form6Example2">Phone</label>
                        <input type="text" maxlength="10" id="form6Example2" placeholder="Phone" value="{{ old('phone') }}" name="phone" class="form-control"
                            required />
                    </div>
                </div>
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form6Example2">Select user role</label>
            <select class="form-select" name="userRole" aria-label="Default select example">
                <option selected>Select user role</option>
                <option value="2">Sales person</option>
                <option value="3">User</option>
              </select>
            </div>

            <!-- Text input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form6Example4">Password</label>
                <input type="password" placeholder="Password" name="password" id="pass" class="form-control" required />
            </div>
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form6Example4">Confirm Password</label>
                <input type="password" placeholder="Confirm password" onchange="checkPassword(this)" name="cpass" id="cpass" class="form-control"
                    required />
            </div>

            <!-- Submit button -->
            <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4">Create</button>
        </form>
    </div>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <script>
        function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});

    </script>
</body>

</html>