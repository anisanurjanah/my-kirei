<!doctype html>
<html lang="en" data-bs-theme="auto">
<head><script src="../assets/js/color-modes.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>My Kirei | Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom styles for this template -->
    <link href="/css/dashboard-styles.css" rel="stylesheet">
</head>
<body>

    <div class="container-fluid">
        <div class="row signin">

            <div class="col-md-4 custom-border">
                <div class="d-flex justify-content-center align-items-center" style="height: 335px; overflow: hidden;">
                    <img src="/img/logo-kirei-sum.jpg" class="img-fluid h-100" alt="Logo Kirei Sum">
                </div>
            </div>

            <div class="col-md-5 p-5 custom-border">
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

                <main class="form-signin">
                    <a href="/" class="text-decoration-none text-black">
                        <h1 class="h3 mb-4 fw-bold text-center">My<span style="color: #C60E2A">Kirei</span></h1>
                    </a>
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
