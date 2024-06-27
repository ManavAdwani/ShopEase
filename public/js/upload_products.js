$(document).ready(function() {
    // $('#submit-data').prop('disabled', true);
});

$(document).on("click", ".browse", function () {
    var file = $(this).parent().parent().parent().find(".file");
    file.trigger("click");
});

$(document).on("change", ".file", function () {
    var fileName = $(this).val().replace(/C:\\fakepath\\/i, "");
    $(this).parent().find(".form-control").val(fileName);

    // Preview the CSV file
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var csvContent = e.target.result;
            displayCSVContent(csvContent);
        };
        reader.readAsText(this.files[0]);
    }
});

function displayCSVContent(csvContent) {
    var lines = csvContent.split("\n");
    var tableHead = $("#csv-preview thead");
    var tableBody = $("#csv-preview tbody");

    tableHead.empty();
    tableBody.empty();

    var allValid = true;

    var validatedEmails = new Set();
    var validatedPhones = new Set();

    lines.forEach(function (line, index) {
        var row = $("<tr></tr>");
        var cells = line.split(",");

        if (index === 0) {
            var headerRow = $("<tr></tr>");
            headerRow.append($("<th></th>").text("Select"));
            cells.forEach(function (cell) {
                headerRow.append($("<th></th>").text(cell));
            });
            headerRow.append($("<th></th>").text("Validation"));
            tableHead.append(headerRow);
        } else {
            var checkbox = $("<td></td>").append($("<input type='checkbox'>"));
            row.append(checkbox);

            cells.forEach(function (cell) {
                row.append($("<td></td>").text(cell));
            });

            var validationCell = $("<td></td>");
            validateRow(cells, validatedEmails, validatedPhones, function(validationResult) {
                if (validationResult !== true) {
                    validationCell.addClass("warning").text(validationResult);
                    checkbox.find("input").prop("checked", false);  // Uncheck if validation fails
                    allValid = false;
                } else {
                    checkbox.find("input").prop("checked", true);  // Check if validation passes
                }
                row.append(validationCell);
            });

            tableBody.append(row);
        }
    });

    // $('#submit-data').prop('disabled', !allValid);
}


function validateRow(cells, validatedEmails, validatedPhones, callback) {
    if (cells.length !== 7) {
        callback("Invalid number of columns");
        return;
    }

    var name = cells[0].trim();
    var company = cells[1].trim();
    var category = cells[2].trim();
    var price = cells[3].trim();
    var quantity = cells[4].trim();
    var model_number = cells[5].trim();
    var color = cells[6].trim()

    if (!name) {
        callback("Invalid name");
        return;
    }
    if (!company) {
        callback("Invalid company");
        return;
    }
    if (!category) {
        callback("Invalid category");
        return;
    }
    if (!price) {
        callback("Invalid price");
        return;
    }
    if(!quantity){
        callback("Invalid quantity");
        return;
    }
    if(!model_number){
        callback("Invalid model number");
        return;
    }
    if(!color){
        callback("Invalid color");
        return;
    }

    $.ajax({
        url: check_product, // URL to your server-side phone validation endpoint
        type: 'POST',
        data: JSON.stringify({ name: name,model_number:model_number }),
        contentType: 'application/json',
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function(response) {
            if (response.exists) {
                callback("Product is added !");
                checkbox.find("input").prop("checked", false);
            } else {
                validatedPhones.add(phone); // Add phone to validated set
                callback(true); // All validations passed
            }
        },
        error: function(error) {
            callback("Error validating phone: " + error);
        }
    });

    callback(true);
}

$(document).on("click", "#submit-data", function () {
    const inputField = document.querySelector('input[type="text"]');
    const isEmpty = inputField.value.trim() === '';

    if (isEmpty) {
        Swal.fire({
            title: 'Error!',
            text: 'Please add csv file first!',
            icon: 'error',
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
        });
        return;
    }

    var validRows = [];
    $("#csv-preview tbody tr").each(function () {
        var checkbox = $(this).find("input[type='checkbox']");
        if (checkbox.is(":checked")) {
            var cells = $(this).find("td").map(function () {
                return $(this).text();
            }).get();
            cells.shift();
            cells.pop();
            validRows.push(cells);
        }
    });

    $.ajax({
        url: store_csv,
        type: 'POST',
        contentType: 'application/json',
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: JSON.stringify({ 'productsData': validRows }),
        success: function (response) {
            Swal.fire({
                title: 'Success!',
                text: 'Products added successfully!',
                icon: 'success',
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        },
        error: function (error) {
            Swal.fire({
                title: 'Error!',
                text: 'Something went wrong! Please try again later!',
                icon: 'error',
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        }
    });
});
