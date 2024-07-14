<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sainath mobiles - Create Product</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <label class="form-label" for="form6Example1">Model number</label>
                        <input type="text" name="model_number" placeholder="Model number" id="form6Example1"
                            class="form-control" />
                    </div>
                </div>
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
                <div class="cmp" style="display: flex">
                    <select class="form-select" name="company_id" aria-label="Default select example"
                        id="addCompanySelect">
                        <option selected>Select company name</option>
                        @foreach ($companies as $company)
                        <option value="{{$company->id}}">{{$company->company_name}}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#addCmp">
                        <span class="material-symbols-outlined">
                            add_circle
                        </span>
                    </button>
                </div>
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form6Example3">Category name</label>
                <div class="cat" style="display: flex">
                    <select class="form-select" name="category_id" aria-label="Default select example"
                        id="addCategorySelect">
                        <option selected>Select category name</option>
                        @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#addCat">
                        <span class="material-symbols-outlined">
                            add_circle
                        </span>
                    </button>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                    <div data-mdb-input-init class="form-outline">
                        <label class="form-label" for="form6Example1">Color</label>
                        <input type="text" name="color" placeholder="Color" id="form6Example1" class="form-control" />
                    </div>
                </div>
            </div>
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form6Example4">Product quantity</label>
                <input type="number" name="quantity" id="form6Example4" placeholder="Product quantity"
                    class="form-control" />
            </div>
            <!-- Text input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form6Example4">Product price</label>
                <input type="number" name="product_price" id="form6Example4" placeholder="Product price"
                    class="form-control" />
            </div>

            <!-- Submit button -->
            <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4">Create</button>
            <button data-mdb-ripple-init type="button" class="btn btn-warning btn-block mb-4">Submit and create
                another</button>
            <button data-mdb-ripple-init type="button" class="btn btn-danger btn-block mb-4">Cancel</button>
        </form>
    </div>


    {{-- MODAL --}}

    <div class="modal fade" id="addCmp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Company</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.create_company')}}" method="POST" id="companyForm">
                        @csrf
                        <label for="">Company Name</label>
                        <input type="text" name="company_name" id="" class="form-control mt-2"
                            placeholder="Company Name" required>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="addCompany" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addCat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                <tr>
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td>{{$category->category_name}}</td>
                                    <td><span onclick="editCategory({{$category->id}})"
                                            style="color:red;cursor: pointer;" class="material-symbols-outlined">
                                            edit
                                        </span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <form action="{{route('admin.create_category')}}" method="POST" id="categoryForm"
                        style="margin-top: 40px;">
                        @csrf
                        <input type="hidden" name="category_id" id="categoryId">
                        <label for="">Category Name</label>
                        <input type="text" name="category_name" id="cat_name" class="form-control mt-2"
                            placeholder="Category Name" required>
                        <br>
                        <label for="">Category Logo</label>
                        <input type="file" name="category_logo" id="" class="form-control mt-2"
                            placeholder="Category Name" required>
                        <br><br>
                        <h4 id="uploaded_logo" style="display:none">Uploaded Logo</h4>
                        <img id="cat_logo" alt="Category Logo" style="display:none"/>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="addCategory" class="btn btn-primary">Submit</button>
                    <button type="button" id="editCategory" class="btn btn-primary" style="display:none;">Edit</button>
                </div>
            </div>
        </div>
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
        function editCategory(catId){
            var category_id = catId;
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = '/edit-category';
        
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ category_id: category_id })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('cat_name').value = data.category_name;
                document.getElementById('editCategory').style.display = 'block';
                document.getElementById('addCategory').style.display = 'none';
                document.getElementById('categoryId').value = category_id;
                console.log('Success:', data);
                var logoElement = document.getElementById('cat_logo');
                var logoTitle = document.getElementById('uploaded_logo');
                if (data.category_logo != null) {
                    logoElement.src = data.category_logo;
                    logoElement.style.display = 'block';
                    logoTitle.style.display = 'block';
                } else {
                    logoElement.style.display = 'none';
                    logoTitle.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
        }
    </script>


    <script>
        document.getElementById('formFileMultiple').addEventListener('change', function(event) {
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.innerHTML = ''; // Clear existing images
            const files = Array.from(event.target.files);
    
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
                            dataTransfer.items.remove(index);
    
                            document.getElementById('formFileMultiple').files = dataTransfer.files;
    
                            imageContainer.remove();
                        });
    
                        imageContainer.appendChild(img);
                        imageContainer.appendChild(deleteBtn);
                        imagePreview.appendChild(imageContainer);
                    }
                    reader.readAsDataURL(file);
                }
            });
    
            document.getElementById('formFileMultiple').files = dataTransfer.files;
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const updateForm = '{{route('admin.update_category')}}';
            const form = document.getElementById('categoryForm');
            const submitButton = document.getElementById('editCategory');
            const select = document.getElementById('addCategorySelect');
    
            submitButton.addEventListener('click', function (event) {
                event.preventDefault();
    
                const formData = new FormData(form);
    
                fetch(updateForm, {
                    method: form.method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        title: "Category edited successfully!",
                        icon: "success",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });

                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById('companyForm');
            const submitButton = document.getElementById('addCompany');
            const select = document.getElementById('addCompanySelect');
    
            submitButton.addEventListener('click', function (event) {
                event.preventDefault();
    
                const formData = new FormData(form);
    
                fetch(form.action, {
                    method: form.method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.id && data.company_name) {
                        console.log('Company ID:', data.id);
                        console.log('Company Name:', data.company_name);
    
                        const newOption = document.createElement('option');
                        newOption.value = data.id;
                        newOption.text = data.company_name;
                        newOption.selected = true;
                        select.add(newOption);
    
                        const modalElement = document.getElementById('addCmp');
                        const modalInstance = bootstrap.Modal.getInstance(modalElement);
                        modalInstance.hide();
    
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) {
                            backdrop.parentNode.removeChild(backdrop);
                        }
                        document.body.classList.remove('modal-open');
                        document.body.style.paddingRight = '';
    
                        Swal.fire({
                            title: "Company added successfully!",
                            text: data.company_name + " Company Added successfully!",
                            icon: "success"
                        });
                    } else {
                        console.error('Error in response data:', data);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById('categoryForm');
        const submitButton = document.getElementById('addCategory');
        const selectCat = document.getElementById('addCategorySelect');

        submitButton.addEventListener('click', function (event) {
            event.preventDefault();

            const formData = new FormData(form);

            fetch(form.action, {
                method: form.method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.id && data.category_name) {
                    console.log('Category ID:', data.id);
                    console.log('Category Name:', data.category_name);

                    const newOption = document.createElement('option');
                    newOption.value = data.id;
                    newOption.text = data.category_name;
                    newOption.selected = true;
                    selectCat.add(newOption);

                    const modalElement = document.getElementById('addCat');
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    modalInstance.hide();

                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) {
                        backdrop.parentNode.removeChild(backdrop);
                    }
                    document.body.classList.remove('modal-open');
                    document.body.style.paddingRight = '';

                    Swal.fire({
                        title: "Category added successfully!",
                        text: data.category_name + " Category Added successfully!",
                        icon: "success"
                    });
                } else {
                    console.error('Error in response data:', data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
    </script>

</body>

</html>