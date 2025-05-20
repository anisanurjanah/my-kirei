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
            alert('Pesanan baru: #' + e.order.order_number);
        });
} else if (userRole === 'kasir' || userRole === 'produksi') {
    window.Echo.private(`orders.outlet.${outletCode}.${userRole}`)
        .listen('NewOrderEvent', e => {
            alert('Pesanan baru #' + e.order.order_number);
        });
}
