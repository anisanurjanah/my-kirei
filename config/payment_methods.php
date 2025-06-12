<?php

return [
    // E-Wallets
    [
        'id' => '1',
        'type' => 'E-Wallet',
        'icon' => 'Wallet',
        'method' => [
            'name' => 'GoPay',
            'icon' => 'WalletCards',
            'image' => 'img/payments/gopay.png'
        ],
        'instruction' => 'Pindai kode QR menggunakan aplikasi GoPay.',
        'details' => "1. Buka aplikasi Gojek Anda.\n2. Pilih menu 'Bayar' di halaman utama.\n3. Arahkan kamera ke QR code yang ditampilkan di layar.\n4. Pastikan nominal sudah sesuai.\n5. Klik 'Bayar' untuk menyelesaikan transaksi.\n\nTransaksi Anda akan diverifikasi secara otomatis setelah pembayaran berhasil.",
        'midtrans_config' => json_encode([
            'payment_type' => 'gopay',
        ])
    ],
    [
        'id' => '2',
        'type' => 'E-Wallet',
        'icon' => 'Wallet',
        'method' => [
            'name' => 'ShopeePay',
            'icon' => 'WalletCards',
            'image' => 'img/payments/shopeepay.png'
        ],
        'instruction' => 'Pindai kode QR menggunakan aplikasi Shopee/Shopeepay.',
        'details' => "1. Pastikan aplikasi Shopee Anda sudah terinstal dan akun ShopeePay aktif.\n2. Saat memilih metode pembayaran, pilih ShopeePay.\n3. Anda akan diarahkan ke aplikasi Shopee untuk menyelesaikan pembayaran.\n4. Konfirmasi pembayaran di aplikasi.\n\nTransaksi Anda akan diverifikasi secara otomatis setelah pembayaran berhasil.",
        'midtrans_config' => json_encode([
            'payment_type' => 'shopeepay',
        ])
    ],

    // Bank Transfer
    [
        'id' => '3',
        'type' => 'Bank Transfer',
        'icon' => 'ArrowRightLeft',
        'method' => [
            'name' => 'BCA Virtual Account',
            'icon' => 'CreditCard',
            'image' => 'img/payments/bca.png'
        ],
        'instruction' => 'Lakukan transfer ke nomor virtual akun di bawah ini.',
        'details' => "Cara bayar melalui ATM BCA:\n1. Masukkan kartu ATM dan PIN Anda.\n2. Pilih menu 'Transaksi Lainnya' > 'Transfer' > 'Ke Rek BCA Virtual Account'.\n3. Masukkan nomor Virtual Account: {virtual_account_number}.\n4. Periksa nama dan jumlah pembayaran.\n5. Konfirmasi dan selesaikan transaksi.\n\nPembayaran akan terverifikasi otomatis tanpa perlu konfirmasi manual.",
        'midtrans_config' => json_encode([
            'payment_type' => 'bank_transfer',
            'bank_transfer' => [
                'bank' => 'bca'
            ]
        ])
    ],
    [
        'id' => '4',
        'type' => 'Bank Transfer',
        'icon' => 'ArrowRightLeft',
        'method' => [
            'name' => 'BNI Virtual Account',
            'icon' => 'CreditCard',
            'image' => 'img/payments/bni.png'
        ],
        'instruction' => 'Lakukan transfer ke nomor virtual akun di bawah ini.',
        'details' => "Cara bayar melalui ATM BNI:\n1. Masukkan kartu dan PIN Anda.\n2. Pilih menu 'Menu Lain' > 'Transfer' > 'Virtual Account Billing'.\n3. Masukkan nomor Virtual Account: {virtual_account_number}.\n4. Periksa data yang muncul.\n5. Konfirmasi dan selesaikan transaksi.\n\nPembayaran akan terverifikasi otomatis.",
        'midtrans_config' => json_encode([
            'payment_type' => 'bank_transfer',
            'bank_transfer' => [
                'bank' => 'bni'
            ]
        ])
    ],
    [
        'id' => '5',
        'type' => 'Bank Transfer',
        'icon' => 'ArrowRightLeft',
        'method' => [
            'name' => 'BRI Virtual Account',
            'icon' => 'CreditCard',
            'image' => 'img/payments/bri.png'
        ],
        'instruction' => 'Lakukan transfer ke nomor virtual akun di bawah ini.',
        'details' => "Cara bayar melalui ATM BRI:\n1. Masukkan kartu dan PIN Anda.\n2. Pilih menu 'Transaksi Lain' > 'Pembayaran' > 'BRIVA'.\n3. Masukkan nomor Virtual Account: {virtual_account_number}.\n4. Periksa nama dan jumlah.\n5. Konfirmasi untuk menyelesaikan pembayaran.\n\nPembayaran akan terverifikasi otomatis.",
        'midtrans_config' => json_encode([
            'payment_type' => 'bank_transfer',
            'bank_transfer' => [
                'bank' => 'bri'
            ]
        ])
    ],
    [
        'id' => '6',
        'type' => 'Bank Transfer',
        'icon' => 'ArrowRightLeft',
        'method' => [
            'name' => 'Permata Virtual Account',
            'icon' => 'CreditCard',
            'image' => 'img/payments/permata_bank.png'
        ],
        'instruction' => 'Lakukan transfer ke nomor virtual akun di bawah ini.',
        'details' => "Cara bayar melalui ATM Bank Permata:\n1. Buka aplikasi mobile banking atau internet banking Anda.\n2. Pilih menu transfer ke rekening bank lain.\n3. Masukkan bank tujuan: Permata Bank.\n4. Masukkan nomor Virtual Accoun: {virtual_account_number}.\n5. Masukkan jumlah sesuai tagihan.\n6. Selesaikan transaksi.\n\nPastikan untuk menyelesaikan pembayaran sebelum batas waktu yang ditentukan.",
        'midtrans_config' => json_encode([
            'payment_type' => 'bank_transfer',
            'bank_transfer' => [
                'bank' => 'permata'
            ]
        ])
    ],

    // QRIS
    [
        'id' => '7',
        'type' => 'QR Code',
        'icon' => 'QrCode',
        'method' => [
            'name' => 'QRIS',
            'icon' => 'QrCode',
            'image' => 'img/payments/qris.png'
        ],
        'instruction' => 'Pindai kode QR menggunakan aplikasi yang mendukung QRIS.',
        'details' => "1. Buka aplikasi pembayaran seperti GoPay, OVO, DANA, dll.\n2. Pilih menu untuk scan QR atau bayar.\n3. Arahkan kamera ke QRIS yang ditampilkan di layar.\n4. Pastikan jumlah sesuai, lalu konfirmasi pembayaran.\n\nPembayaran Anda akan diproses secara otomatis setelah berhasil.",
        'midtrans_config' => json_encode([
            'payment_type' => 'qris'
        ])
    ],

    // Conventional
    [
        'id' => '8',
        'type' => 'Tunai',
        'icon' => 'Banknote',
        'method' => [
            'name' => 'Tunai',
            'icon' => null,
            'image' => 'img/payments/qris.png'
        ],
        'instruction' => null,
        'details' => null,
        'midtrans_config' => json_encode([
            'payment_type' => null
        ])
    ],
    [
        'id' => '9',
        'type' => 'Credit Card',
        'icon' => 'Banknote',
        'method' => [
            'name' => 'Kartu Kredit',
            'icon' => null,
            'image' => 'img/payments/qris.png'
        ],
        'instruction' => null,
        'details' => null,
        'midtrans_config' => json_encode([
            'payment_type' => null
        ])
    ],
];
