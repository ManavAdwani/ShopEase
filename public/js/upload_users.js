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

    // Keep track of already validated emails and phone numbers
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
                    allValid = false;
                } else {
                    checkbox.find("input").prop("checked", true);
                }
                row.append(validationCell);
            });

            tableBody.append(row);
        }
    });

    // Enable or disable the submit button based on validation results
    // $('#submit-data').prop('disabled', !allValid);
}

function validateRow(cells, validatedEmails, validatedPhones, callback) {
    // Check if the row has exactly 4 columns (Name, Email, Role, Phone)
    if (cells.length !== 4) {
        callback("Invalid number of columns");
        return;
    }

    var name = cells[0].trim();
    var email = cells[1].trim();
    var role = cells[2].trim();
    var phone = cells[3].trim();

    // Check if all fields are non-empty
    if (!name) {
        callback("Invalid name");
        return;
    }
    if (!email) {
        callback("Invalid email");
        return;
    }
    if (!role) {
        callback("Invalid role");
        return;
    }
    if (!phone) {
        callback("Invalid phone");
        return;
    }

    // Email validation regex
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        callback("Invalid email format");
        return;
    }

    // Phone number validation (exactly 10 digits)
    var phoneRegex = /^\d{10}$/;
    if (!phoneRegex.test(phone)) {
        callback("Invalid phone format");
        return;
    }

    // Check if the email is already validated
    if (validatedEmails.has(email) && validatedPhones.has(phone)) {
        callback(true);
        return;
    }

    // Make an AJAX call to the server to check if the email is already registered
    $.ajax({
        url: check_email, // URL to your server-side email validation endpoint
        type: 'POST',
        data: JSON.stringify({ email: email }),
        contentType: 'application/json',
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function(response) {
            if (response.exists) {
                callback("Email is already registered");
            } else {
                validatedEmails.add(email); // Add email to validated set
                validatePhone();
            }
        },
        error: function(error) {
            callback("Error validating email: " + error);
        }
    });

    function validatePhone() {
        // Make an AJAX call to the server to check if the phone is already registered
        $.ajax({
            url: check_phone, // URL to your server-side phone validation endpoint
            type: 'POST',
            data: JSON.stringify({ phone: phone }),
            contentType: 'application/json',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function(response) {
                if (response.exists) {
                    callback("Phone number is already registered");
                } else {
                    validatedPhones.add(phone); // Add phone to validated set
                    callback(true); // All validations passed
                }
            },
            error: function(error) {
                callback("Error validating phone: " + error);
            }
        });
    }
}

$(document).on("click", "#submit-data", function () {
    const inputField = document.querySelector('input[type="text"]');
    const isEmpty = inputField.value.trim() === '';

    if (isEmpty) {
        Swal.fire({
            title: 'Error!',
            text: 'Please add csv file first !',
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
            // Remove the checkbox and validation columns
            cells.shift();
            cells.pop();
            validRows.push(cells);
        }
    });

    // Send validRows to the server
    $.ajax({
        url: store_csv,
        type: 'POST',
        contentType: 'application/json',
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: JSON.stringify({ 'usersData': validRows }),
        success: function (response) {
            Swal.fire({
                title: 'Success!',
                text: 'Users added successfully !',
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
                text: 'Something went wrong! please try again later!',
                icon: 'error',
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        }
    });
});
