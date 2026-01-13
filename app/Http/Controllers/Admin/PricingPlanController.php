<?php
// app/Http/Controllers/Admin/PricingPlanController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingPlan;
use Illuminate\Http\Request;
// Import class untuk Middleware Laravel 12
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PricingPlanController extends Controller implements HasMiddleware
{
    /**
     * Daftarkan middleware secara statis (Standar Laravel 12)
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('role:admin'),
        ];
    }

    public function index()
    {
        $plans = PricingPlan::withCount('userProfiles')->latest()->get();
        return view('admin.pricing-plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.pricing-plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_monthly' => 'nullable|numeric|min:0',
            'price_yearly' => 'nullable|numeric|min:0',
            'features' => 'required|array',
            'download_limit' => 'nullable|integer|min:0',
            'is_popular' => 'boolean',
        ]);

        PricingPlan::create($request->all());

        return redirect()->route('admin.pricing-plans.index')
            ->with('success', 'Paket berhasil ditambahkan');
    }

    public function edit(PricingPlan $pricingPlan)
    {
        return view('admin.pricing-plans.edit', compact('pricingPlan'));
    }

    public function update(Request $request, PricingPlan $pricingPlan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_monthly' => 'nullable|numeric|min:0',
            'price_yearly' => 'nullable|numeric|min:0',
            'features' => 'required|array',
            'download_limit' => 'nullable|integer|min:0',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $pricingPlan->update($request->all());

        return redirect()->route('admin.pricing-plans.index')
            ->with('success', 'Paket berhasil diperbarui');
    }

    public function destroy(PricingPlan $pricingPlan)
    {
        if ($pricingPlan->userProfiles()->count() > 0) {
            return back()->with('error', 'Paket tidak dapat dihapus karena masih digunakan oleh user');
        }

        $pricingPlan->delete();

        return redirect()->route('admin.pricing-plans.index')
            ->with('success', 'Paket berhasil dihapus');
    }
}