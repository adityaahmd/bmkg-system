<h2>Halo {{ $order->customer_name }},</h2>
<p>Terima kasih telah melakukan pemesanan di BMKG Data Service.</p>
<p>Nomor Pesanan: <strong>{{ $order->order_number }}</strong></p>
<p>Total Tagihan: <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></p>
<p>Status: Menunggu Pembayaran</p>
<p>Silakan lakukan pembayaran agar data dapat segera kami proses.</p>