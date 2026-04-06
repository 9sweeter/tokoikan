<!DOCTYPE html>
<html>
<head>
    <title>Kelola User - Admin</title>
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
        .navbar .nav-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .navbar a, .navbar button {
            background: #0d6efd;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }
        .navbar a:hover {
            background: #0b5ed7;
        }
        .navbar button {
            background: #198754;
        }
        .navbar button:hover {
            background: #157347;
        }
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .page-title {
            font-size: 28px;
            color: #333;
        }
        .btn-add {
            background: #198754;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }
        .btn-add:hover {
            background: #157347;
        }
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #d1e7dd;
            color: #0f5132;
        }
        .alert-error {
            background: #f8d7da;
            color: #842029;
        }
        .users-table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            color: #333;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            color: #555;
        }
        tr:hover {
            background: #f8f9fa;
        }
        .role-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }
        .role-user {
            background: #d1e7dd;
            color: #0f5132;
        }
        .role-petugas {
            background: #cfe2ff;
            color: #084298;
        }
        .role-admin {
            background: #f8d7da;
            color: #842029;
        }
        .role-select {
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 13px;
        }
        .btn-change-role {
            background: #0d6efd;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            margin-left: 5px;
        }
        .btn-change-role:hover {
            background: #0b5ed7;
        }
        .btn-delete {
            background: #dc3545;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }
        .btn-delete:hover {
            background: #bb2d3b;
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>🐟 Kelola User</h1>
    <div class="nav-buttons">
        <a href="{{ route('admin.dashboard') }}">← Dashboard</a>
        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</div>

<div class="container">
    <div class="header">
        <h2 class="page-title">Daftar User</h2>
        <a href="{{ route('admin.users.create') }}" class="btn-add">+ Tambah User/Staff</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <div class="users-table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Ubah Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td><strong>{{ $user->id }}</strong></td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role == 'user')
                            <span class="role-badge role-user">User</span>
                        @elseif($user->role == 'petugas')
                            <span class="role-badge role-petugas">Petugas</span>
                        @else
                            <span class="role-badge role-admin">Admin</span>
                        @endif
                    </td>
                    <td>
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.role', $user->id) }}" style="display: inline-flex; align-items: center;">
                            @csrf
                            <select name="role" class="role-select">
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <button type="submit" class="btn-change-role">Ubah</button>
                        </form>
                        @else
                        <span style="color: #999; font-size: 13px;">Akun Anda</span>
                        @endif
                    </td>
                    <td>
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Hapus user ini?')">Hapus</button>
                        </form>
                        @else
                        <span style="color: #999; font-size: 13px;">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</body>
</html>