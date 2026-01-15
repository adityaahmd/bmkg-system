<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #003D82;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
        }
        .order-details {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #003D82;
        }
        .payment-info {
            background: #fff3cd;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #ffc107;
        }
        .button {
            display: inline-block;
            background: #003D82;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 12px;
            margin-top: 30px;
            border-top: 1px solid #ddd;
        }
        table {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BMKG Data Service</h1>
        <p style="margin: 0;">Terima kasih atas pesanan Anda!</p>
    </div>
    
    <div class="content">
        <p>Halo <strong>{{ $order->customer_name }}</strong>,</p>
        
        <p>Pesanan Anda telah berhasil dibuat dengan detail sebagai berikut:</p>
        
        <div class="order-details">
            <table>
                <tr>
                    <td><strong>No. Pesanan:</strong></td>
                    <td>{{ $order->order_number }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal:</strong></td>
                    <td>{{ $order->created_at->format('d M Y, H:i') }} WIB</td>
                </tr>
                <tr>
                    <td><strong>Total:</strong></td>
                    <td><strong style="color: #003D82; font-size: 18px;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                </tr>
            </table>
        </div>
        
        <h3>Item Pesanan:</h3>
        @foreach($order->items as $item)
        <div style="padding: 10px; background: white; margin: 5px 0; border-radius: 4px;">
            <strong>{{ $item->product_name }}</strong><br>
            <small>{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }} = 
            <strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong></small>
        </div>
        @endforeach
        
        @if($order->payment_method === 'transfer')
        <div class="payment-info">
            <h3>💳 Instruksi Pembayaran Transfer Bank</h3>
            <p><strong>Bank:</strong> Bank Mandiri</p>
            <p><strong>No. Rekening:</strong> 1234567890</p>
            <p><strong>Atas Nama:</strong> BMKG Data Service</p>
            <p><strong>Jumlah Transfer:</strong> <strong style="color: #003D82; font-size: 18px;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></p>
            <p style="color: #856404;"><strong>⚠️ PENTING:</strong> Transfer sesuai jumlah tertera untuk mempercepat verifikasi.</p>
        </div>
        @endif
        
        <div style="background: #e3f2fd; padding: 15px; border-left: 4px solid #2196f3; margin: 20px 0;">
            <p><strong>📌 Estimasi Verifikasi:</strong> 1-2 jam (jam kerja)</p>
            <p>Anda akan menerima email konfirmasi setelah pembayaran diverifikasi.</p>
        </div>
        
        <div style="text-align: center;">
            <a href="{{ url('/dashboard/orders') }}" class="button">Lihat Detail Pesanan</a>
        </div>
        
        <p style="margin-top: 30px;">Jika ada pertanyaan, hubungi:</p>
        <ul>
            <li>📧 Email: support@bmkg.go.id</li>
            <li>📞 Telepon: (021) 1234-5678</li>
        </ul>
    </div>
    
    <div class="footer">
        <p><strong>BMKG Data Service</strong></p>
        <p>© {{ date('Y') }} BMKG. All rights reserved.</p>
        <p style="margin-top: 10px; color: #999;">Email otomatis, jangan balas.</p>
    </div>
</body>
</html>