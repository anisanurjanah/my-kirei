<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ServiceWorkerController extends Controller
{
    public function index()
    {
        $manifestPath = public_path('build/manifest.json');
        if (!File::exists($manifestPath)) {
            abort(404, 'Manifest file not found');
        }

        $manifest = json_decode(File::get($manifestPath), true);

        $assets = collect($manifest)->flatMap(function ($info) {
            $files = [];

            if (isset($info['file'])) {
                $files[] = '/build/' . $info['file'];
            }

            if (isset($info['css'])) {
                foreach ($info['css'] as $cssFile) {
                    $files[] = '/build/' . $cssFile;
                }
            }

            return $files;
        })->values()->unique()->toArray();

        $staticAssets = [
            '/',
            '/manifest.json',
            '/icons/favicon.ico',
            '/icons/android-chrome-192x192.png',
            '/icons/android-chrome-512x512.png',
            '/img/carousel-1.png',
            '/img/logo-kirei-sum.jpg',
            '/img/dimsum-placeholder.jpg',
            '/img/payments/bca.png',
            '/img/payments/bni.png',
            '/img/payments/bri.png',
            '/img/payments/gopay.png',
            '/img/payments/permata_bank.png',
            '/img/payments/qris.png',
            '/img/payments/shopeepay.png',

        ];

        $menuImages = Menu::query()
            ->pluck('image')
            ->filter()
            ->unique()
            ->map(function($path) {
                if (str_starts_with($path, 'img/')) {
                    return '/' . ltrim($path, '/');
                } elseif (str_starts_with($path, 'menu-images/')) {
                    return '/storage/' . ltrim($path, '/');
                } else {
                    return '/storage/' . ltrim($path, '/');
                }
            })
            ->toArray();

        $allAssets = array_merge($staticAssets, $assets, $menuImages);

        $cacheName = 'my-kirei-cache-v1';

        return response()
            ->view('service-worker', [
                'assets' => $allAssets,
                'cacheName' => $cacheName,
            ])
            ->header('Content-Type', 'application/javascript');
    }
}
