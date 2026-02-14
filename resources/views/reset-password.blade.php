<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atur Ulang Kata Sandi - {{ config('app.name', 'Laravel') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css'])
    
    <style>
        body { 
            font-family: 'Instrument Sans', sans-serif; 
            margin: 0; 
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(253, 161, 162, 0.2);
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
            object-fit: contain;
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

        .alert-danger { 
            padding: 1rem; 
            border-radius: 0.75rem; 
            margin-bottom: 1.25rem; 
            font-size: 0.875rem; 
            border: 1px solid rgba(239, 59, 51, 0.2);
            background-color: rgba(239, 59, 51, 0.1); 
            color: #8E0D3C; 
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

        <h1 class="title">Atur Ulang Sandi</h1>
        <p class="subtitle">Hampir selesai! Silakan masukkan kata sandi baru Anda di bawah ini.</p>

        @if ($errors->any())
            <div class="alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="input-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" required autofocus placeholder="nama@email.com">
            </div>

            <div class="input-group">
                <label for="password">Kata Sandi Baru</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>

            <div class="input-group">
                <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••">
            </div>

            <button type="submit" class="btn">Simpan Kata Sandi</button>
        </form>
    </div>
</body>
</html>
