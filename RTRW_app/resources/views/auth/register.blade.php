<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - WebGIS Tata Ruang</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: #55768C;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-box {
            background: white;
            padding: 40px;
            border-radius: 12px;
            width: 380px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .logo { text-align: center; font-size: 48px; margin-bottom: 15px; }
        h2 { text-align: center; color: #B83556; margin-bottom: 8px; font-size: 22px; }
        p { text-align: center; color: #888; font-size: 13px; margin-bottom: 25px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 13px; color: #555; margin-bottom: 5px; }
        .form-group input {
            width: 100%; padding: 10px 12px;
            border: 1px solid #ddd; border-radius: 6px; font-size: 14px;
        }
        .form-group input:focus { outline: none; border-color: #B83556; }
        .btn-register {
            width: 100%; padding: 12px;
            background: #B83556; color: white;
            border: none; border-radius: 6px;
            font-size: 15px; cursor: pointer; margin-top: 5px;
        }
        .btn-register:hover { background: #962943; }
        .error {
            background: #fbebed; color: #B83556;
            padding: 10px; border-radius: 6px;
            font-size: 13px; margin-bottom: 15px; text-align: center;
        }
        .login-link {
            text-align: center; margin-top: 15px; font-size: 13px; color: #888;
        }
        .login-link a { color: #B83556; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="register-box">
        <div class="logo"></div>
        <h2>Daftar Akun</h2>
        <p>GeoRanah Minang</p>

        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="/register">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" placeholder="Masukkan nama lengkap"
                    value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Masukkan email"
                    value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Minimal 8 karakter" required>
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password" required>
            </div>
            <button type="submit" class="btn-register">📝 Daftar</button>
        </form>

        <div class="login-link">
            Sudah punya akun? <a href="/login">Login di sini</a>
        </div>
    </div>
</body>
</html>
