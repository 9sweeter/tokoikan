<!DOCTYPE html>
<html>
<head>
    <title>Register - Toko Ikan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #e6f4f7;
            margin: 0;
            padding: 0;
        }
        .box {
            width: 350px;
            margin: 80px auto;
            padding: 25px;
            background: #fff;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input:focus {
            outline: none;
            border-color: #0d6efd;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #198754;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 500;
        }
        button:hover {
            background: #157347;
        }
        .login {
            text-align: center;
            margin-top: 15px;
        }
        .login a {
            color: #0d6efd;
            text-decoration: none;
        }
        .login a:hover {
            text-decoration: underline;
        }
        .error {
            color: #dc3545;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Daftar Akun User</h2>

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ url('/register') }}">
        @csrf
        <label>Nama</label>
        <input type="text" name="name" value="{{ old('name') }}" required>

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation" required>

        <button type="submit">Daftar</button>
    </form>

    <div class="login">
        Sudah punya akun? <a href="{{ url('/login') }}">Login disini</a>
    </div>
</div>

</body>
</html>