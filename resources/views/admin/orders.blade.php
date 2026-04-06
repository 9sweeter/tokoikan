<!DOCTYPE html>
<html>
<head>
    <title>Kelola Pesanan - Admin</title>
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
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .page-title {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
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
    </style>
</head>
<body>

<div class="navbar">
    <h1>Kelola Pesanan</h1>
    <div class="nav-buttons">
        <a href="{{ route('admin.dashboard') }}">← Dashboard</a>
        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</div>

<div class="container">
    <h2 class="page-title">Semua Pesanan</h2>

    <div class="orders-table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><strong>#{{ $order->id }}</strong></td>
                    <td>{{ $order->created_at }}</td>
                    <td>
                        {{ $order->user->name }}<br>
                        <small style="color: #999;">{{ $order->user->email }}</small>
                    </td>
                    <td>
                        @foreach($order->items as $item)
                            {{ $item->nama_produk }} ({{ $item->qty }}x)<br>
                        @endforeach
                    </td>
                    <td><strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></td>
                    <td>
                        @if($order->status == 'pending')
                            <span class="status-badge status-pending">Pending</span>
                        @elseif($order->status == 'accepted')
                            <span class="status-badge status-accepted">Diterima</span>
                        @else
                            <span class="status-badge status-cancelled">Dibatalkan</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.order.detail', $order->id) }}" class="btn-detail">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #666;">
                        Belum ada pesanan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>