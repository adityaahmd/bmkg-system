<?php
// app/Mail/PaymentVerified.php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentVerified extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('Pembayaran Terverifikasi - Order #' . $this->order->order_number)
            ->view('emails.orders.payment-verified');
    }
}