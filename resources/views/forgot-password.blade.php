<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Kata Sandi - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css'])
    
    <style>
        body { 
            font-family: 'Instrument Sans', sans-serif; 
            margin: 0; 
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(253, 161, 162, 0.2); /* #FDA1A2 with opacity */
        }
        
        .card { 
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(8px);
            padding: 2rem; 
            border-radius: 1.5rem; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 10px 15px -3px rgba(0, 0, 0, 0.1); 
            width: 100%; 
            max-width: 400px; 
            border: 1px solid rgba(253, 161, 162, 0.4);
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .logo-container img {
            height: 80px;
            width: auto;
            object-contain: contain;
        }

        .title { 
            font-size: 1.75rem; 
            font-weight: 700; 
            margin-bottom: 0.5rem; 
            color: #8E0D3C; 
            text-align: center;
        }

        .subtitle { 
            font-size: 0.875rem; 
            color: #4b5563; 
            margin-bottom: 1.5rem; 
            text-align: center;
            line-height: 1.25rem;
        }

        .input-group { margin-bottom: 1.25rem; }
        
        label { 
            display: block; 
            font-size: 0.875rem; 
            font-weight: 500; 
            color: #1f2937; 
            margin-bottom: 0.5rem; 
        }

        input { 
            width: 100%; 
            padding: 0.75rem 1rem; 
            border: 1px solid rgba(253, 161, 162, 0.4); 
            border-radius: 0.75rem; 
            outline: none; 
            transition: all 0.2s; 
            box-sizing: border-box;
            background-color: rgba(253, 161, 162, 0.1);
            color: #1f2937;
        }

        input:focus { 
            border-color: #8E0D3C; 
            background-color: white;
            box-shadow: 0 0 0 2px rgba(142, 13, 60, 0.1);
        }

        .btn { 
            width: 100%; 
            background-color: #8E0D3C; 
            color: white; 
            padding: 0.875rem 1rem; 
            border: none; 
            border-radius: 0.75rem; 
            font-weight: 600; 
            cursor: pointer; 
            transition: all 0.2s; 
            box-shadow: 0 4px 6px -1px rgba(142, 13, 60, 0.2);
            font-size: 1rem;
        }

        .btn:hover { 
            background-color: #EF3B33; 
            transform: translateY(-1px);
            box-shadow: 0 6px 8px -1px rgba(142, 13, 60, 0.3);
        }

        .alert { 
            padding: 1rem; 
            border-radius: 0.75rem; 
            margin-bottom: 1.25rem; 
            font-size: 0.875rem; 
            border: 1px solid;
        }

        .alert-success { 
            background-color: rgba(253, 161, 162, 0.1); 
            color: #8E0D3C; 
            border-color: rgba(253, 161, 162, 0.4); 
        }

        .alert-danger { 
            background-color: rgba(239, 59, 51, 0.1); 
            color: #8E0D3C; 
            border-color: rgba(239, 59, 51, 0.2); 
        }

        .back-link { 
            display: block; 
            text-align: center; 
            margin-top: 1.5rem; 
            font-size: 0.875rem; 
            color: #8E0D3C; 
            text-decoration: none; 
            font-weight: 600;
            transition: color 0.2s;
        }

        .back-link:hover { color: #EF3B33; }
        
        .footer-text {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .footer-text a {
            color: #8E0D3C;
            text-decoration: none;
            font-weight: 600;
        }
        
        .footer-text a:hover {
            color: #EF3B33;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo-container">
            <a href="/">
                <img src="/images/logo-u.png" alt="U Marketplace">
            </a>
        </div>

        <h1 class="title">Lupa Kata Sandi?</h1>
        <p class="subtitle">Jangan khawatir! Masukkan email Anda dan kami akan mengirimkan link untuk mereset kata sandi Anda.</p>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="input-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" required autofocus placeholder="nama@email.com" value="{{ old('email') }}">
            </div>
            <button type="submit" class="btn">Kirim Link Reset</button>
        </form>

        <div class="footer-text">
            Ingat kata sandi Anda? <a href="{{ route('login') }}">Masuk</a>
        </div>
    </div>
</body>
</html>
