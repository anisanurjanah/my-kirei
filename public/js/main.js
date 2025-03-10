document.addEventListener("DOMContentLoaded", function () {
    // Price Format
    function formatPrice(input) {
        if (input) {
            input.addEventListener("input", function () {
                let value = this.value.replace(/\./g, "").replace(/\D/g, "");
                this.value = value ? parseInt(value, 10).toLocaleString("id-ID") : "";
            });
        }
    }

    formatPrice(document.getElementById("price"));
    formatPrice(document.getElementById("price_promo"));
    formatPrice(document.getElementById("sub_total"));
    formatPrice(document.getElementById("total_price"));

    // Price Format in Modals
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('shown.bs.modal', function () {
            formatPrice(document.getElementById("price_promo"));

            let stockInput = this.querySelector("#stock");

            if (stockInput) {
                stockInput.focus();
            }
        });
    });

    // Phone Number Formatting
    const phoneInput = document.getElementById("phone");
    if (phoneInput) {
        phoneInput.addEventListener("input", function () {
            let value = phoneInput.value.replace(/\D/g, "");

            if (value.startsWith("0")) {
                value = value.substring(1);
            }

            value = value.replace(/^(\d{3})(\d{4})?(\d{4})?/, function(match, p1, p2, p3) {
                let formatted = p1;
                if (p2) formatted += "-" + p2;
                if (p3) formatted += "-" + p3;

                return formatted;
            });

            phoneInput.value = value;
        });
    }

    // Image Preview
    function previewImage() {
        const image = document.querySelector("#image");
        const imgPreview = document.querySelector(".img-preview");

        if (image.files.length > 0) {
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function (oFREvent) {
                imgPreview.style.display = "block";
                imgPreview.src = oFREvent.target.result;
            };
        }
    }

    const imageInput = document.getElementById("image");
    if (imageInput) {
        imageInput.addEventListener("change", previewImage);
    }

    // Select2
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });
    });

    // Add menu in order
    $(document).ready(function () {
        const menuSelect = $("#menu_id");
        const quantityInput = $("#quantity");
        const addMenuBtnContainer = $("#add-menu-btn-container");
        const menuContainer = $("#menu-container");
        const subTotalInput = $("#sub_total");

        menuSelect.select2({
            theme: "bootstrap-5",
            width: "100%"
        });

        // Add menu button displays
        function toggleAddButton() {
            if (menuSelect.val() && quantityInput.val() > 0) {
                addMenuBtnContainer.removeClass("d-none");
            } else {
                addMenuBtnContainer.addClass("d-none");
            }
        }

        menuSelect.on("change", toggleAddButton);
        quantityInput.on("input", toggleAddButton);

        // Sub total
        function updateSubTotal() {
            let total = 0;

            $(".menu-select").each(function () {
                const selectedOption = $(this).find("option:selected");
                const price = parseFloat(selectedOption.attr("data-price")) || 0;
                const quantity = parseInt($(this).closest(".row").find(".menu-quantity").val()) || 0;

                total += price * quantity;
            });

            subTotalInput.val(total.toLocaleString("id-ID"));
        }

        menuSelect.on("change select2:select", updateSubTotal);
        quantityInput.on("change input", updateSubTotal);

        menuContainer.on("change", ".menu-select, .menu-quantity", updateSubTotal);

        let menuOptions = menuSelect.html();

        $("#add-menu-btn").on("click", function () {
            const newMenuRow = $("<div>").addClass("row align-items-end mb-3");

            // Menu Select
            const newSelectWrapper = $("<div>").addClass("col-lg-7 col-md-6 col-7").append(
                $("<div>").addClass("mb-3").append(
                    $("<label>").addClass("form-label").text("Menu"),
                    $("<select>")
                        .addClass("form-select select2 menu-select")
                        .attr({ name: "menu_id[]", required: true })
                        .css("width", "100%")
                        .html(menuOptions)
                )
            );

            // Quantity Input
            const newQuantityWrapper = $("<div>").addClass("col-lg-3 col-md-4 col-3").append(
                $("<div>").addClass("mb-3").append(
                    $("<label>").addClass("form-label").text("Quantity"),
                    $("<input>")
                        .addClass("form-control menu-quantity")
                        .attr({
                            type: "number",
                            name: "quantity[]",
                            min: 1,
                            placeholder: "Quantity..",
                            required: true,
                        })
                )
            );

            // Delete Button
            const newDeleteWrapper = $("<div>").addClass("col-lg-2 col-md-2 col-2 text-md-center text-end").append(
                $("<div>").addClass("mb-3").append(
                    $("<button>")
                        .addClass("btn btn-transparent btn-remove-menu")
                        .attr("type", "button")
                        .append($("<i>").addClass("bi bi-x-circle-fill text-danger"))
                )
            );

            newMenuRow.append(newSelectWrapper, newQuantityWrapper, newDeleteWrapper);
            menuContainer.append(newMenuRow);

            newSelectWrapper.find("select").select2({
                theme: "bootstrap-5",
                width: "100%",
            });

            newSelectWrapper.find("select").on("change select2:select", updateSubTotal);
            newQuantityWrapper.find("input").on("change input", updateSubTotal);

            // Delete
            newDeleteWrapper.find(".btn-remove-menu").on("click", function () {
                newMenuRow.remove();
                updateSubTotal();
            });

            updateSubTotal();
        });

        updateSubTotal();
    });
});
