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
