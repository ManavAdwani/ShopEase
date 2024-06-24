function addFavoriteProduct(product_ids) {
    var product_id = product_ids;
    // alert(product_id);
    var user_id = document.getElementById("user_id").value;
    $.ajax({
        url: fav_pro_route, // URL to your controller
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            product_id: product_id,
            user_id: user_id,
        },
        success: function (response) {
            if(response){
                Swal.fire({
                    title: "Favorite",
                    text: "Product removed from favorites!",
                    icon: "success"
                  }).then((result) => {
                    if (result.isConfirmed) {
                      location.reload();
                    }
                  });
                  
            }
        },
        error: function (xhr, status, error) {
            // Handle error
            alert("Error: " + error);
        },
    });
}

function addToCart(product_id) {
    var pid = product_id;
    var atc = document.getElementById("addToCart"+pid);
    var pro_quan = document.getElementById("pro_quan"+pid);
    var addBtn = document.getElementById("addBtn"+pid);
    var cancelBtn = document.getElementById("cancelBtn"+pid);

    atc.style.display = "none";
    pro_quan.style.display = "inline";
    addBtn.style.display = "inline";
    addBtn.style.width = "100%";
    addBtn.style.marginTop = "10px";
    cancelBtn.style.display = "inline";
    cancelBtn.style.width = "100%";
    cancelBtn.style.marginTop = "10px";
}

function cancelCartButton(product_id) {
    var pid = product_id;
    var atc = document.getElementById("addToCart"+pid);
    var pro_quan = document.getElementById("pro_quan"+pid);
    var addBtn = document.getElementById("addBtn"+pid);
    var cancelBtn = document.getElementById("cancelBtn"+pid);
    // Add blur event listener to pro_quan
    cancelBtn.addEventListener("click", function () {
        pro_quan.style.display = "none";
        atc.style.display = "block";
        addBtn.style.display = "none";
        cancelBtn.style.display = "none";
    });
}

function addToCartButton(product_id) {
    var pid = product_id;
    var pro_quan = document.getElementById("pro_quan"+pid).value;
    var user_id = document.getElementById('user_id').value;

    $.ajax({
        url: addToCart_route, // URL to your controller
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            product_id: pid,
            user_id: user_id,
            pro_quan: pro_quan
        },
        success: function (response) {
            if (response.status === 'success') {
                Swal.fire({
                    title: "Product added to your cart!",
                    text: response.data + " added successfully to your cart!",
                    icon: "success"
                });
            } else {
                Swal.fire({
                    title: "Error!",
                    text: response.message,
                    icon: "error"
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                title: "Error!",
                text: "Something went wrong. Please try again later.",
                icon: "error"
            });
        },
    });
}

