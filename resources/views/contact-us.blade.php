<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Kami - UMarket</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: linear-gradient(135deg, #FDA1A2/10 0%, #1D1842 100%);
            background-attachment: fixed;
            color: #374151;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 60px;
        }
        .header h1 {
            font-size: 2.5rem;
            background: linear-gradient(135deg, #8E0D3C, #EF3B33);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
            font-weight: 700;
        }
        .header p {
            color: #6b7280;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }
        .content-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: start;
        }
        @media (max-width: 768px) {
            .content-wrapper {
                grid-template-columns: 1fr;
            }
        }
        .contact-info {
            background-color: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(142, 13, 60, 0.15);
            border: 2px solid #FDA1A2/20;
        }
        .contact-info h2 {
            font-size: 1.5rem;
            color: #1D1842;
            margin-bottom: 30px;
            border-bottom: 3px solid #EF3B33;
            padding-bottom: 15px;
        }
        .info-item {
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 1px solid #FDA1A2/30;
        }
        .info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
            margin-bottom: 0;
        }
        .info-item h3 {
            font-size: 1.1rem;
            color: #EF3B33;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
        }
        .info-item p {
            color: #6b7280;
            line-height: 1.6;
        }
        .info-item a {
            color: #8E0D3C;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 600;
        }
        .info-item a:hover {
            color: #EF3B33;
            text-decoration: underline;
        }
        .form-container {
            background-color: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(142, 13, 60, 0.15);
            border: 2px solid #FDA1A2/20;
        }
        .form-container h2 {
            font-size: 1.5rem;
            color: #1D1842;
            margin-bottom: 30px;
            border-bottom: 3px solid #EF3B33;
            padding-bottom: 15px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #1D1842;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #FDA1A2/30;
            border-radius: 8px;
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #ffffff;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #EF3B33;
            box-shadow: 0 0 0 4px rgba(239, 59, 51, 0.1);
        }
        .form-group textarea {
            resize: vertical;
            min-height: 150px;
        }
        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #8E0D3C, #EF3B33);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(239, 59, 51, 0.3);
        }
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(239, 59, 51, 0.4);
        }
        .submit-btn:active {
            transform: translateY(0);
        }
        .back-button {
            display: inline-block;
            margin-bottom: 30px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #8E0D3C, #EF3B33);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(239, 59, 51, 0.3);
        }
        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 59, 51, 0.4);
        }
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid;
        }
        .alert-success {
            background: linear-gradient(135deg, #d1fae5/50, #a7f3d0/50);
            border-left-color: #10b981;
            color: #047857;
        }
        .alert-error {
            background: linear-gradient(135deg, #fee2e2/50, #fecaca/50);
            border-left-color: #ef4444;
            color: #991b1b;
        }
        .required {
            color: #EF3B33;
            font-weight: 700;
        }
        .icon {
            display: inline-block;
            width: 24px;
            height: 24px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/" class="back-button">← Kembali ke Halaman Utama</a>
        
        <div class="header">
            <h1>Hubungi Kami</h1>
            <p>Kami siap membantu Anda. Jangan ragu untuk menghubungi kami dengan pertanyaan atau masukan apapun.</p>
        </div>

        <div class="content-wrapper">
            <!-- Contact Information -->
            <div class="contact-info">
                <h2>Informasi Kontak</h2>
                
                <div class="info-item">
                    <h3>📧 Email</h3>
                    <p>
                        <a href="mailto:support@umarket.local">marketunila@gmail.com</a>
                    </p>
                    <p style="font-size: 0.9rem; margin-top: 8px; color: #6b7280;">
                        Respons dalam 24 jam
                    </p>
                </div>

                <div class="info-item">
                    <h3>📱 Telepon</h3>
                    <p>
                        <a href="tel:+62812345678">+62 882 8674 9573</a>
                    </p>
                    <p style="font-size: 0.9rem; margin-top: 8px; color: #6b7280;">
                        Senin - Jumat: 09:00 - 17:00 WIB
                    </p>
                </div>

                <div class="info-item">
                    <h3>📍 Lokasi</h3>
                    <p>
                        Universitas Lampung<br>
                        Gg. By Pass 1, Sepang Jaya<br>
                        Bandar Lampung, 35142<br>
                        Indonesia
                    </p>
                </div>

                <div class="info-item">
                    <h3>⏰ Jam Operasional</h3>
                    <p>
                        <strong>Senin - Jumat:</strong> 09:00 - 17:00 WIB<br>
                        <strong>Sabtu:</strong> 10:00 - 16:00 WIB<br>
                        <strong>Minggu:</strong> Tutup<br><br>
                        <em>Hari libur nasional: Tutup</em>
                    </p>
                </div>

            </div>

            <!-- Contact Form -->
            <div class="form-container">
                <h2>Kirim Pesan</h2>
                
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error">
                        <ul style="margin-left: 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="/contact-us" novalidate>
                    @csrf

                    <div class="form-group">
                        <label for="name">Nama <span class="required">*</span></label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap Anda"
                            required
                        >
                        @error('name')
                            <span style="color: #dc2626; font-size: 0.9rem; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            placeholder="Masukkan email Anda"
                            required
                        >
                        @error('email')
                            <span style="color: #dc2626; font-size: 0.9rem; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Nomor Telepon <span class="required">*</span></label>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            value="{{ old('phone') }}"
                            placeholder="Masukkan nomor telepon Anda"
                            required
                        >
                        @error('phone')
                            <span style="color: #dc2626; font-size: 0.9rem; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="subject">Subjek <span class="required">*</span></label>
                        <input 
                            type="text" 
                            id="subject" 
                            name="subject" 
                            value="{{ old('subject') }}"
                            placeholder="Masukkan subjek pesan Anda"
                            required
                        >
                        @error('subject')
                            <span style="color: #dc2626; font-size: 0.9rem; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="message">Pesan <span class="required">*</span></label>
                        <textarea 
                            id="message" 
                            name="message" 
                            placeholder="Tuliskan pesan Anda di sini..."
                            required
                        >{{ old('message') }}</textarea>
                        @error('message')
                            <span style="color: #dc2626; font-size: 0.9rem; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="submit-btn">Kirim Pesan</button>
                </form>

                <p style="text-align: center; margin-top: 20px; color: #6b7280; font-size: 0.9rem;">
                    Kami akan merespons pesan Anda dalam 24 jam kerja.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
