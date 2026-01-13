<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // Tambahkan ini agar tidak error di updateProfile
use Illuminate\Routing\Controllers\HasMiddleware; // Tambahkan ini
use Illuminate\Routing\Controllers\Middleware;    // Tambahkan ini

class DashboardController extends Controller implements HasMiddleware
{
    /**
     * Daftarkan middleware di sini untuk Laravel 12
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    // Hapus function __construct() lama yang menyebabkan error

    public function index()
    {
        $user = Auth::user();
        
        // Pastikan relasi profile dan pricingPlan sudah ada di model User
        $user->load('profile.pricingPlan');
        
        $stats = [
            'total_orders' => $user->orders()->count(),
            'total_spent' => method_exists($user, 'getTotalSpent') ? $user->getTotalSpent() : 0,
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

    public function orders()
    {
        $orders = Auth::user()->orders()
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('dashboard.orders', compact('orders'));
    }

    public function downloads()
    {
        $downloads = Auth::user()->downloads()
            ->with('product')
            ->latest()
            ->paginate(20);

        return view('dashboard.downloads', compact('downloads'));
    }

    public function profile()
    {
        $user = Auth::user()->load('profile.pricingPlan');
        
        return view('dashboard.profile', compact('user'));
    }

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
        $user->update([
            'name' => $request->name
        ]);

        $profileData = $request->only(['phone', 'address', 'company']);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $profileData['avatar'] = $path;
        }

        // Gunakan updateOrCreate jika takut profile belum ada di DB
        $user->profile()->update($profileData);

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}