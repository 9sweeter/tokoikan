<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_users' => User::where('role', 'user')->count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'accepted')->sum('total'),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        $recentOrders = Order::with('user')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }

    // Products Management
    public function products()
    {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }

    public function createProduct()
    {
        return view('admin.product-form');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['nama_produk', 'harga', 'stok', 'deskripsi']);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $filename);
            $data['gambar'] = $filename;
        }

        Product::create($data);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product-form', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $data = $request->only(['nama_produk', 'harga', 'stok', 'deskripsi']);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($product->gambar && file_exists(public_path('uploads/products/' . $product->gambar))) {
                unlink(public_path('uploads/products/' . $product->gambar));
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $filename);
            $data['gambar'] = $filename;
        }

        $product->update($data);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil diupdate!');
    }

    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();
        return back()->with('success', 'Produk berhasil dihapus!');
    }

    // Users Management
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function createUser()
    {
        return view('admin.user-form');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:user,petugas,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }

    public function changeRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa mengubah role sendiri!');
        }

        $user->role = $request->role;
        $user->save();

        return back()->with('success', 'Role berhasil diubah!');
    }

    // Orders Management
    public function orders()
    {
        $orders = Order::with(['user', 'items'])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.orders', compact('orders'));
    }

    public function showOrder($id)
    {
        $order = Order::with(['user', 'items'])->findOrFail($id);
        return view('admin.order-detail', compact('order'));
    }
}