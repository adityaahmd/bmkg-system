<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'type',
        'file_path',
        'image',
        'status',
        'rating',
        'views'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'rating' => 'decimal:2',
        'views' => 'integer',
        'status' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . Str::random(5);
            }
        });
    }

    /**
     * Relasi ke Kategori
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke Order Items
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relasi ke Riwayat Download
     */
    public function downloads(): HasMany
    {
        return $this->hasMany(Download::class);
    }

    /**
     * Scope untuk produk yang sudah dipublikasi
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Cek apakah produk gratis
     */
    public function isFree(): bool
    {
        return $this->type === 'gratis' || $this->price <= 0;
    }

    /**
     * Format harga Rupiah yang elegan untuk desain klasik
     */
    public function formattedPrice(): string
    {
        if ($this->isFree()) {
            return 'Akses Gratis';
        }
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Mendapatkan URL gambar atau placeholder
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        // Placeholder minimalis untuk desain klasik
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }
}