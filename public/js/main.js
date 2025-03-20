$(document).ready(function () {

    // Selected outlet in menu and user
    $("#outlet_id").change(function () {
        let outletId = $("#outlet_id").val();

        if (outletId > 0 ) {
            $(".row-form").removeClass("d-none");
        }
    });

    // Price format in modals
    $('.modal').on('shown.bs.modal', function () {
        let priceInput = $(this).find("#price_promo");

        priceInput.off("input").on("input", function () {
            formatPrice($(this));
        });
    });

    // Set price format
    $("#price, #price_promo, #sub_total, #discount, #total_price").each(function () {
        formatPrice($(this));
    });

    setupDeleteModals()
    setupPhoneFormatting();
    setupPromoVisibility();
    setupSelect2();

    previewImage();
    $("#image").on("change", previewImage);

});

// Price format
function formatPrice(input) {
    input.on("input", function () {
        let value = $(this).val().replace(/\./g, "").replace(/\D/g, "");
        $(this).val(value ? parseInt(value, 10).toLocaleString("id-ID") : "");
    });
}

// Delete modals
function setupDeleteModals() {
    $('.modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var actionType = button.data('action');
        var itemName = button.data('bs-name');
        var itemUrl = button.data('bs-url');

        $('#modalItemName').text(itemName || "Nama Tidak Ditemukan");
        $('#modalForm').attr('action', itemUrl || "#");

        if (actionType === 'delete') {
            $('#modalTitle').text("Konfirmasi Hapus");
            $('#modalMessage').text("Apakah kamu yakin ingin menghapus ");
            $('#modalSubmitButton').removeClass().addClass('btn btn-danger');
        } else if (actionType === 'reset') {
            $('#modalTitle').text("Konfirmasi Hapus Stok");
            $('#modalMessage').text("Apakah kamu yakin ingin menghapus stok pada menu ");
            $('#modalSubmitButton').removeClass().addClass('btn btn-danger');
        }
    });
}

// Phone number formatting
function setupPhoneFormatting() {
    const phoneInput = document.getElementById("phone");
    if (phoneInput) {
        phoneInput.removeEventListener("input", formatPhone);
        phoneInput.addEventListener("input", formatPhone);
    }
}

function formatPhone() {
    let value = this.value.replace(/\D/g, "");
    if (value.startsWith("0")) value = value.substring(1);
    value = value.replace(/^(\d{3})(\d{4})?(\d{4})?/, (match, p1, p2, p3) => {
        return [p1, p2, p3].filter(Boolean).join("-");
    });
    this.value = value;
}

// Image preview
function previewImage() {
    const image = document.querySelector("#image");
    const imgPreview = document.querySelector(".img-preview");

    if (!image || !imgPreview) return;

    if (image.files.length > 0) {
        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);
        oFReader.onload = function (oFREvent) {
            imgPreview.style.display = "block";
            imgPreview.src = oFREvent.target.result;
        };
    }
}

// Menu promotion
function setupPromoVisibility() {
    var $pricePromoInput = $("#price_promo");
    var $promoDates = $("#promo_dates");
    var $startDate = $("#promo_start_date");
    var $endDate = $("#promo_end_date");

    function togglePromoDates() {
        var pricePromoValue = $pricePromoInput.val().replace(/\./g, '') || "0";
        var isPromoActive = pricePromoValue !== "0";

        $promoDates.toggleClass("d-none", !isPromoActive);

        if (isPromoActive) {
            $startDate.attr("required", "required");
            $endDate.attr("required", "required");
        } else {
            $startDate.removeAttr("required");
            $endDate.removeAttr("required");
        }
    }

    if ($pricePromoInput.length) {
        togglePromoDates();
        $pricePromoInput.on("input", togglePromoDates);
    }
}

// Select2
function setupSelect2() {
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });
}
