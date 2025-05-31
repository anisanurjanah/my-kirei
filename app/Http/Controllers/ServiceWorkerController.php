<?php

namespace App\Http\Controllers;

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

        $assets = [];
        foreach ($manifest as $file => $info) {
            if (isset($info['file'])) {
                $assets[] = '/build/' . $info['file'];
            }

            if (isset($info['css'])) {
                foreach ($info['css'] as $cssFile) {
                    $assets[] = '/build/' . $cssFile;
                }
            }
        }

        $staticAssets = [
            '/',
            '/manifest.json',
            '/icons/favicon.ico',
            '/icons/android-chrome-192x192.png',
            '/icons/android-chrome-512x512.png',
            "/build/assets/app-CPqo74Jr.js",
            "/build/assets/app-BUrPCSVk.css"
        ];

        $allAssets = array_merge($staticAssets, $assets);

        $cacheName = 'my-kirei-cache-v' . now()->format('YmdHis');

        return response()
            ->view('service-worker', [
                'assets' => $allAssets,
                'cacheName' => $cacheName,
            ])
            ->header('Content-Type', 'application/javascript');
    }
}
