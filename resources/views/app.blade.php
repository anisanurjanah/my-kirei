<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="manifest" href="/manifest.json">
        <link rel="icon" type="image/png" sizes="192x192" href="/icons/android-chrome-192x192.png">
        <link rel="apple-touch-icon" sizes="512x512" href="/icons/android-chrome-512x512.png">

        {{-- @viteReactRefresh
        @vite('resources/css/app.css')
        @vite('resources/js/app.jsx') --}}
        <link rel="stylesheet" href="{{ secure_asset('build/assets/app-DdREcQg8.css') }}">
        @inertiaHead
    </head>
<body>
    @inertia
    <script type="module" src="{{ secure_asset('build/assets/app-q23V4CQ3.js') }}"></script>
</body>
</html>
