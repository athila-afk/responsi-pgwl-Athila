<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GeoRanah Minang</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: #55768C;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-box {
            background: white;
            padding: 40px;
            border-radius: 12px;
            width: 380px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .login-box h2 {
            text-align: center;
            color: #B83556;
            margin-bottom: 8px;
            font-size: 22px;
        }
        .login-box p {
            text-align: center;
            color: #888;
            font-size: 13px;
            margin-bottom: 25px;
        }
        .form-group { margin-bottom: 15px; }
        .form-group label {
            display: block;
            font-size: 13px;
            color: #555;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }
        .form-group input:focus { outline: none; border-color: #B83556; }
        .btn-login {
            width: 100%;
            padding: 12px;
            background: #B83556;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            margin-top: 5px;
        }
        .btn-login:hover { background: #962943; }
        .error {
            background: #fbebed;
            color: #B83556;
            padding: 10px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 15px;
            text-align: center;
        }
        .logo { text-align: center; font-size: 48px; margin-bottom: 15px; }
        .register-link {
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
            color: #888;
        }
        .register-link a { color: #B83556; font-weight: bold; text-decoration: none; }
        .register-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="logo"></div>
        <h2>GeoRanah Minang</h2>
        <p>Silahkan masukkan akun mu!</p>

        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="/login">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Masukkan email"
                    value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn-login">Login</button>
        </form>

        <div class="register-link">
            Belum punya akun? <a href="/register">Daftar di sini</a>
        </div>
    </div>
</body>
</html>
