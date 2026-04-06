<!DOCTYPE html>
<html>
<head>
    <title>Login - Toko Ikan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #e6f4f7;
            margin: 0;
            padding: 0;
        }
        .box {
            width: 350px;
            margin: 100px auto;
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
            background: #0d6efd;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 500;
        }
        button:hover {
            background: #0b5ed7;
        }
        .register {
            text-align: center;
            margin-top: 15px;
        }
        .register a {
            color: #0d6efd;
            text-decoration: none;
        }
        .register a:hover {
            text-decoration: underline;
        }
        .error {
            color: #dc3545;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Login Toko Ikan</h2>

    @if(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    <div class="register">
        <a href="{{ url('/register') }}">Daftar Akun User</a>
    </div>
</div>

</body>
</html>