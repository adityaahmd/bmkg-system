<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DashboardController extends Controller implements HasMiddleware
{
    /**
     * Daftarkan middleware di sini untuk Laravel 11/12
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    /**
     * Tampilan Utama Dashboard (Ringkasan)
     */
    public function index()
    {
        $user = Auth::user();
        
        // Eager load untuk performa agar tidak query berulang kali
        $user->load('profile.pricingPlan');
        
        $stats = [
            'total_orders' => $user->orders()->count(),
            // Logika total spent: menjumlahkan total_amount dari order yang sudah dibayar/verified
            'total_spent' => $user->orders()->where('payment_status', 'verified')->sum('total_amount'),
            'downloads' => $user->downloads()->count(),
            'current_plan' => $user->profile->pricingPlan->name ?? 'GRATIS'
        ];

        $recentOrders = $user->orders()
            ->with('items')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact('user', 'stats', 'recentOrders'));
    }

    /**
     * Daftar Semua Pesanan User
     */
    public function orders()
    {
        $orders = Auth::user()->orders()
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('dashboard.orders', compact('orders'));
    }

    /**
     * Detail Pesanan (Penting: Untuk memperbaiki error Route [dashboard.orders.show])
     */
    public function showOrder(Order $order)
    {
        // Keamanan: Pastikan user hanya bisa melihat pesanan miliknya sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $order->load('items.product');

        return view('dashboard.orders.show', compact('order'));
    }

    /**
     * Daftar File yang Dapat Didownload
     */
    public function downloads()
    {
        $downloads = Auth::user()->downloads()
            ->with('product')
            ->latest()
            ->paginate(20);

        return view('dashboard.downloads', compact('downloads'));
    }

    /**
     * Tampilan Edit Profil
     */
    public function profile()
    {
        $user = Auth::user()->load('profile.pricingPlan');
        
        return view('dashboard.profile', compact('user'));
    }

    /**
     * Proses Update Profil
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'company' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048'
        ]);

        $user = Auth::user();

        // 1. Update data dasar di tabel users
        $user->update([
            'name' => $request->name
        ]);

        // 2. Siapkan data untuk tabel user_profiles
        $profileData = $request->only(['phone', 'address', 'company']);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $profileData['avatar'] = $path;
        }

        // 3. Simpan atau Update ke tabel profiles
        if ($user->profile) {
            $user->profile()->update($profileData);
        } else {
            $user->profile()->create($profileData);
        }

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}