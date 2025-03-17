<?php

namespace App\Helpers;

use Carbon\Carbon;

class MenuHelper
{
    public static function isPromoActive($menu)
    {
        return $menu->price_promo && Carbon::now()->between($menu->price_promo->promo_start_date, $menu->price_promo->promo_end_date);
    }
}
