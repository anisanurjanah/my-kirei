$(document).ready(function () {
    const menuSelect = $("#menu_id");
    const quantityInput = $("#quantity");
    const addMenuBtnContainer = $("#add-menu-btn-container");
    const menuContainer = $("#menu-container");

    const outletSelect = $(".outlet-order");
    const userSelect = $("#user_id");

    let menuOptions = menuSelect.html();

    // Select2 initialization
    menuSelect.select2({ theme: "bootstrap-5", width: "100%" });

    function toggleAddButton() {
        menuSelect.val() && quantityInput.val() > 0
            ? addMenuBtnContainer.removeClass("d-none")
            : addMenuBtnContainer.addClass("d-none");
    }

    if ($(".menu-select").length > 0) {
        addMenuBtnContainer.removeClass("d-none");
    }

    function updatePrice() {
        let total = 0, totalDiscount = 0;

        $(".menu-select").each(function () {
            const selectedOption = $(this).find("option:selected");
            const priceData = parseFloat(selectedOption.attr("data-price")) || 0;
            const discountData = parseFloat(selectedOption.attr("data-discount")) || 0;
            const quantity = parseInt($(this).closest(".row").find(".menu-quantity").val()) || 1;
            const price = priceData * quantity;
            const discountTotal = discountData * quantity;

            $(this).closest(".row").find(".price-input").val(price.toLocaleString("id-ID"));

            total += price;
            totalDiscount += discountTotal;
        });

        $("#discount").val(totalDiscount.toLocaleString("id-ID"));
        $("#sub_total").val(total.toLocaleString("id-ID"));
        $("#total_price").val((total - totalDiscount).toLocaleString("id-ID"));
    }

    function addMenuRow() {
        const newMenuRow = $(`
            <div class="row align-items-end mb-3">
                <div class="col-lg-8 col-md-6 col-8">
                    <div class="mb-3">
                        <label class="form-label">Menu</label>
                        <select class="form-select select2 menu-select" name="menu_id[]" required>${menuOptions}</select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-4">
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" class="form-control menu-quantity" name="quantity[]" min="1" value="1" required>
                    </div>
                </div>
                <div class="col-lg-10 col-md-6 col-10">
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control price-input" name="price[]" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-2 text-md-center text-end">
                    <div class="mb-3">
                        <button type="button" class="btn btn-transparent btn-remove-menu">
                            <i class="bi bi-x-circle-fill text-danger"></i>
                        </button>
                    </div>
                </div>
            </div>`);

        menuContainer.append(newMenuRow);
        newMenuRow.find(".select2").select2({ theme: "bootstrap-5", width: "100%" });
        newMenuRow.find(".menu-select, .menu-quantity").on("change input", updatePrice);
        newMenuRow.find(".btn-remove-menu").on("click", function () {
            $(this).closest(".row").remove();
            updatePrice();
        });

        updatePrice();
    }

    $(document).on("click", ".btn-remove-first-menu", function() {
        let parentRow = $(this).closest(".row");

        parentRow.find(".first-menu").val("").change();
        parentRow.find(".first-quantity").val("1");
        parentRow.find(".first-price").val("0");

        updatePrice();
    });

    $(document).on("click", "#add-menu-btn", function () {
        addMenuRow();
        $(".menu-select").last().val("").trigger("change");
    });

    $(document).on("click", ".btn-remove-menu", function () {
        $(this).closest(".row").remove();
        updatePrice();
    });

    // Select outlet
    outletSelect.change(function () {
        let outletId = outletSelect.val();
        let outletCode = outletSelect.find(":selected").data("code");

        if (outletId > 0 ) {
            $(".order-form").removeClass("d-none");
        }

        userSelect.html('<option value="" disabled selected>Pilih Staff</option>');
        menuSelect.html('<option value="" disabled selected>Pilih Menu</option>');

        menuContainer.empty();
        $(".menu-quantity").val("1");
        $("#price, #sub_total, #discount, #total_price").val("0");
        addMenuBtnContainer.addClass("d-none");

        // Fetch users
        $.ajax({
            url: '/get-users/' + outletCode,
            type: 'GET',
            success: function (data) {
                let options = '<option value="" disabled selected>Pilih Staff</option>';

                data.forEach(user => {
                    options += `<option value="${user.id}">${user.name}</option>`;
                });

                $("#user_id").html(options);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching users:", error);
            }
        });

        // Fetch menus
        $.ajax({
            url: '/get-menus/' + outletCode,
            type: 'GET',
            success: function (data) {
                let options = '<option value="" disabled selected>Pilih Menu</option>';

                data.forEach(menu => {
                    let finalPrice = 0;

                    if (menu.price_promo && menu.price_promo.price_promo) {
                        finalPrice = menu.price_promo.price_promo;
                    }

                    options += `<option value="${menu.id}" data-price="${menu.price}" data-discount="${finalPrice}">${menu.name}</option>`;
                });

                $("#menu_id").html(options).trigger("change");
                $("#menu_id").html(options).select2({ theme: "bootstrap-5", width: "100%" });

                menuOptions = options;
                updatePrice();
            },
            error: function (xhr, status, error) {
                console.error("Error fetching menus:", error);
            }
        });
    });

    // Selected outlet
    if (outletSelect.val()) {
        let outletCode = outletSelect.find(":selected").data("code");
        let selectedUserId = $("#selectedUserId").val();

        userSelect.html('<option value="" disabled selected>Pilih Staff</option>');
        menuSelect.html('<option value="" disabled selected>Pilih Menu</option>');

        menuContainer.empty();
        $(".menu-quantity").val("1");
        $("#price, #sub_total, #discount, #total_price").val("0");
        addMenuBtnContainer.addClass("d-none");

        // Fetch users
        $.ajax({
            url: '/get-users/' + outletCode,
            type: 'GET',
            success: function (data) {
                let options = '<option value="" disabled selected>Pilih Staff</option>';

                data.forEach(user => {
                    let isSelected = user.id == selectedUserId ? "selected" : "";
                    options += `<option value="${user.id}" ${isSelected}>${user.name}</option>`;
                });

                userSelect.html(options);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching users:", error);
            }
        });

        // Fetch menus
        $.ajax({
            url: '/get-menus/' + outletCode,
            type: 'GET',
            success: function (data) {
                $(".menu-select").each(function (index) {

                    let menuSelect = $(this);
                    let selectedMenuId = $(".selectedMenuId").eq(index).val() || "";
                    let selectedQuantity = $(".selectedQuantity").eq(index).val();

                    let options = '<option value="" disabled>Pilih Menu</option>';
                    data.forEach(menu => {
                        let finalPrice = menu.price_promo?.price_promo || 0;
                        let isSelected = (menu.id == selectedMenuId && selectedMenuId !== "") ? "selected" : "";

                        options += `<option value="${menu.id}" data-price="${menu.price}" data-discount="${finalPrice}" ${isSelected}>${menu.name}</option>`;
                    });

                    menuSelect.html(options).trigger("change");
                    menuSelect.select2({ theme: "bootstrap-5", width: "100%" });

                    menuOptions = options;

                    $(".menu-quantity").eq(index).val(selectedQuantity);
                });

                if ($(".selectedMenuId").length > 0) {
                    $("#add-menu-btn-container").removeClass("d-none");
                }

                updatePrice();
            },
            error: function (xhr, status, error) {
                console.error("Error fetching menus:", error);
            }
        });
    }

    menuSelect.on("change", toggleAddButton);
    quantityInput.on("input", toggleAddButton);

    $(document).on("change select2:select", ".menu-select", updatePrice);
    $(document).on("change input", ".menu-quantity", updatePrice);

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
