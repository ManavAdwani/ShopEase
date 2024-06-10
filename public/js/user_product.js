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
                var unFilledHeart = document.getElementById('unFilled_heart_' + product_id);
                var filledHeart = document.getElementById('filled_heart_' + product_id);
        
                if (unFilledHeart && filledHeart) {  // Check if both elements exist
                    if (unFilledHeart.style.display !== "none") {
                        unFilledHeart.style.display = "none";
                        filledHeart.style.display = "inline";
                    } else {
                        unFilledHeart.style.display = "inline";
                        filledHeart.style.display = "none";
                    }
                } else {
                    console.error("Elements not found: unFilled_heart_" + product_id + " or filled_heart_" + product_id);
                }
            }
        },
        error: function (xhr, status, error) {
            // Handle error
            alert("Error: " + error);
        },
    });
}
