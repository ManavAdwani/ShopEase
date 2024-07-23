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
            if (response) {
                var unFilledHeart = document.getElementById(
                    "unFilled_heart_" + product_id
                );
                var filledHeart = document.getElementById(
                    "filled_heart_" + product_id
                );

                if (unFilledHeart && filledHeart) {
                    // Check if both elements exist
                    if (unFilledHeart.style.display !== "none") {
                        unFilledHeart.style.display = "none";
                        filledHeart.style.display = "block";
                        Swal.fire({
                            title: "Favorite",
                            text: "Product added in favorites!",
                            icon: "success",
                        });
                    } else {
                        unFilledHeart.style.display = "block";
                        filledHeart.style.display = "none";
                        Swal.fire({
                            title: "Favorite",
                            text: "Product removed from favorites!",
                            icon: "success",
                        });
                    }
                } else {
                    console.error(
                        "Elements not found: unFilled_heart_" +
                            product_id +
                            " or filled_heart_" +
                            product_id
                    );
                }
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
    var atc = document.getElementById("addToCart" + pid);
    var pro_quan = document.getElementById("pro_quan" + pid);
    var addBtn = document.getElementById("addBtn" + pid);
    var cancelBtn = document.getElementById("cancelBtn" + pid);

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
    var atc = document.getElementById("addToCart" + pid);
    var pro_quan = document.getElementById("pro_quan" + pid);
    var addBtn = document.getElementById("addBtn" + pid);
    var cancelBtn = document.getElementById("cancelBtn" + pid);
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
    var pro_quan = document.getElementById("pro_quan" + pid).value;
    var user_id = document.getElementById("user_id").value;

    $.ajax({
        url: addToCart_route, // URL to your controller
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            product_id: pid,
            user_id: user_id,
            pro_quan: pro_quan,
        },
        success: function (response) {
            if (response.status === "success") {
                Swal.fire({
                    title: "Product added to your cart!",
                    text: response.data + " added successfully to your cart!",
                    icon: "success",
                });
            } else {
                Swal.fire({
                    title: "Error!",
                    text: response.message,
                    icon: "error",
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                title: "Error!",
                text: "Something went wrong. Please try again later.",
                icon: "error",
            });
        },
    });
}

function getProductData(product_id) {
    var pid = product_id;
    // users.productData
    $.ajax({
        url: ProductData, // URL to your controller
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            product_id: pid,
        },
        success: function (response) {
            if (response) {
                // Get the first product from the response array
                const product = response.productData[0];

                // Update modal content
                document.getElementById("modalLabel").textContent =
                    "Product details";

                // Handle comma-separated image URLs
                const images = product.images.split(","); // Split the image URLs by comma
                const imageContainer = document.getElementById("modalImages");

                // Clear previous images
                imageContainer.innerHTML = "";

                const placeholderImageUrl = "https://www.incathlab.com/images/products/default_product.png";

                // Add images to the modal
                images.forEach((imageUrl) => {
                    let imageUrls =  imageUrl.trim();
                    const imgElement = document.createElement("img");
                    imgElement.alt = "Product Image";
                    imgElement.style.width = "30%"; // Adjust size as needed
                    imgElement.style.maxWidth = "300px"; // Adjust size as needed
                    imgElement.style.marginBottom = "10px"; // Space between images

                    imgElement.src = imageUrls;

                    imgElement.onerror = () => {
                        imgElement.src = placeholderImageUrl;
                    };

                    imageContainer.appendChild(imgElement);
                });
                var product_price = "₹" + product.product_price;
                document.getElementById("productName").innerHTML =
                    product.product_name;
                document.getElementById("productCom").innerHTML =
                    product.company;
                document.getElementById("productCat").innerHTML =
                    product.category;
                document.getElementById("productPrice").innerHTML =
                    product_price;

                const productQuantityElement =
                    document.getElementById("productQuan");

                // Set the quantity
                productQuantityElement.innerHTML = product.quantity;

                // Apply red color if the quantity is 0
                if (product.quantity === 0) {
                    productQuantityElement.style.color = "red";
                } else {
                    productQuantityElement.style.color = ""; // Reset color if not 0
                }

                // Show the modal
                var myModal = new bootstrap.Modal(
                    document.getElementById("productModal")
                );
                myModal.show();
            } else {
                // Update modal content for error
                document.getElementById("modalLabel").textContent = "Error!";
                document.getElementById("modalMessage").textContent = response
                    ? response.message
                    : "Unknown error";

                // Clear previous images
                document.getElementById("modalImages").innerHTML = "";

                // Show the modal
                var myModal = new bootstrap.Modal(
                    document.getElementById("productModal")
                );
                myModal.show();
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                title: "Error!",
                text: "Something went wrong. Please try again later.",
                icon: "error",
            });
        },
    });
}
