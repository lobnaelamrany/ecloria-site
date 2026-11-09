@extends('layouts.guest')

@section('title', __('messages.login_title') . ' — ÉCLORIA')

@section('content')
    <h2 class="auth-title">{{ __('messages.login_title') }}</h2>
    <p class="auth-subtitle">{{ __('messages.login_subtitle') }}</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('messages.email') }}</label>
            <input type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   id="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autofocus
                   autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">{{ __('messages.password') }}</label>
            <input type="password"
                   class="form-control @error('password') is-invalid @enderror"
                   id="password"
                   name="password"
                   required
                   autocomplete="current-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Remember me --}}
        <div class="mb-4 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember" style="font-size: 0.9rem;">
                {{ __('messages.remember_me') }}
            </label>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-ecloria-primary btn-submit">
            {{ __('messages.login') }}
        </button>
    </form>

    <div class="auth-footer">
        {{ __('messages.no_account') }}
        <a href="{{ route('register') }}">{{ __('messages.create_account') }}</a>
    </div>
@endsection
