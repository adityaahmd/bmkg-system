<?php
// app/Helpers/helpers.php

if (!function_exists('format_rupiah')) {
    function format_rupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('get_cart_count')) {
    function get_cart_count()
    {
        if (auth()->check()) {
            return \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
        }
        return \App\Models\Cart::where('session_id', session()->getId())->sum('quantity');
    }
}

if (!function_exists('status_badge')) {
    function status_badge($status, $type = 'payment')
    {
        $classes = [
            'payment' => [
                'pending' => 'bg-yellow-100 text-yellow-800',
                'verified' => 'bg-green-100 text-green-800',
                'failed' => 'bg-red-100 text-red-800',
            ],
            'order' => [
                'new' => 'bg-blue-100 text-blue-800',
                'processing' => 'bg-purple-100 text-purple-800',
                'completed' => 'bg-green-100 text-green-800',
                'cancelled' => 'bg-red-100 text-red-800',
            ]
        ];
        
        $class = $classes[$type][$status] ?? 'bg-gray-100 text-gray-800';
        return "" . ucfirst($status) . "";
    }
}