<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin — ÉCLORIA')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        {{-- Sidebar --}}
        @include('layouts.partials.admin-sidebar')

        {{-- Main area --}}
        <div class="admin-main" id="adminMain">
            {{-- Topbar --}}
            @include('layouts.partials.admin-topbar')

            {{-- Content --}}
            <div class="admin-content">
                @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
