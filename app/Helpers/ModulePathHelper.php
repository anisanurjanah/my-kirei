<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('getDashboardUrl')) {
    function getDashboardUrl(): string
    {
        $user = Auth::guard('web')->user();
        $outletCode = strtolower(optional($user->outlet)->outlet_code);

        return $user->username === 'administrator'
            ? url('/dashboard')
            : url("$outletCode/dashboard");
    }
}

if (!function_exists('getModuleBasePath')) {
    function getModuleBasePath(string $module): string
    {
        $user = Auth::guard('web')->user();
        $outletCode = strtolower(optional($user->outlet)->outlet_code);

        return $user->username === "administrator"
            ? "dashboard/{$module}"
            : "{$outletCode}/dashboard/{$module}";
    }
}

if (!function_exists('getModuleUrl')) {
    function getModuleUrl(string $module, ?string $slug = null, ?string $action = null): string
    {
        $base = getModuleBasePath($module);

        switch ($action) {
            case 'edit':
                $fullPath = $slug
                    ? rtrim($base, '/') . '/' . ltrim($slug, '/') . '/edit'
                    : $base;
                break;

            case 'create':
                $fullPath = rtrim($base, '/') . '/create';
                break;

            default:
                $fullPath = $slug ? rtrim($base, '/') . '/' . ltrim($slug, '/') : $base;
                break;
        }

        return url($fullPath);
    }
}


if (!function_exists('getModuleFormAction')) {
    function getModuleFormAction(string $module, ?string $slug = null): string
    {
        $basePath = getModuleBasePath($module);

        $fullPath = $slug
            ? rtrim($basePath, '/') . '/' . ltrim($slug, '/')
            : $basePath;

        return url($fullPath);
    }
}
