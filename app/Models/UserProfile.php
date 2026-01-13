<?php
// app/Models/UserProfile.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pricing_plan_id',
        'phone',
        'address',
        'company',
        'avatar',
        'download_count',
        'download_limit'
    ];

    protected $casts = [
        'download_count' => 'integer',
        'download_limit' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pricingPlan()
    {
        return $this->belongsTo(PricingPlan::class);
    }

    public function canDownload()
    {
        return $this->download_count < $this->download_limit;
    }

    public function incrementDownload()
    {
        $this->increment('download_count');
    }
}