<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::routes(['middleware' => ['web', 'auth']]);

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('orders.administrator', function ($user) {
    return $user->username === 'administrator';
});

Broadcast::channel('orders.outlet.{outlet_code}.kasir', function ($user, $outlet_code) {
    return $user->role === 'kasir' && $user->outlet && $user->outlet->outlet_code === $outlet_code;
});

Broadcast::channel('orders.outlet.{outlet_code}.produksi', function ($user, $outlet_code) {
    return $user->role === 'produksi' && $user->outlet && $user->outlet->outlet_code === $outlet_code;
});
