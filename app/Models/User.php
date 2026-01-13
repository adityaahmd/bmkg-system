<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Kolom role sudah benar masuk fillable
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Boot function untuk membuat profile otomatis
     */
    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($user) {
            $user->profile()->create([
                'download_limit' => 10
            ]);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Role Management Methods
    |--------------------------------------------------------------------------
    */

    /**
     * PERBAIKAN: Tambahkan method ini agar AuthenticatedSessionController
     * tidak lagi mengeluarkan error "Call to undefined method hasRole()"
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Method pembantu untuk cek admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function getTotalSpent()
    {
        return $this->orders()
            ->where('payment_status', 'verified')
            ->sum('total_amount');
    }
}