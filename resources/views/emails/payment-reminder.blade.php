<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; }
        .header { background-color: #EF3B33; color: white; padding: 10px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { padding: 20px; }
        .footer { font-size: 12px; color: #777; margin-top: 20px; text-align: center; }
        .button { background-color: #EF3B33; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>U-Market Payment Reminder</h1>
        </div>
        <div class="content">
            <h2>Hampir Habis Waktunya! ⏰</h2>
            <p>Halo <strong>{{ $transaction->shipping_name }}</strong>,</p>
            <p>Kami ingin menginformasikan bahwa pesanan Anda akan segera berakhir waktu pembayarannya dalam <strong>{{ $timeLabel }}</strong> lagi.</p>
            <hr>
            <p><strong>No. Pesanan:</strong> #{{ $transaction->order_id }}</p>
            <p><strong>Total Pembayaran:</strong> Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
            <hr>
            <p>Segera lakukan pembayaran agar pesanan Anda tidak dibatalkan secara otomatis oleh sistem.</p>
            <p style="text-align: center;">
                <a href="{{ config('app.url') }}/orders" class="button" style="color: white;">Bayar Sekarang</a>
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} U-Market. All rights reserved.
        </div>
    </div>
</body>
</html>
