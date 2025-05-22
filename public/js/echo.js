const { username, userRole, outletCode } = window.UserData;

const csrfMeta = document.querySelector('meta[name="csrf-token"]');
const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: window.PUSHER_APP_KEY,
    cluster: window.PUSHER_APP_CLUSTER,
    forceTLS: true,
    encrypted: true,
    auth: {
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    }
});

if (username === 'administrator') {
    window.Echo.private('orders.administrator')
        .listen('NewOrderEvent', e => {
            // alert('Pesanan baru: #' + e.order.order_number);
            showToastAndReload('Nomor pesanan: #' + e.order.order_number);
        });
} else if (userRole === 'kasir' || userRole === 'produksi') {
    window.Echo.private(`orders.outlet.${outletCode}.${userRole}`)
        .listen('NewOrderEvent', e => {
            showToastAndReload('Nomor pesanan: #' + e.order.order_number);
        });
}

function showToast(message, title = 'Pesanan baru diterima!', time = 'baru saja') {
    const toastId = 'toast-' + Date.now();
    const toastHTML = `
        <div id="${toastId}" class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="../icons/favicon-16x16.png" class="rounded me-2" alt="icon">
                <strong class="me-auto">${title}</strong>
                <small class="text-body-secondary">${time}</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    const container = document.getElementById('toastContainer');
    container.insertAdjacentHTML('beforeend', toastHTML);

    const toastEl = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastEl, { delay: 10000 });
    toast.show();

    toastEl.addEventListener('hidden.bs.toast', () => {
        toastEl.remove();
    });
}

function showToastAndReload(message) {
    showToast(message);
    setTimeout(() => {
        window.location.reload();
    }, 10000);
}
