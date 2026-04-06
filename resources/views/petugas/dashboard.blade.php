<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Petugas - Toko Ikan</title>
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
            background: #198754;
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
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        .navbar button:hover {
            background: #bb2d3b;
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
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            text-align: center;
        }
        .stat-card h3 {
            font-size: 36px;
            margin-bottom: 10px;
        }
        .stat-card.pending h3 { color: #ffc107; }
        .stat-card.accepted h3 { color: #198754; }
        .stat-card.cancelled h3 { color: #dc3545; }
        .stat-card.total h3 { color: #0d6efd; }
        .stat-card p {
            color: #666;
            font-size: 14px;
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
        .orders-table {
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
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            display: inline-block;
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
        .btn-detail {
            background: #0d6efd;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 13px;
            display: inline-block;
        }
        .btn-detail:hover {
            background: #0b5ed7;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>🐟 Dashboard Petugas</h1>
    <div class="user-info">
        <span>Petugas: <strong>{{ Auth::user()->name }}</strong></span>
        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</div>

<div class="container">
    <h2 class="page-title">📋 Manajemen Pesanan</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="stats">
        <div class="stat-card pending">
            <h3>{{ $stats['pending'] }}</h3>
            <p>Pesanan Pending</p>
        </div>
        <div class="stat-card accepted">
            <h3>{{ $stats['accepted'] }}</h3>
            <p>Pesanan Diterima</p>
        </div>
        <div class="stat-card cancelled">
            <h3>{{ $stats['cancelled'] }}</h3>
            <p>Pesanan Dibatalkan</p>
        </div>
        <div class="stat-card total">
            <h3>{{ $stats['total'] }}</h3>
            <p>Total Pesanan</p>
        </div>
    </div>

    <div class="orders-table">
        @if($orders->isEmpty())
            <div class="empty-state">
                <p>Belum ada pesanan masuk</p>
            </div>
        @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td><strong>#{{ $order->id }}</strong></td>
                    <td>{{ $order->created_at }}</td>
                    <td>{{ $order->user->name }}<br><small style="color: #999;">{{ $order->user->email }}</small></td>
                    <td><strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></td>
                    <td>
                        @if($order->status == 'pending')
                            <span class="status-badge status-pending">⏳ Pending</span>
                        @elseif($order->status == 'accepted')
                            <span class="status-badge status-accepted">✅ Diterima</span>
                        @else
                            <span class="status-badge status-cancelled">❌ Dibatalkan</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('petugas.order', $order->id) }}" class="btn-detail">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

</body>
</html>