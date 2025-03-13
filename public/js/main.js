document.addEventListener("DOMContentLoaded", function () {

    // Price format
    function formatPrice(input) {
        if (input) {
            input.addEventListener("input", function () {
                let value = this.value.replace(/\./g, "").replace(/\D/g, "");
                this.value = value ? parseInt(value, 10).toLocaleString("id-ID") : "";
            });
        }
    }

    // Insert price format
    formatPrice(document.getElementById("price"));
    formatPrice(document.getElementById("price_promo"));
    formatPrice(document.getElementById("sub_total"));
    formatPrice(document.getElementById("total_price"));

    // MODALS
    document.querySelectorAll('.modal').forEach(modal => {

        //Modal delete
        modal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;

            if (!button) {
                console.warn("⚠️ Tidak ada tombol yang memicu modal!");
                return;
            }

            var itemName = button.getAttribute('data-bs-name');
            var itemUrl = button.getAttribute('data-bs-url');

            var deleteModalItemName = this.querySelector('#deleteModalItemName');
            var deleteModalForm = this.querySelector('#deleteModalForm');

            if (deleteModalItemName) {
                deleteModalItemName.textContent = itemName || "Nama Tidak Ditemukan";
            }

            if (deleteModalForm) {
                deleteModalForm.action = itemUrl || "#";
            }
        });

        // Format price in modal
        modal.addEventListener('shown.bs.modal', function () {
            formatPrice(document.getElementById("price_promo"));
        });
    });

    // Phone number formatting
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

    // Image preview
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

    // Menu promotion
    $(document).ready(function () {
        var $pricePromoInput = $("#price_promo");
        var $promoDates = $("#promo_dates");

        function togglePromoDates() {
            var pricePromoValue = $pricePromoInput.val();
            if (pricePromoValue) {
                pricePromoValue = pricePromoValue.replace(/\./g, '');
            } else {
                pricePromoValue = "0";
            }

            if ($.trim(pricePromoValue) !== "" && pricePromoValue !== "0") {
                $promoDates.removeClass("d-none");
            } else {
                $promoDates.addClass("d-none");
            }
        }

        if ($pricePromoInput.length) {
            togglePromoDates();
            $pricePromoInput.on("input", togglePromoDates);
        }
    });

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

        const outletSelect = $("#outlet_id");
        const userSelect = $("#user_id");

        let menuOptions = menuSelect.html();

        // Select2 menu
        menuSelect.select2({
            theme: "bootstrap-5",
            width: "100%"
        });

        function toggleAddButton() {
            if (menuSelect.val() && quantityInput.val() > 0) {
                addMenuBtnContainer.removeClass("d-none");
            } else {
                addMenuBtnContainer.addClass("d-none");
            }
        }

        function updateSubTotal() {
            let total = 0;

            $(".menu-select").each(function () {
                const selectedOption = $(this).find("option:selected");
                const price = parseFloat(selectedOption.attr("data-price")) || 0;
                const quantityInput = $(this).closest(".row").find(".menu-quantity");
                const subtotalInput = $(this).closest(".row").find(".sub-total-input");

                const quantity = parseInt(quantityInput.val()) || 1;
                const subtotal = price * quantity;

                subtotalInput.val(subtotal.toLocaleString("id-ID"));
                total += subtotal;
            });

            // Insert total
            $("#sub_total").val(total.toLocaleString("id-ID"));
            $("#total_price").val(total.toLocaleString("id-ID"));
        }


        function addMenuRow() {
            const newMenuRow = $("<div>").addClass("row align-items-end mb-3");

            // Menu
            const newSelect = $("<select>")
                .addClass("form-select select2 menu-select")
                .attr({ name: "menu_id[]", required: true })
                .css("width", "100%")
                .html(menuOptions);

            const newSelectWrapper = $("<div>").addClass("col-lg-7 col-md-6 col-7").append(
                $("<div>").addClass("mb-3").append(
                    $("<label>").addClass("form-label").text("Menu"),
                    newSelect
                )
            );

            // Quantity
            const newQuantityWrapper = $("<div>").addClass("col-lg-3 col-md-4 col-3").append(
                $("<div>").addClass("mb-3").append(
                    $("<label>").addClass("form-label").text("Quantity"),
                    $("<input>")
                        .addClass("form-control menu-quantity")
                        .attr({ type: "number", name: "quantity[]", min: 1, placeholder: "Quantity..", required: true })
                )
            );

            // Sub total
            const newSubTotalInput = $("<input>")
                .addClass("form-control sub-total-input")
                .attr({
                    type: "text",
                    name: "sub_total[]",
                    readonly: true
                });

            const newSubTotalWrapper = $("<div>").addClass("col-lg-3 col-md-4 col-3 d-none").append(
                $("<div>").addClass("mb-3").append(
                    $("<label>").addClass("form-label").text("Sub Total"),
                    $("<div>").addClass("input-group").append(
                        $("<span>").addClass("input-group-text").text("Rp"),
                        newSubTotalInput
                    )
                )
            );

            // Delete
            const newDeleteWrapper = $("<div>").addClass("col-lg-2 col-md-2 col-2 text-md-center text-end").append(
                $("<div>").addClass("mb-3").append(
                    $("<button>")
                        .addClass("btn btn-transparent btn-remove-menu")
                        .attr("type", "button")
                        .append($("<i>").addClass("bi bi-x-circle-fill text-danger"))
                )
            );

            newMenuRow.append(newSelectWrapper, newQuantityWrapper, newSubTotalWrapper, newDeleteWrapper);
            menuContainer.append(newMenuRow);

            newSelect.select2({ theme: "bootstrap-5", width: "100%" });

            newSelectWrapper.find("select").on("change select2:select", updateSubTotal);
            newQuantityWrapper.find("input").on("change input", updateSubTotal);

            newDeleteWrapper.find(".btn-remove-menu").on("click", function () {
                newMenuRow.remove();
                updateSubTotal();
            });

            updateSubTotal();
        }

        $("#add-menu-btn").on("click", addMenuRow);
        menuSelect.on("change", toggleAddButton);
        quantityInput.on("input", toggleAddButton);

        outletSelect.change(function () {
            let outletId = $(this).val();
            let outletSlug = $(this).find(":selected").data("slug");

            if (outletId > 0 ) {
                $(".row-form").removeClass("d-none");
            }

            userSelect.html('<option>Loading...</option>');
            menuSelect.html('<option>Loading...</option>');

            menuContainer.empty();
            $("#quantity").val("Quantity..");
            $("#sub_total").val("0");
            $("#total_price").val("0");
            addMenuBtnContainer.addClass("d-none");

            // Fetch users
            $.ajax({
                url: '/get-users/' + outletSlug,
                type: 'GET',
                success: function (data) {
                    let options = '<option value="" disabled selected>Pilih Staff</option>';

                    data.forEach(user => {
                        options += `<option value="${user.id}">${user.name}</option>`;
                    });

                    userSelect.html(options);
                }
            });

            // Fetch menus
            $.ajax({
                url: '/get-menus/' + outletSlug,
                type: 'GET',
                success: function (data) {
                    let options = '<option value="" disabled selected>Pilih Menu</option>';

                    data.forEach(menu => {
                        let finalPrice = menu.price;

                        if (menu.price_promo && menu.price_promo.price_promo) {
                            finalPrice = menu.price - menu.price_promo.price_promo;
                        }

                        options += `<option value="${menu.id}" data-price="${finalPrice}">${menu.name}</option>`;
                    });

                    menuSelect.html(options);
                    menuSelect.select2("destroy").html(options).select2({ theme: "bootstrap-5", width: "100%" });

                    menuOptions = options;
                    updateSubTotal();
                }
            });
        });

        // $(document).on("change select2:select", ".menu-select", updateSubTotal);
        $(document).on("change input", ".menu-quantity", updateSubTotal);

        updateSubTotal();
    });

    // Show customer name
    $(document).ready(function () {
        $("#customer_id").change(function () {
            let selectedOption = $(this).find("option:selected");
            let customerName = selectedOption.data("name");

            if (customerName) {
                $("#customer_name").val(customerName);
                $("#customer_name_wrapper").removeClass("d-none");
            } else {
                $("#customer_name_wrapper").addClass("d-none");
            }
        });
    });

});
