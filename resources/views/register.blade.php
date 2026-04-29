<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - VitaGuard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="width: 400px;">

            <!-- Title -->
            <h3 class="text-center mb-1 fw-bold">VitaGuard</h3>
            <p class="text-center text-muted mb-4">Create your account</p>

            <!-- Dummy Form -->
            <form>
                <div class="mb-3">
                    <label>Full Name</label>
                    <input type="text" class="form-control" placeholder="Enter your name">
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" placeholder="email@example.com">
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" class="form-control" placeholder="Create password">
                </div>

                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" placeholder="Repeat password">
                </div>
                <a href="{{ route('dashboard') }}" class="btn btn-primary w-100">
                    Register
                </a>
            </form>

            <hr>

            <p class="text-center mb-0">
                Sudah punya akun?
                <a href="{{ route('login') }}">Login</a>
            </p>

        </div>
    </div>

</body>

</html>