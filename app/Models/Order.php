<?php
// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'notes',
        'subtotal',
        'admin_fee',
        'tax',
        'total_amount',
        'payment_method',
        'payment_status',
        'order_status',
        'paid_at'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'admin_fee' => 'decimal:2',
        'tax' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function isPaid()
    {
        return $this->payment_status === 'verified';
    }

    public function markAsPaid()
    {
        $this->update([
            'payment_status' => 'verified',
            'paid_at' => now()
        ]);
    }
}