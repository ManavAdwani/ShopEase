$(document).on("click", ".browse", function () {
    var file = $(this).parent().parent().parent().find(".file");
    file.trigger("click");
});

$(document).on("change", ".file", function () {
    var fileName = $(this)
        .val()
        .replace(/C:\\fakepath\\/i, "");
    $(this).parent().find(".form-control").val(fileName);

    // Preview the CSV file$(document).on("click", ".browse", function() {
            var file = $(this).parent().parent().parent().find(".file");
            file.trigger("click");
        });

        $(document).on("change", ".file", function() {
            var fileName = $(this).val().replace(/C:\\fakepath\\/i, "");
            $(this).parent().find(".form-control").val(fileName);

            // Preview the CSV file
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
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

            lines.forEach(function(line, index) {
                var row = $("<tr></tr>");
                var cells = line.split(",");

                if (index === 0) {
                    var headerRow = $("<tr></tr>");
                    headerRow.append($("<th></th>").text("Select"));
                    cells.forEach(function(cell) {
                        headerRow.append($("<th></th>").text(cell));
                    });
                    headerRow.append($("<th></th>").text("Validation"));
                    tableHead.append(headerRow);
                } else {
                    var checkbox = $("<td></td>").append($("<input type='checkbox'>"));
                    row.append(checkbox);

                    cells.forEach(function(cell) {
                        row.append($("<td></td>").text(cell));
                    });

                    var validationCell = $("<td></td>");
                    var validationResult = validateRow(cells);
                    if (validationResult !== true) {
                        validationCell.addClass("warning").text(validationResult);
                    } else {
                        checkbox.find("input").prop("checked", true);
                    }
                    row.append(validationCell);

                    tableBody.append(row);
                }
            });
        }

        function validateRow(cells) {
            // Check if the row has exactly 4 columns (Name, Email, Role, Phone)
            if (cells.length !== 4) {
                return "Invalid number of columns";
            }

            var name = cells[0].trim();
            var email = cells[1].trim();
            var role = cells[2].trim();
            var phone = cells[3].trim();

            // Check if all fields are non-empty
            if (!name) {
                return "Invalid name";
            }
            if (!email) {
                return "Invalid email";
            }
            if (!role) {
                return "Invalid role";
            }
            if (!phone) {
                return "Invalid phone";
            }

            // Email validation regex
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                return "Invalid email format";
            }

            // Phone number validation (exactly 10 digits)
            var phoneRegex = /^\d{10}$/;
            if (!phoneRegex.test(phone)) {
                return "Invalid phone format";
            }

            return true;
        }
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var csvContent = e.target.result;
            displayCSVContent(csvContent);
        };
        reader.readAsText(this.files[0]);
    }
    

function displayCSVContent(csvContent) {
    var lines = csvContent.split("\n");
    var tableHead = $("#csv-preview thead");
    var tableBody = $("#csv-preview tbody");

    tableHead.empty();
    tableBody.empty();

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
            var validationResult = validateRow(cells);
            if (validationResult !== true) {
                validationCell.addClass("warning").text(validationResult);
            } else {
                checkbox.find("input").prop("checked", true);
            }
            row.append(validationCell);

            tableBody.append(row);
        }
    });
}

function validateRow(cells) {
    // Check if the row has exactly 4 columns (Name, Email, Role, Phone)
    if (cells.length !== 4) {
        return "Invalid number of columns";
    }

    var name = cells[0].trim();
    var email = cells[1].trim();
    var role = cells[2].trim();
    var phone = cells[3].trim();

    // Check if all fields are non-empty
    if (!name) {
        return "Invalid name";
    }
    if (!email) {
        return "Invalid email";
    }
    if (!role) {
        return "Invalid role";
    }
    if (!phone) {
        return "Invalid phone";
    }

    // Email validation regex
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        return "Invalid email format";
    }

    // Phone number validation (basic check for digits only)
    var phoneRegex = /^\d+$/;
    if (!phoneRegex.test(phone)) {
        return "Invalid phone format";
    }

    return true;
}
