<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.pwa-head')

    <title>Daftar - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app-register.js'])
</head>
<body>
    @if ($errors->any())
        <div id="laravel-errors" style="display: none;">
            @foreach ($errors->get('name') as $error)
                <div data-field="name">{{ $error }}</div>
            @endforeach
            @foreach ($errors->get('email') as $error)
                <div data-field="email">{{ $error }}</div>
            @endforeach
            @foreach ($errors->get('password') as $error)
                <div data-field="password">{{ $error }}</div>
            @endforeach
            @foreach ($errors->get('password_confirmation') as $error)
                <div data-field="password_confirmation">{{ $error }}</div>
            @endforeach
        </div>
    @endif
    
    <div id="app"></div>
</body>
</html>

