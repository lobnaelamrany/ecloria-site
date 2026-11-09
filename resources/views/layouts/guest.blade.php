<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'ÉCLORIA')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            {{-- Logo --}}
            <div class="auth-logo">
                <a href="{{ route('home') }}">
                    ÉCL<span class="accent">O</span>RIA
                </a>
            </div>

            {{-- Content --}}
            @yield('content')

            {{-- Back home --}}
            <a href="{{ route('home') }}" class="back-home">
                <i class="bi bi-arrow-left me-1"></i> Retour à la boutique
            </a>
        </div>
    </div>
</body>
</html>
