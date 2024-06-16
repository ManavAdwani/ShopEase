function changeCartValue(cart_id){
    var cart = cart_id;
    var cart_quantity = document.getElementById('cartQuan'+cart);
    var cart_quan = cart_quantity.value;
    $.ajax({
        url: update_cart, // URL to your controller
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            cart_id: cart,
            cart_quantity: cart_quan
        },
        success: function (response) {
            if (response.status === 'success') {
                Swal.fire({
                    title: "Cart updated successfully!",
                    text: "Cart updated",
                    icon: "success"
                }).then(() => {
                    // Refresh the page when the user clicks "OK"
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: "Error!",
                    text: response.message,
                    icon: "error"
                }).then(()=>{
                    location.reload();
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