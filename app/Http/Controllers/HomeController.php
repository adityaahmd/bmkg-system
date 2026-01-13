<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman beranda dengan desain klasik.
     */
    public function index(): View
    {
        // Mengambil kategori yang aktif beserta jumlah produk yang sudah dipublikasi
        // Ini mengatasi error 'active_products_count' yang sebelumnya muncul
        $categories = Category::where('is_active', true)
            ->withCount('activeProducts')
            ->get();
        
        // Mengambil produk unggulan (rating >= 4.5) 
        // Wajib menggunakan with('category') agar icon/nama kategori muncul di desain klasik
        $featuredProducts = Product::with('category')
            ->where('status', 'published')
            ->where('rating', '>=', 4.5)
            ->latest() // Menampilkan yang terbaru terlebih dahulu
            ->take(6)
            ->get();

        return view('home', compact('categories', 'featuredProducts'));
    }

    /**
     * Fitur pencarian dataset.
     */
    public function search(Request $request): View
    {
        $query = $request->input('q');
        
        // Pencarian yang dioptimalkan dengan eager loading kategori
        $products = Product::with('category')
            ->where('status', 'published')
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhereHas('category', function($catQuery) use ($query) {
                      $catQuery->where('name', 'like', "%{$query}%");
                  });
            })
            ->paginate(12)
            ->withQueryString(); // Menjaga parameter pencarian saat pindah halaman (pagination)

        return view('products.search', compact('products', 'query'));
    }
}