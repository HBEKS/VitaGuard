<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - VitaGuard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="width: 380px;">
            <h3 class="text-center mb-1 fw-bold text-primary">VitaGuard</h3>
            <p class="text-center text-muted mb-4">Login to your account</p>

            {{-- Alert pesan sukses jika user baru selesai reset password --}}
            @if (session('status'))
                <div class="alert alert-success mt-2 mb-3 small">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email" required value="{{ old('email') }}">
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="form-label fw-semibold">Password</label>

                        <a href="{{ route('password.request') }}" class="text-decoration-none small text-primary">
                            Forgot Password?
                        </a>
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold mt-2">
                    Login
                </button>
            </form>

            @if ($errors->any())
                <div class="alert alert-danger mt-3 small">
                    {{ $errors->first() }}
                </div>
            @endif

            <hr class="my-4">

            <p class="text-center mb-0 small">
                Belum punya akun?
                <a href="{{ route('register') }}" class="fw-bold text-primary text-decoration-none">Register</a>
            </p>

        </div>
    </div>

</body>

</html>
