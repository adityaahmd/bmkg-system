<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang belanja
     */
    public function index()
    {
        $cartItems = $this->getCartItems();
        $summary = $this->calculateSummary($cartItems);

        return view('cart.index', compact('cartItems', 'summary'));
    }

    /**
     * Menyimpan produk ke keranjang (Sesuai dengan route('cart.store') dan fetch JS)
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        // Karena kita sudah memindahkan route ke dalam middleware auth di web.php,
        // kita bisa langsung menggunakan Auth::id()
        $userId = Auth::id();

        // Cari apakah produk sudah ada di keranjang user
        $cart = Cart::where('user_id', $userId)
                    ->where('product_id', $request->product_id)
                    ->first();

        if ($cart) {
            // Jika ada, update quantity
            $cart->update([
                'quantity' => $cart->quantity + $request->quantity
            ]);
        } else {
            // Jika tidak ada, buat baru
            Cart::create([
                'user_id' => $userId,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'cart_count' => $this->getCartCount()
        ]);
    }

    /**
     * Update kuantitas (Sesuai dengan updateQuantity di JS)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::where('user_id', Auth::id())->findOrFail($id);
        
        $cart->update([
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kuantitas berhasil diperbarui'
        ]);
    }

    /**
     * Menghapus satu item (Sesuai dengan removeItem di JS)
     */
    public function remove($id)
    {
        $cart = Cart::where('user_id', Auth::id())->findOrFail($id);
        $cart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk dihapus dari keranjang'
        ]);
    }

    /**
     * Mengosongkan seluruh keranjang
     */
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Keranjang berhasil dikosongkan');
    }

    /**
     * Helper: Ambil data item keranjang
     */
    private function getCartItems()
    {
        return Cart::where('user_id', Auth::id())
            ->with('product.category')
            ->get();
    }

    /**
     * Helper: Hitung jumlah total barang di keranjang (untuk badge)
     */
    public function getCount()
    {
        return response()->json([
            'count' => $this->getCartCount()
        ]);
    }

    private function getCartCount()
    {
        return Cart::where('user_id', Auth::id())->sum('quantity');
    }

    /**
     * Helper: Hitung ringkasan pembayaran
     */
    private function calculateSummary($cartItems)
    {
        $subtotal = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        // Logika Biaya: Gratis jika tidak ada barang
        $adminFee = $subtotal > 0 ? 5000 : 0;
        $tax = $subtotal * 0.11; // PPN 11% sesuai regulasi terbaru
        $total = $subtotal + $adminFee + $tax;

        return [
            'subtotal' => $subtotal,
            'adminFee' => $adminFee,
            'tax' => $tax,
            'total' => $total
        ];
    }
}