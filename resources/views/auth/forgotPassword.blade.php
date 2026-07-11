<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - VitaGuard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="width: 380px;">
            <h3 class="text-center mb-1 fw-bold text-primary">VitaGuard</h3>
            <p class="text-center text-muted mb-4">Reset Your Password</p>

            <form method="POST" action="{{ route('password.update.direct') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Account</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           placeholder="Masukkan email terdaftar" required value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password Baru --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">New Password</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Masukkan password baru" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Confirm New Password</label>
                    <input type="password" name="password_confirmation"
                           class="form-control" placeholder="Ulangi password baru" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold mt-2">
                    Reset Password
                </button>
            </form>

            <hr class="my-4">

            <p class="text-center mb-0 small">
                Sudah ingat password?
                <a href="{{ route('login') }}" class="fw-bold text-primary text-decoration-none">Kembali ke Login</a>
            </p>

        </div>
    </div>

</body>

</html>
