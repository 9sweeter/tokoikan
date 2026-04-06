<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin - Toko Ikan</title>
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
        .navbar .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .navbar button {
            background: #0d6efd;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        .navbar button:hover {
            background: #0b5ed7;
        }
        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .page-title {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            border-left: 4px solid;
        }
        .stat-card.products { border-color: #0d6efd; }
        .stat-card.users { border-color: #198754; }
        .stat-card.orders { border-color: #ffc107; }
        .stat-card.revenue { border-color: #dc3545; }
        .stat-card h3 {
            font-size: 36px;
            margin-bottom: 10px;
        }
        .stat-card.products h3 { color: #0d6efd; }
        .stat-card.users h3 { color: #198754; }
        .stat-card.orders h3 { color: #ffc107; }
        .stat-card.revenue h3 { color: #dc3545; }
        .stat-card p {
            color: #666;
            font-size: 14px;
        }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .menu-card {
            background: white;
            border: 2px solid #dee2e6;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .menu-card:hover {
            border-color: #dc3545;
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,.1);
        }
        .menu-card .icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        .menu-card h3 {
            color: #333;
            margin-bottom: 10px;
        }
        .menu-card p {
            color: #666;
            font-size: 14px;
        }
        .recent-orders {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .recent-orders h3 {
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #dee2e6;
        }
        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .order-info {
            flex: 1;
        }
        .order-id {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        .order-customer {
            color: #666;
            font-size: 14px;
        }
        .order-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-accepted {
            background: #d1e7dd;
            color: #0f5132;
        }
        .status-cancelled {
            background: #f8d7da;
            color: #842029;
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>Dashboard Admin</h1>
    <div class="user-info">
        <span>Admin: <strong>{{ Auth::user()->name }}</strong></span>
        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</div>

<div class="container">
    <h2 class="page-title">Selamat Datang, Admin!</h2>

    <div class="stats">
        <div class="stat-card products">
            <h3>{{ $stats['total_products'] }}</h3>
            <p>Total Produk</p>
        </div>
        <div class="stat-card users">
            <h3>{{ $stats['total_users'] }}</h3>
            <p>Total Pelanggan</p>
        </div>
        <div class="stat-card orders">
            <h3>{{ $stats['total_orders'] }}</h3>
            <p>Total Pesanan</p>
            <small style="color: #ffc107;">{{ $stats['pending_orders'] }} pending</small>
        </div>
        <div class="stat-card revenue">
            <h3>Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
            <p>Total Pendapatan</p>
        </div>
    </div>

    <div class="menu-grid">
        <a href="{{ route('admin.products') }}" class="menu-card">
            <div class="icon"></div>
            <h3>Kelola Produk</h3>
            <p>Tambah, edit, hapus produk ikan</p>
        </a>
        <a href="{{ route('admin.users') }}" class="menu-card">
            <div class="icon"></div>
            <h3>Kelola User</h3>
            <p>Manajemen akun pelanggan & petugas</p>
        </a>
        <a href="{{ route('admin.orders') }}" class="menu-card">
            <div class="icon"></div>
            <h3>Kelola Pesanan</h3>
            <p>Monitor semua pesanan pelanggan</p>
        </a>
    </div>

    <div class="recent-orders">
        <h3>Pesanan Terbaru</h3>
        @forelse($recentOrders as $order)
        <div class="order-item">
            <div class="order-info">
                <div class="order-id">Pesanan #{{ $order->id }}</div>
                <div class="order-customer">{{ $order->user->name }} - Rp {{ number_format($order->total, 0, ',', '.') }}</div>
            </div>
            <div>
                @if($order->status == 'pending')
                    <span class="order-status status-pending">Pending</span>
                @elseif($order->status == 'accepted')
                    <span class="order-status status-accepted">Diterima</span>
                @else
                    <span class="order-status status-cancelled">Dibatalkan</span>
                @endif
            </div>
        </div>
        @empty
        <p style="text-align: center; color: #666; padding: 20px;">Belum ada pesanan</p>
        @endforelse
    </div>
</div>

</body>
</html>