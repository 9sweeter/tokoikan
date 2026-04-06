<!DOCTYPE html>
<html>
<head>
    <title>Keranjang - Toko Ikan</title>
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
        .cart-table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            margin-bottom: 20px;
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
        }
        td {
            padding: 15px;
            border-top: 1px solid #dee2e6;
        }
        .qty-input {
            width: 60px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
        }
        .btn-update {
            background: #0d6efd;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }
        .btn-update:hover {
            background: #0b5ed7;
        }
        .btn-remove {
            background: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }
        .btn-remove:hover {
            background: #bb2d3b;
        }
        .cart-summary {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .cart-summary h3 {
            color: #333;
            margin-bottom: 15px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .checkout-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
            resize: vertical;
        }
        .btn-checkout {
            width: 100%;
            padding: 12px;
            background: #198754;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        .btn-checkout:hover {
            background: #157347;
        }
        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 8px;
        }
        .empty-cart p {
            color: #666;
            font-size: 18px;
            margin-bottom: 20px;
        }
        .empty-cart a {
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
        <a href="{{ route('user.orders') }}">📋 Status</a>
        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</div>

<div class="container">
    <h2 class="page-title">🛒 Keranjang Belanja</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($cartItems->isEmpty())
        <div class="empty-cart">
            <p>Keranjang Anda masih kosong</p>
            <a href="{{ route('user.home') }}">Mulai Belanja</a>
        </div>
    @else
        <div class="cart-table">
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item->nama_produk }}</td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.update', $item->id) }}" style="display: inline-flex; gap: 5px;">
                                @csrf
                                <input type="number" name="qty" value="{{ $item->qty }}" min="1" class="qty-input">
                                <button type="submit" class="btn-update">Update</button>
                            </form>
                        </td>
                        <td>Rp {{ number_format($item->harga * $item->qty, 0, ',', '.') }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.remove', $item->id) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-remove" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="cart-summary">
            <h3>Informasi Pembayaran</h3>
            
            <div style="background: #e7f5ff; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #0d6efd;">
                <h4 style="color: #0d6efd; margin-bottom: 10px;">🏦 Rekening Toko Ikan</h4>
                <div style="font-size: 16px; color: #333; margin-bottom: 5px;">
                    <strong>Bank:</strong> BCA
                </div>
                <div style="font-size: 16px; color: #333; margin-bottom: 5px;">
                    <strong>No. Rekening:</strong> 1234567890
                </div>
                <div style="font-size: 16px; color: #333;">
                    <strong>Atas Nama:</strong> Toko Ikan Sejahtera
                </div>
            </div>

            <div class="total-row">
                <span>Total Pembayaran:</span>
                <span style="color: #dc3545;">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <form method="POST" action="{{ route('user.checkout') }}" class="checkout-form" enctype="multipart/form-data">
                @csrf
                
                <label for="alamat" style="display: block; margin-bottom: 5px; font-weight: bold; color: #333;">Alamat Pengiriman:</label>
                <textarea name="alamat" id="alamat" rows="3" required placeholder="Masukkan alamat lengkap Anda..."></textarea>

                <label for="bukti_pembayaran" style="display: block; margin-bottom: 5px; font-weight: bold; color: #333;">Upload Bukti Pembayaran:</label>
                <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" accept="image/*" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-bottom: 15px;">
                <div style="font-size: 12px; color: #666; margin-bottom: 15px;">
                    * Upload foto struk/bukti transfer (Format: JPG, PNG. Max: 2MB)
                </div>

                <button type="submit" class="btn-checkout">Kirim Pesanan</button>
            </form>
        </div>
    @endif
</div>

</body>
</html>