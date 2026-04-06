<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // Show home page with products
    public function home()
    {
        $products = Product::all();
        return view('user.home', compact('products'));
    }

    // Add to cart
    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);

        if (!$product) {
            return back()->with('error', 'Produk tidak ditemukan!');
        }

        // Check if product already in cart
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('nama_produk', $product->nama_produk)
            ->first();

        if ($cartItem) {
            // Update quantity
            $cartItem->qty += $request->qty ?? 1;
            $cartItem->save();
        } else {
            // Create new cart item
            Cart::create([
                'user_id' => Auth::id(),
                'nama_produk' => $product->nama_produk,
                'harga' => $product->harga,
                'qty' => $request->qty ?? 1,
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // Show cart
    public function cart()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $total = $cartItems->sum(function($item) {
            return $item->harga * $item->qty;
        });

        return view('user.cart', compact('cartItems', 'total'));
    }

    // Update cart quantity
    public function updateCart(Request $request, $id)
    {
        $cartItem = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($cartItem) {
            $cartItem->qty = $request->qty;
            $cartItem->save();
        }

        return back()->with('success', 'Keranjang diupdate!');
    }

    // Remove from cart
    public function removeFromCart($id)
    {
        Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success', 'Produk dihapus dari keranjang!');
    }

    // Checkout
    public function checkout(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang kosong!');
        }

        $total = $cartItems->sum(function($item) {
            return $item->harga * $item->qty;
        });

        // Handle file upload
        $buktiPembayaran = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/bukti_pembayaran'), $filename);
            $buktiPembayaran = $filename;
        }

        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'status' => 'pending',
            'alamat' => $request->alamat,
            'bukti_pembayaran' => $buktiPembayaran,
            'created_at' => now(),
        ]);

        // Create order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'nama_produk' => $item->nama_produk,
                'harga' => $item->harga,
                'qty' => $item->qty,
            ]);
        }

        // Clear cart
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('user.orders')->with('success', 'Pesanan berhasil dibuat! Menunggu konfirmasi dari petugas.');
    }

    // Show orders (status pemesanan)
    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return view('user.orders', compact('orders'));
    }
}