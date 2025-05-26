<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Anisa Nurjanah">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>My Kirei | Dashboard</title>

    <link rel="icon" type="image/png" sizes="192x192" href="/icons/android-chrome-192x192.png">
    <link rel="apple-touch-icon" sizes="512x512" href="/icons/android-chrome-512x512.png">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Select2 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <!-- CSS Styling -->
    <link href="/css/dashboard-styles.css" rel="stylesheet">
    <link href="/css/dashboard.css" rel="stylesheet">
</head>
<body class="bg-light">

    @include('dashboard.layouts.header')

    <div class="container-fluid">
        <div class="row">
            @include('dashboard.layouts.sidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10">
                @yield('container')
                @include('dashboard.components.modal-delete')

                @include('dashboard.layouts.footer')
            </main>

            <div aria-live="polite" aria-atomic="true" class="position-relative">
                <div id="toastContainer" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;"></div>
            </div>
        </div>
    </div>

    <!-- Bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Select2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- JS -->
    <script src="/js/dashboard.js"></script>
    <script src="/js/main.js"></script>
    <script src="/js/order.js"></script>

    <!-- Pusher CDN -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    <!-- Laravel Echo CDN -->
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.0/dist/echo.iife.js"></script>

    <script>
        window.UserData = {
            username: "{{ auth()->user()->username ?? '' }}",
            userRole: "{{ auth()->user()->role ?? '' }}",
            outletCode: "{{ auth()->user()->outlet->outlet_code ?? '' }}"
        };

        window.PUSHER_APP_KEY = "{{ config('broadcasting.connections.pusher.key') }}";
        window.PUSHER_APP_CLUSTER = "{{ config('broadcasting.connections.pusher.options.cluster') }}";
    </script>

    <script type="module" src="/js/echo.js"></script>

    @stack('scripts')

</body>
</html>
