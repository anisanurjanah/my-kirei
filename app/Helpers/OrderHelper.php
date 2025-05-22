<?php
namespace App\Helpers;

class OrderHelper
{
    public static function badgeOrderType($type)
    {
        $classes = [
            'Dine In' => 'primary',
            'Take Away' => 'info',
        ];

        $class = $classes[$type] ?? 'secondary';
        return '<span class="badge text-bg-' . $class . '">' . e($type) . '</span>';
    }

    public static function badgeOrderStatus($status)
    {
        $classes = [
            'Ditunda' => 'warning',
            'Selesai' => 'success',
            'Dibatalkan' => 'danger',
            'Dalam Proses' => 'info',
        ];

        $class = $classes[$status] ?? 'secondary';
        return '<span class="badge text-bg-' . $class . '">' . e($status) . '</span>';
    }

    public static function badgePaymentStatus($status)
    {
        $classes = [
            'Kadaluarsa' => 'warning',
            'Lunas' => 'success',
            'Gagal' => 'danger',
            'Ditunda' => 'info',
        ];

        $class = $classes[$status] ?? 'secondary';
        return '<span class="badge text-bg-' . $class . '">' . e($status) . '</span>';
    }
}
