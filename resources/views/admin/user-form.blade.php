<!DOCTYPE html>
<html>
<head>
    <title>Tambah User - Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
        }
        .navbar {
            background: #dc3545;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .navbar h1 {
            font-size: 24px;
        }
        .navbar a {
            background: #0d6efd;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
        }
        .navbar a:hover {
            background: #0b5ed7;
        }
        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .page-title {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }
        .form-card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #0d6efd;
        }
        .form-group .help-text {
            font-size: 13px;
            color: #666;
            margin-top: 5px;
        }
        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        .btn-save {
            background: #198754;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-save:hover {
            background: #157347;
        }
        .btn-cancel {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
        }
        .btn-cancel:hover {
            background: #5c636a;
        }
        .error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }
        .info-box {
            background: #e7f5ff;
            border-left: 4px solid #0d6efd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .info-box p {
            color: #084298;
            font-size: 14px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>Tambah User/Staff</h1>
    <a href="{{ route('admin.users') }}">← Kembali</a>
</div>

<div class="container">
    <h2 class="page-title">Buat Akun Baru</h2>

    <div class="form-card">
        <div class="info-box">
            <p><strong>Informasi:</strong></p>
            <p>• Pilih role <strong>User</strong> untuk pelanggan biasa</p>
            <p>• Pilih role <strong>Petugas</strong> untuk staff yang mengelola pesanan</p>
            <p>• Pilih role <strong>Admin</strong> untuk akses penuh sistem</p>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="form-group">
                <label for="name">Nama Lengkap *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                <div class="help-text">Email akan digunakan untuk login</div>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" name="password" id="password" required>
                <div class="help-text">Minimal 6 karakter</div>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="role">Role *</label>
                <select name="role" id="role" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>👤 User (Pelanggan)</option>
                    <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>🛠️ Petugas (Staff)</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>👑 Admin</option>
                </select>
                @error('role')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.users') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-save">Buat Akun</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>