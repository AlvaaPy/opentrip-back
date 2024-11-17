<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permata Wisata - Login</title>
    <link rel="icon" href="{{ asset('examples/assets/img/permata-wisata.png') }}" />

    <!-- Fonts and icons -->
    <link rel="stylesheet" href="{{ asset('examples/assets/css/fonts.min.css') }}">
    <link rel="stylesheet" href="{{ asset('examples/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('examples/assets/css/atlantis.min.css') }}">

    <!-- Custom CSS for Login Page -->
    <style>
        body {
            background: linear-gradient(135deg, #1e90ff, #4b6cb7);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Lato', sans-serif;
        }

        .login-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
        }

        .login-header h2 {
            color: #1e90ff;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-control {
            border-radius: 20px;
            font-size: 16px;
        }

        .btn-login {
            background-color: #1e90ff;
            border: none;
            color: white;
            border-radius: 20px;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            cursor: pointer;
        }

        .btn-login:hover {
            background-color: #4b6cb7;
        }

        .text-center a {
            color: #1e90ff;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="login-container">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <div class="login-header">
            <img src="{{ asset('examples/assets/img/permata-wisata.png') }}" alt="Permata Wisata Logo" style="width: 60px; height: auto; display: block; margin: 0 auto;">
            <h2>Admin Login</h2>
        </div>

        <form id="loginForm" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control" name="credential" placeholder="Email or Username" required autofocus>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-login">Login</button>
        </form>

        <script>
             document.getElementById('loginForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                const form = e.target;
                const formData = new FormData(form);

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': form._token.value,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            credential: formData.get('credential'),
                            password: formData.get('password')
                        })
                    });

                    if (!response.ok) {
                        const errorData = await response.json(); // Ambil pesan error spesifik dari JSON
                        throw new Error(errorData.message || 'Login failed'); // Tampilkan pesan dari server jika ada
                    }

                    const data = await response.json();

                    // Menyimpan token dan informasi pengguna di local storage
                    localStorage.setItem('adminToken', data.token);
                    localStorage.setItem('adminUsername', data.username); // Simpan username
                    localStorage.setItem('adminName', data.name); // Simpan nama lengkap
                    localStorage.setItem('adminEmail', data.email); // Simpan nama lengkap

                    // Menampilkan pesan keberhasilan login
                    alert(data.message);

                    // Redirect ke halaman dashboard setelah login
                    window.location.href = "{{ route('dashboard') }}";

                } catch (error) {
                    // Tampilkan pesan error spesifik dari server
                    alert(`Error: ${error.message}`);
                }
            });
        </script>

    </div>

    <!-- Core JS Files -->
    <script src="{{ asset('examples/assets/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('examples/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('examples/assets/js/core/bootstrap.min.js') }}"></script>
</body>

</html>