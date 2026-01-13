<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductController extends Controller implements HasMiddleware
{
    /**
     * Definisi Middleware untuk proteksi Admin
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('role:admin'),
        ];
    }

    /**
     * Menampilkan daftar produk dengan filter
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Filter Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter Kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(10);
        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Form tambah produk
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name', 'asc')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Simpan produk baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'type' => 'required|in:gratis,premium',
            'status' => 'required|in:draft,published,archived',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'product_file' => 'nullable|mimes:zip,pdf,docx,rar|max:20480', // Max 20MB
        ]);

        $data = $request->except(['image', 'product_file']);
        $data['slug'] = Str::slug($request->name) . '-' . Str::lower(Str::random(5));

        // Upload Gambar Thumbnail
        if ($request->hasFile('image')) {
            // Simpan ke folder public/products (agar mudah dipanggil Storage::url)
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Upload File Produk (jika ada)
        if ($request->hasFile('product_file')) {
            $data['file_path'] = $request->file('product_file')->store('products/files', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Form edit produk
     */
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->orderBy('name', 'asc')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update data produk
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'type' => 'required|in:gratis,premium',
            'status' => 'required|in:draft,published,archived',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'product_file' => 'nullable|mimes:zip,pdf,docx,rar|max:20480',
        ]);

        $data = $request->except(['image', 'product_file']);

        // Update Slug jika nama berubah
        if ($product->name !== $request->name) {
            $data['slug'] = Str::slug($request->name) . '-' . Str::lower(Str::random(5));
        }

        // Update Gambar
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Update File
        if ($request->hasFile('product_file')) {
            if ($product->file_path) {
                Storage::disk('public')->delete($product->file_path);
            }
            $data['file_path'] = $request->file('product_file')->store('products/files', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk dan file terkait
     */
    public function destroy(Product $product)
    {
        // Hapus file fisik dari storage agar tidak memenuhi server
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        if ($product->file_path) {
            Storage::disk('public')->delete($product->file_path);
        }
        
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}