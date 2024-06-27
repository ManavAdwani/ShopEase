<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sainath mobiles - Settings</title>
    <link rel="stylesheet" href="{{asset('css/create_products.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    <style>

    </style>
</head>

@include('navbar')

<body>

    <div class="container">
        <h3>Settings</h3>
        @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
         @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif
        @endif
        @php 
        $settingDB = DB::table('admin_nav_bar')->select()->first();
        if(!empty($settingDB)){
            $website_name = $settingDB->name;
            $website_logo = $settingDB->logo;
        }
        @endphp
        <form action="{{route('admin.setting_update')}}" class="mt-5" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- 2 column grid layout with text inputs for the first and last names -->
            <div class="mb-3">
                <label for="formFileMultiple" class="form-label">Logo</label>
                <input class="form-control" name="website_logo" type="file" id="formFileMultiple" accept="image/*">
                <div class="image-preview mt-2" id="imagePreview"></div>
                @if(!empty($settingDB))
                        <img src="{{ asset('storage/'.$website_logo) }}" alt="Logo" class="nav_logo-icon" style="height: 100px; width: auto;">
                @endif
            </div>
            <div class="row mb-4">
                <div class="col">
                    <div data-mdb-input-init class="form-outline">
                        <label class="form-label" for="form6Example1">Website name</label>
                        <input type="text" value="{{$website_name ?? ''}}" name="website_name" placeholder="Website Name" id="form6Example1"
                            class="form-control" />
                    </div>
                </div>
            </div>

            <!-- Submit button -->
            <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4">Change</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <script>
        document.getElementById('formFileMultiple').addEventListener('change', function(event) {
    const imagePreview = document.getElementById('imagePreview');
    imagePreview.innerHTML = ''; // Clear existing images
    const files = Array.from(event.target.files);

    // Create a DataTransfer object to manipulate the files
    const dataTransfer = new DataTransfer();

    files.forEach((file, index) => {
        if (file && file.type.startsWith('image/')) {
            dataTransfer.items.add(file); // Add each file to the DataTransfer object

            const reader = new FileReader();
            reader.onload = function(e) {
                const imageContainer = document.createElement('div');
                imageContainer.classList.add('image-container');

                const img = document.createElement('img');
                img.src = e.target.result;

                const deleteBtn = document.createElement('button');
                deleteBtn.classList.add('delete-btn');
                deleteBtn.innerHTML = '&times;';
                deleteBtn.addEventListener('click', () => {
                    // Remove the file from the DataTransfer object
                    dataTransfer.items.remove(index);

                    // Update the file input with the new files list
                    document.getElementById('formFileMultiple').files = dataTransfer.files;

                    // Remove the image preview
                    imageContainer.remove();
                });

                imageContainer.appendChild(img);
                imageContainer.appendChild(deleteBtn);
                imagePreview.appendChild(imageContainer);
            }
            reader.readAsDataURL(file);
        }
    });

    // Update the file input with the DataTransfer object files
    document.getElementById('formFileMultiple').files = dataTransfer.files;
});


    </script>
</body>

</html>