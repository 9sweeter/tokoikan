<!DOCTYPE html>
<html>
<head>
    <title>Detail Pesanan #{{ $order->id }} - Toko Ikan</title>
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
        .order-card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            margin-bottom: 20px;
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #dee2e6;
            margin-bottom: 20px;
        }
        .order-id {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .status-badge {
            padding: 8px 16px;
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
        .info-section {
            margin-bottom: 25px;
        }
        .info-section h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 18px;
            border-left: 4px solid #198754;
            padding-left: 10px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        .info-item {
            padding: 10px;
            background: #f8f9fa;
            border-radius: 4px;
        }
        .info-item label {
            display: block;
            font-weight: bold;
            color: #666;
            font-size: 13px;
            margin-bottom: 5px;
        }
        .info-item .value {
            color: #333;
            font-size: 15px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th {
            background: #f8f9fa;
            padding: 12px;
            text-align: left;
            color: #333;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }
        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #dee2e6;
            color: #555;
        }
        .total-section {
            text-align: right;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .total-section .total-label {
            font-size: 18px;
            color: #666;
        }
        .total-section .total-amount {
            font-size: 28px;
            font-weight: bold;
            color: #dc3545;
            margin-top: 5px;
        }
        .payment-proof {
            padding: 20px;
            background: #e7f5ff;
            border-radius: 8px;
            border: 2px solid #0d6efd;
            margin-bottom: 20px;
        }
        .payment-proof h3 {
            color: #0d6efd;
            margin-bottom: 15px;
        }
        .payment-proof img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            border: 1px solid #ddd;
            cursor: pointer;
        }
        .payment-proof img:hover {
            opacity: 0.9;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        .btn-accept {
            background: #198754;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        .btn-accept:hover {
            background: #157347;
        }
        .btn-cancel {
            background: #dc3545;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        .btn-cancel:hover {
            background: #bb2d3b;
        }
        .btn-accept:disabled, .btn-cancel:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>🐟 Detail Pesanan</h1>
    <div class="nav-buttons">
        <a href="{{ route('petugas.dashboard') }}">← Kembali ke Dashboard</a>
        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</div>

<div class="container">
    <div class="page-title">Pesanan #{{ $order->id }}</div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="order-card">
        <div class="order-header">
            <div class="order-id">Pesanan #{{ $order->id }}</div>
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

        <div class="info-section">
            <h3>👤 Informasi Pelanggan</h3>
            <div class="info-grid">
                <div class="info-item">
                    <label>Nama</label>
                    <div class="value">{{ $order->user->name }}</div>
                </div>
                <div class="info-item">
                    <label>Email</label>
                    <div class="value">{{ $order->user->email }}</div>
                </div>
                <div class="info-item" style="grid-column: 1 / -1;">
                    <label>Alamat Pengiriman</label>
                    <div class="value">{{ $order->alamat }}</div>
                </div>
                <div class="info-item">
                    <label>Tanggal Pesanan</label>
                    <div class="value">{{ $order->created_at }}</div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h3>🛒 Item Pesanan</h3>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->nama_produk }}</td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>{{ $item->qty }}</td>
                        <td><strong>Rp {{ number_format($item->harga * $item->qty, 0, ',', '.') }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total-section">
                <div class="total-label">Total Pembayaran:</div>
                <div class="total-amount">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
            </div>
        </div>

        @if($order->bukti_pembayaran)
        <div class="info-section">
            <div class="payment-proof">
                <h3>💳 Bukti Pembayaran</h3>
                <img src="{{ asset('uploads/bukti_pembayaran/' . $order->bukti_pembayaran) }}" 
                     alt="Bukti Pembayaran" 
                     onclick="window.open(this.src, '_blank')">
                <p style="margin-top: 10px; color: #666; font-size: 13px;">
                    <i>Klik gambar untuk memperbesar</i>
                </p>
            </div>
        </div>
        @endif

        @if($order->status == 'pending')
        <div class="action-buttons">
            <form method="POST" action="{{ route('petugas.order.accept', $order->id) }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn-accept" onclick="return confirm('Terima pesanan ini?')">
                    ✅ Terima Pesanan
                </button>
            </form>
            <form method="POST" action="{{ route('petugas.order.cancel', $order->id) }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn-cancel" onclick="return confirm('Batalkan pesanan ini?')">
                    ❌ Batalkan Pesanan
                </button>
            </form>
        </div>
        @else
        <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 4px; color: #666;">
            Pesanan ini sudah diproses ({{ ucfirst($order->status) }})
        </div>
        @endif
    </div>
</div>

</body>
</html>