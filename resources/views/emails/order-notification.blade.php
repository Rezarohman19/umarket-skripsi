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
            <h1>U-Market Notification</h1>
        </div>
        <div class="content">
            <h2>{{ $isPaid ? 'PESANAN TELAH DIBAYAR! 🚀' : 'ADA PESANAN BARU! 🛍️' }}</h2>
            <p>Halo <strong>{{ $seller->name }}</strong>,</p>
            <p>{{ $isPaid ? 'Pesanan berikut telah berhasil dibayar oleh pembeli dan siap diproses.' : 'Seseorang baru saja memesan produk Anda! Pesanan saat ini menunggu pembayaran.' }}</p>
            <hr>
            <p><strong>No. Pesanan:</strong> #{{ $transaction->order_id }}</p>
            <p><strong>Total Pembayaran:</strong> Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
            <p><strong>Status:</strong> {{ $isPaid ? 'SUDAH DIBAYAR ✅' : 'MENUNGGU PEMBAYARAN ⏳' }}</p>
            <hr>
            <p>Silakan pantau dan kelola pesanan Anda melalui dashboard seller U-Market.</p>
            <p style="text-align: center;">
                <a href="{{ config('app.url') }}/open-shop" class="button">Buka Dashboard Seller</a>
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} U-Market. All rights reserved.
        </div>
    </div>
</body>
</html>
