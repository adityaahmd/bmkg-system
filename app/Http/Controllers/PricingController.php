<?php
// app/Http/Controllers/PricingController.php

namespace App\Http\Controllers;

use App\Models\PricingPlan;

class PricingController extends Controller
{
    public function index()
    {
        $plans = PricingPlan::where('is_active', true)
            ->orderBy('price_monthly', 'asc')
            ->get();

        return view('pricing.index', compact('plans'));
    }
}