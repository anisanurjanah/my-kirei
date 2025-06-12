<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>My Kirei | {{ $title }}</title>

    <link rel="icon" type="image/png" sizes="192x192" href="/icons/android-chrome-192x192.png">
    <link rel="apple-touch-icon" sizes="512x512" href="/icons/android-chrome-512x512.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom styles for this template -->
    <link href="/css/dashboard-styles.css" rel="stylesheet">
</head>
<body>

    <div class="container-fluid">
        <div class="row signin">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session()->has('loginError'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('loginError') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="col-md-4 custom-border">
                <div class="d-flex justify-content-center align-items-center" style="height: 270px;">
                    <img src="/img/logo-kirei-sum.jpg" class="img-fluid h-100" alt="Logo Kirei Sum">
                </div>
            </div>

            <div class="col-md-4 py-3 px-4 custom-border">
                <main class="form-signin">
                    <h1 class="h3 mb-4 fw-bold text-center">My<span style="color: #C60E2A">Kirei</span></h1>

                    <form action="/login" method="post">
                        @csrf
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope-at-fill"></i></span>
                            <div class="form-floating">
                                <input type="email" name="email" class="form-control @error('email') is-invalid
                                @enderror" id="email" autofocus required value="{{ old('email') }}">
                                <label for="email">Email</label>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <div class="form-floating">
                                <input type="password" name="password" class="form-control" id="password" required>
                                <label for="password">Password</label>
                            </div>
                        </div>

                        <button class="btn btn-danger fw-bold w-100 mt-4 py-2" type="submit">Login</button>
                    </form>
                </main>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
