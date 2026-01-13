<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #003D82;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            background: #f9f9f9;
            padding: 20px;
            margin: 20px 0;
        }
        .order-details {
            background: white;
            padding: 15px;
            margin: 15px 0;
            border-left: 4px solid #003D82;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 12px;
        }
        .btn {
            display: inline-block;
            background: #003D82;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>BMKG Data Service</h1>
        </div>
        
        <div class="content">
            <h2>Terima kasih atas pesanan Anda!</h2>
            <p>Halo {{ $order->customer_name }},</p>
            <p>Pesanan Anda telah berhasil dibuat. Berikut detail pesanan Anda:</p>
            
            <div class="order-details">
                <table style="width: 100%;">
                    <tr>
                        <td><strong>No. Pesanan:</strong></td>
                        <td>{{ $order->order_number }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal:</strong></td>
                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total:</strong></td>
                        <td><strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Metode Pembayaran:</strong></td>
                        <td>{{ ucfirst($order->payment_method) }}</td>
                    </tr>
                </table>
            </div>
            
            <h3>Item Pesanan:</h3>
            @foreach($order->items as $item)
            <div style="padding: 10px; background: white; margin: 5px 0;">
                <strong>{{ $item->product_name }}</strong><br>
                {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }} = 
                <strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
            </div>
            @endforeach
            
            @if($order->payment_method === 'transfer')
            <div style="background: #fff3cd; padding: 15px; margin: 20px 0; border-left: 4px solid #ffc107;">
                <h4>Instruksi Pembayaran Transfer Bank</h4>
                <p>
                    <strong>Bank:</strong> Bank Mandiri<br>
                    <strong>No. Rekening:</strong> 1234567890<br>
                    <strong>Atas Nama:</strong> BMKG Data Service<br>
                    <strong>Jumlah Transfer:</strong> <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                </p>
                <p style="color: #856404;">
                    <strong>Penting:</strong> Harap transfer sesuai jumlah yang tertera untuk mempermudah verifikasi.
                </p>
            </div>
            @endif
            
            <p style="text-align: center;">
                <a href="{{ route('dashboard.orders') }}" class="btn">Lihat Detail Pesanan</a>
            </p>
            
            <p>Jika Anda memiliki pertanyaan, silakan hubungi kami di <a href="mailto:support@bmkg.go.id">support@bmkg.go.id</a></p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} BMKG Data Service. All rights reserved.</p>
            <p>Email ini dikirim otomatis, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
