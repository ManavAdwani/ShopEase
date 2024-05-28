<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sainath mobiles - Create Users</title>
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

<body>
    @include('navbar')

    <div class="container">
        <h3>Create Product</h3>
        @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{route('admin.product_store')}}" class="mt-5" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- 2 column grid layout with text inputs for the first and last names -->
            <div class="mb-3">
                <label for="formFileMultiple" class="form-label">Images</label>
                <input class="form-control" name="product_images[]" type="file" id="formFileMultiple" multiple>
                <div class="image-preview mt-2" id="imagePreview"></div>
            </div>
            <div class="row mb-4">
                <div class="col">
                    <div data-mdb-input-init class="form-outline">
                        <label class="form-label" for="form6Example1">Product name</label>
                        <input type="text" name="product_name" placeholder="Product name" id="form6Example1"
                            class="form-control" />
                    </div>
                </div>
            </div>

            <!-- Text input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form6Example3">Company name</label>
                <select class="form-select" name="company_id" aria-label="Default select example">
                    <option selected>Select company name</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form6Example3">Category name</label>
                <select class="form-select" name="category_id" aria-label="Default select example">
                    <option selected>Select category name</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>

            <!-- Text input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form6Example4">Product price</label>
                <input type="text" name="product_price" id="form6Example4" placeholder="product_price"
                    class="form-control" />
            </div>

            <!-- Submit button -->
            <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4">Create</button>
            <button data-mdb-ripple-init type="button" class="btn btn-warning btn-block mb-4">Submit and create
                another</button>
            <button data-mdb-ripple-init type="button" class="btn btn-danger btn-block mb-4">Cancel</button>
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