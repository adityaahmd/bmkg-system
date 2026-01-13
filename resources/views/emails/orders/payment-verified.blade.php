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
            background: #28a745;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            background: #f9f9f9;
            padding: 20px;
            margin: 20px 0;
        }
        .success-icon {
            text-align: center;
            font-size: 64px;
            color: #28a745;
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
            <h1>Pembayaran Berhasil!</h1>
        </div>
        
        <div class="content">
            <div class="success-icon">✓</div>
            
            <h2 style="text-align: center;">Pembayaran Anda Telah Terverifikasi</h2>
            
            <p>Halo {{ $order->customer_name }},</p>
            <p>Kami informasikan bahwa pembayaran untuk pesanan <strong>{{ $order->order_number }}</strong> telah berhasil diverifikasi.</p>
            
            <p>Anda sekarang dapat mengakses dan mendownload data yang telah Anda beli melalui dashboard Anda.</p>
            
            <p style="text-align: center;">
                <a href="{{ route('dashboard.downloads') }}" class="btn">Download Data Saya</a>
            </p>
            
            <p>Terima kasih telah menggunakan layanan BMKG Data Service!</p>
        </div>
    </div>
</body>
</html>