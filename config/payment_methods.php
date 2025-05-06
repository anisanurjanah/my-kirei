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
        ],
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
        ],
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
        ],
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
        ],
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
        ],
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
        ],
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
        ],
        'midtrans_config' => json_encode([
            'payment_type' => 'qris'
        ])
    ],
];
