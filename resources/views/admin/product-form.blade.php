<!DOCTYPE html>
<html>
<head>
    <title>{{ isset($product) ? 'Edit' : 'Tambah' }} Produk - Admin</title>
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
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #0d6efd;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
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
    </style>
</head>
<body>

<div class="navbar">
    <h1>🐟 {{ isset($product) ? 'Edit' : 'Tambah' }} Produk</h1>
    <a href="{{ route('admin.products') }}">← Kembali</a>
</div>

<div class="container">
    <h2 class="page-title">{{ isset($product) ? 'Edit Produk' : 'Tambah Produk Baru' }}</h2>

    <div class="form-card">
        <form method="POST" action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="nama_produk">Nama Produk *</label>
                <input type="text" name="nama_produk" id="nama_produk" 
                       value="{{ old('nama_produk', $product->nama_produk ?? '') }}" required>
                @error('nama_produk')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="gambar">Foto Produk</label>
                @if(isset($product) && $product->gambar)
                    <div style="margin-bottom: 10px;">
                        <img src="{{ asset('uploads/products/' . $product->gambar) }}" alt="Current Image" style="max-width: 200px; border-radius: 8px; border: 1px solid #ddd;">
                        <p style="font-size: 12px; color: #666; margin-top: 5px;">Gambar saat ini</p>
                    </div>
                @endif
                <input type="file" name="gambar" id="gambar" accept="image/*">
                <div style="font-size: 12px; color: #666; margin-top: 5px;">
                    Upload foto ikan (JPG, PNG, max 2MB). Kosongkan jika tidak ingin mengubah.
                </div>
                @error('gambar')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="harga">Harga (Rp) *</label>
                <input type="number" name="harga" id="harga" 
                       value="{{ old('harga', $product->harga ?? '') }}" required min="0">
                @error('harga')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="stok">Stok *</label>
                <input type="number" name="stok" id="stok" 
                       value="{{ old('stok', $product->stok ?? '') }}" required min="0">
                @error('stok')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" 
                          placeholder="Deskripsi produk (opsional)">{{ old('deskripsi', $product->deskripsi ?? '') }}</textarea>
                @error('deskripsi')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.products') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-save">{{ isset($product) ? 'Update' : 'Simpan' }}</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>