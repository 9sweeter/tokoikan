<!DOCTYPE html>
<html>
<head>
    <title>Status Pemesanan - Toko Ikan</title>
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
            background: #0d6efd;
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
            background: #198754;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }
        .navbar a:hover {
            background: #157347;
        }
        .navbar button {
            background: #dc3545;
        }
        .navbar button:hover {
            background: #bb2d3b;
        }
        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .page-title {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
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
        .orders-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .order-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #dee2e6;
        }
        .order-id {
            font-weight: bold;
            color: #333;
            font-size: 18px;
        }
        .order-date {
            color: #666;
            font-size: 14px;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
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
        .order-items {
            margin-bottom: 15px;
        }
        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            color: #555;
        }
        .order-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #dee2e6;
        }
        .order-total {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
        .order-address {
            margin-top: 10px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 4px;
            color: #555;
            font-size: 14px;
        }
        .empty-orders {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 8px;
        }
        .empty-orders p {
            color: #666;
            font-size: 18px;
            margin-bottom: 20px;
        }
        .empty-orders a {
            display: inline-block;
            padding: 10px 20px;
            background: #0d6efd;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>🐟 Toko Ikan</h1>
    <div class="nav-buttons">
        <a href="{{ route('user.home') }}">🏠 Home</a>
        <a href="{{ route('user.cart') }}">🛒 Keranjang</a>
        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</div>

<div class="container">
    <h2 class="page-title">📋 Status Pemesanan</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($orders->isEmpty())
        <div class="empty-orders">
            <p>Anda belum memiliki pesanan</p>
            <a href="{{ route('user.home') }}">Mulai Belanja</a>
        </div>
    @else
        <div class="orders-list">
            @foreach($orders as $order)
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <div class="order-id">Pesanan #{{ $order->id }}</div>
                        <div class="order-date">{{ $order->created_at }}</div>
                    </div>
                    <div>
                        @if($order->status == 'pending')
                            <span class="status-badge status-pending">⏳ Pending</span>
                        @elseif($order->status == 'accepted')
                            <span class="status-badge status-accepted">✅ Diterima</span>
                        @else
                            <span class="status-badge status-cancelled">❌ Dibatalkan</span>
                        @endif
                    </div>
                </div>

                <div class="order-items">
                    <strong>Item Pesanan:</strong>
                    @foreach($order->items as $item)
                    <div class="order-item">
                        <span>{{ $item->nama_produk }} (x{{ $item->qty }})</span>
                        <span>Rp {{ number_format($item->harga * $item->qty, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="order-address">
                    <strong>Alamat Pengiriman:</strong><br>
                    {{ $order->alamat }}
                </div>

                @if($order->bukti_pembayaran)
                <div style="margin-top: 15px; padding: 10px; background: #f8f9fa; border-radius: 4px;">
                    <strong style="color: #333;">Bukti Pembayaran:</strong><br>
                    <a href="{{ asset('uploads/bukti_pembayaran/' . $order->bukti_pembayaran) }}" target="_blank" style="color: #0d6efd; text-decoration: none;">
                        📄 Lihat Bukti Transfer
                    </a>
                </div>
                @endif

                <div class="order-footer">
                    <div class="order-total">
                        Total: Rp {{ number_format($order->total, 0, ',', '.') }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

</body>
</html>