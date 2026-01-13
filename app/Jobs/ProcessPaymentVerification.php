<?php
// app/Jobs/ProcessPaymentVerification.php

namespace App\Jobs;

use App\Mail\PaymentVerified;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessPaymentVerification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle()
    {
        // Update order status
        $this->order->update([
            'payment_status' => 'verified',
            'order_status' => 'processing',
            'paid_at' => now()
        ]);

        // Send confirmation email
        Mail::to($this->order->customer_email)
            ->send(new PaymentVerified($this->order));

        // Create download records for purchased products
        foreach ($this->order->items as $item) {
            $this->order->user->downloads()->create([
                'product_id' => $item->product_id,
                'order_id' => $this->order->id,
                'file_name' => $item->product->name,
                'file_path' => $item->product->file_path,
                'downloaded_at' => now()
            ]);
        }
    }
}