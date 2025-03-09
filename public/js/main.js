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
});
