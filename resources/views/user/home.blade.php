<!DOCTYPE html>
<html>
<head>
    <title>Home - Toko Ikan</title>
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
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .banner {
            background: linear-gradient(135deg, #20c997 0%, #0d6efd 100%);
            color: white;
            padding: 40px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 30px;
        }
        .banner h2 {
            font-size: 32px;
            margin-bottom: 10px;
        }
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }
        .products-section h3 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        .product-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,.1);
            transition: transform 0.3s;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,.15);
        }
        .product-image {
            width: 100%;
            height: 200px;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
            overflow: hidden;
        }
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .product-info {
            padding: 15px;
        }
        .product-info h4 {
            color: #333;
            margin-bottom: 10px;
            font-size: 18px;
        }
        .product-info .price {
            color: #0d6efd;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .product-info .stock {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .product-info button {
            width: 100%;
            padding: 10px;
            background: #0d6efd;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .product-info button:hover {
            background: #0b5ed7;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
        }
        .modal-content {
            background: white;
            margin: 50px auto;
            padding: 0;
            width: 90%;
            max-width: 600px;
            border-radius: 8px;
            position: relative;
        }
        .modal-header {
            padding: 20px;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-header h3 {
            margin: 0;
            color: #333;
        }
        .close {
            font-size: 28px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
            border: none;
            background: none;
        }
        .close:hover {
            color: #000;
        }
        .modal-body {
            padding: 20px;
        }
        .modal-product-image {
            width: 100%;
            height: 300px;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 100px;
            border-radius: 4px;
            margin-bottom: 20px;
            overflow: hidden;
        }
        .modal-product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .modal-product-info {
            margin-bottom: 20px;
        }
        .modal-product-info h4 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }
        .modal-product-info .price {
            font-size: 28px;
            color: #0d6efd;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .modal-product-info .stock {
            color: #666;
            margin-bottom: 15px;
        }
        .modal-product-info .description {
            color: #555;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .qty-selector {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .qty-selector label {
            font-weight: bold;
            color: #333;
        }
        .qty-selector input {
            width: 80px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
        }
        .modal-add-to-cart {
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
        .modal-add-to-cart:hover {
            background: #157347;
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>🐟 Toko Ikan</h1>
    <div class="nav-buttons">
        <span style="color: white; margin-right: 10px;">Halo, <strong>{{ Auth::user()->name }}</strong></span>
        <a href="{{ route('user.cart') }}">🛒 Keranjang</a>
        <a href="{{ route('user.orders') }}">📋 Status</a>
        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</div>

<div class="container">
    <div class="banner">
        <h2>🐠 Fresh Seafood Ikan Pilihan 🐟</h2>
        <p>Ikan segar berkualitas tinggi langsung dari nelayan terpercaya</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="products-section">
        <h3>Produk Terbaik</h3>
        <div class="products-grid">
            @forelse($products as $product)
            <div class="product-card">
                <div class="product-image">
                    @if($product->gambar)
                        <img src="{{ asset('uploads/products/' . $product->gambar) }}" alt="{{ $product->nama_produk }}">
                    @else
                        🐟
                    @endif
                </div>
                <div class="product-info">
                    <h4>{{ $product->nama_produk }}</h4>
                    <div class="price">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                    <div class="stock">Stok: {{ $product->stok }}</div>
                    <button onclick="showModal({{ $product->id }}, '{{ $product->nama_produk }}', {{ $product->harga }}, {{ $product->stok }}, '{{ $product->deskripsi }}', '{{ $product->gambar }}')">Detail</button>
                </div>
            </div>
            @empty
            <p>Belum ada produk.</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal -->
<div id="productModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle"></h3>
            <button class="close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="modal-product-image" id="modalImageContainer">🐟</div>
            <div class="modal-product-info">
                <h4 id="modalProductName"></h4>
                <div class="price" id="modalPrice"></div>
                <div class="stock" id="modalStock"></div>
                <div class="description" id="modalDescription"></div>

                <form method="POST" action="{{ route('cart.add') }}">
                    @csrf
                    <input type="hidden" name="product_id" id="modalProductId">
                    <div class="qty-selector">
                        <label>Jumlah:</label>
                        <input type="number" name="qty" value="1" min="1" id="modalQty">
                    </div>
                    <button type="submit" class="modal-add-to-cart">🛒 Tambah ke Keranjang</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showModal(id, name, price, stock, description, image) {
    document.getElementById('productModal').style.display = 'block';
    document.getElementById('modalTitle').textContent = name;
    document.getElementById('modalProductName').textContent = name;
    document.getElementById('modalPrice').textContent = 'Rp ' + price.toLocaleString('id-ID');
    document.getElementById('modalStock').textContent = 'Stok: ' + stock;
    document.getElementById('modalDescription').textContent = description || 'Ikan segar berkualitas tinggi.';
    document.getElementById('modalProductId').value = id;
    document.getElementById('modalQty').max = stock;
    
    // Update image
    const imageContainer = document.getElementById('modalImageContainer');
    if (image) {
        imageContainer.innerHTML = '<img src="/uploads/products/' + image + '" alt="' + name + '">';
    } else {
        imageContainer.innerHTML = '🐟';
    }
}

function closeModal() {
    document.getElementById('productModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('productModal');
    if (event.target == modal) {
        closeModal();
    }
}
</script>

</body>
</html>