<?php
// app/Http/Controllers/CheckoutController.php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Mail\OrderCreated; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail; // Tambahkan ini

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang Anda kosong');
        }

        $summary = $this->calculateSummary($cartItems);

        return view('checkout.index', compact('cartItems', 'summary'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'customer_address' => 'nullable|string',
            'payment_method' => 'required|in:transfer,credit_card,ewallet',
            'notes' => 'nullable|string'
        ]);

        $cartItems = $this->getCartItems();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang Anda kosong');
        }

        try {
            DB::beginTransaction();

            $summary = $this->calculateSummary($cartItems);

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'notes' => $request->notes,
                'subtotal' => $summary['subtotal'],
                'admin_fee' => $summary['adminFee'],
                'tax' => $summary['tax'],
                'total_amount' => $summary['total'],
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'order_status' => 'new'
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->product->price * $item->quantity
                ]);
            }

            // Clear cart
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();
            // Di method process(), setelah DB::commit()

DB::commit();

// TAMBAHKAN LOG DEBUGGING
\Log::info('=== CHECKOUT SUCCESS ===');
\Log::info('Order ID: ' . $order->id);
\Log::info('Order Number: ' . $order->order_number);
\Log::info('Customer Email: ' . $order->customer_email);

// KIRIM EMAIL NOTIFIKASI
try {
    \Log::info('Attempting to send email...');
    Mail::to($order->customer_email)->send(new OrderCreated($order));
    \Log::info('✅ Email sent successfully!');
} catch (\Exception $e) {
    \Log::error('❌ Failed to send email: ' . $e->getMessage());
}

return redirect()->route('checkout.success', $order)
    ->with('success', 'Pesanan berhasil dibuat. Cek email Anda untuk detail pembayaran.');

            // KIRIM EMAIL NOTIFIKASI
            try {
                Mail::to($order->customer_email)->send(new OrderCreated($order));
            } catch (\Exception $e) {
                // Log error tapi jangan stop proses
                \Log::error('Failed to send order email: ' . $e->getMessage());
            }

            return redirect()->route('checkout.success', $order)
                ->with('success', 'Pesanan berhasil dibuat. Cek email Anda untuk detail pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }

    private function getCartItems()
    {
        return Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();
    }

    private function calculateSummary($cartItems)
    {
        $subtotal = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        $adminFee = $subtotal > 0 ? 5000 : 0;
        $tax = $subtotal * 0.10;
        $total = $subtotal + $adminFee + $tax;

        return compact('subtotal', 'adminFee', 'tax', 'total');
    }
}