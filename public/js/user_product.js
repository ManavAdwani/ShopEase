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
    const defaultImage = "https://www.incathlab.com/images/products/default_product.png";

    $.ajax({
        url: ProductData, // URL to your controller
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            product_id: pid,
        },
        success: function(response) {
            if (response && response.productData && response.productData.length > 0) {
                const images = response.productData[0].images.split(',');
                const carouselWrapper = document.querySelector('.swiper-wrapper');

                // Clear existing carousel items
                while (carouselWrapper.firstChild) {
                    carouselWrapper.removeChild(carouselWrapper.firstChild);
                }

                // Add new carousel items
                images.forEach(image => {
                    const div = document.createElement('div');
                    div.className = 'swiper-slide';
                    const img = document.createElement('img');
                    img.src = image ? image : defaultImage;
                    img.style.width = '100%';
                    div.appendChild(img);
                    carouselWrapper.appendChild(div);
                });

                // Initialize Swiper carousel after DOM updates
                setTimeout(() => {
                    const swiper = new Swiper('.modalCarousel', {
                        // Swiper parameters
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                    });
                    console.log(swiper); // Log Swiper instance for debugging
                }, 100); // Delay initialization to ensure DOM is updated

                // Show the modal
                var myModal = new bootstrap.Modal(document.getElementById('productModal'));
                myModal.show();
            } else {
                // Update modal content for error
                document.getElementById('modalLabel').textContent = "Error!";
                document.getElementById('modalMessage').textContent = response ? response.message : "Unknown error";

                // Clear previous images
                const carouselWrapper = document.querySelector('.swiper-wrapper');
                if (carouselWrapper) {
                    while (carouselWrapper.firstChild) {
                        carouselWrapper.removeChild(carouselWrapper.firstChild);
                    }
                }

                // Show the modal
                var myModal = new bootstrap.Modal(document.getElementById('productModal'));
                myModal.show();
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                title: "Error!",
                text: "Something went wrong. Please try again later.",
                icon: "error",
            });
        },
    });
}

