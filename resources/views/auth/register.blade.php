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

            <!-- Debug error nggak bisa register -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{route('register')}}">
                @csrf
                <div class="mb-3">
                    <label>Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter your name">
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" placeholder="email@example.com">
                </div>

                <div class="mb-3">
                    <label>Phone Number</label>
                    <input type="text" name="phone" class="form-control" placeholder="Enter your phone number">
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Create password">
                    
                    <!-- syarat password -->
                    <small class="mt-2 d-block">
                        <div id="length" class="text-danger">✖ Minimal 8 karakter</div>
                        <div id="uppercase" class="text-danger">✖ Mengandung huruf besar</div>
                        <div id="lowercase" class="text-danger">✖ Mengandung huruf kecil</div>
                        <div id="number" class="text-danger">✖ Mengandung angka</div>
                    </small>
                </div>

                


                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Repeat password">
                    <small id="passwordMatchMessage" class="text-danger d-none">
                        Password tidak cocok
                    </small>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">
                    Register
                </button>
                
            </form>

            <hr>

            <p class="text-center mb-0">
                Sudah punya akun?
                <a href="{{ route('login') }}">Login</a>
            </p>

        </div>
    </div>


    <!-- script  -->
    <script>
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');
        const message = document.getElementById('passwordMatchMessage');

        // checkPasswordMatch
        function checkPasswordMatch() {

            if(confirmPassword.value === ''){
                message.classList.add('d-none');
                return;
            }

            if(password.value === confirmPassword.value){
                message.classList.remove('d-none');
                message.className = 'text-success';
                message.innerHTML = '✔ Password cocok';
            } else {
                message.classList.remove('d-none');
                message.className = 'text-danger';
                message.innerHTML = '✖ Password tidak cocok';
            }
        }

        password.addEventListener('keyup', checkPasswordMatch);
        confirmPassword.addEventListener('keyup', checkPasswordMatch);

        // Password validation
        document.getElementById('password').addEventListener('keyup', function() {

            let password = this.value;

            // Minimal 8 karakter
            if(password.length >= 8){
                document.getElementById('length').className = 'text-success';
                document.getElementById('length').innerHTML = '✔ Minimal 8 karakter';
            } else {
                document.getElementById('length').className = 'text-danger';
                document.getElementById('length').innerHTML = '✖ Minimal 8 karakter';
            }

            // Huruf besar
            if(/[A-Z]/.test(password)){
                document.getElementById('uppercase').className = 'text-success';
                document.getElementById('uppercase').innerHTML = '✔ Mengandung huruf besar';
            } else {
                document.getElementById('uppercase').className = 'text-danger';
                document.getElementById('uppercase').innerHTML = '✖ Mengandung huruf besar';
            }

            // Huruf kecil
            if(/[a-z]/.test(password)){
                document.getElementById('lowercase').className = 'text-success';
                document.getElementById('lowercase').innerHTML = '✔ Mengandung huruf kecil';
            } else {
                document.getElementById('lowercase').className = 'text-danger';
                document.getElementById('lowercase').innerHTML = '✖ Mengandung huruf kecil';
            }

            // Angka
            if(/[0-9]/.test(password)){
                document.getElementById('number').className = 'text-success';
                document.getElementById('number').innerHTML = '✔ Mengandung angka';
            } else {
                document.getElementById('number').className = 'text-danger';
                document.getElementById('number').innerHTML = '✖ Mengandung angka';
            }

        });
    </script>
</body>

</html>