@extends('layouts.guest')

@section('title', __('messages.register_title') . ' — ÉCLORIA')

@section('content')
    <h2 class="auth-title">{{ __('messages.register_title') }}</h2>
    <p class="auth-subtitle">{{ __('messages.register_subtitle') }}</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- First name + Last name --}}
        <div class="row g-2 mb-3">
            <div class="col-6">
                <label for="first_name" class="form-label">{{ __('messages.first_name') }}</label>
                <input type="text"
                       class="form-control @error('first_name') is-invalid @enderror"
                       id="first_name"
                       name="first_name"
                       value="{{ old('first_name') }}"
                       required
                       autofocus>
                @error('first_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-6">
                <label for="last_name" class="form-label">{{ __('messages.last_name') }}</label>
                <input type="text"
                       class="form-control @error('last_name') is-invalid @enderror"
                       id="last_name"
                       name="last_name"
                       value="{{ old('last_name') }}"
                       required>
                @error('last_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('messages.email') }}</label>
            <input type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   id="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Phone --}}
        <div class="mb-3">
            <label for="phone" class="form-label">{{ __('messages.phone_optional') }}</label>
            <input type="text"
                   class="form-control @error('phone') is-invalid @enderror"
                   id="phone"
                   name="phone"
                   value="{{ old('phone') }}"
                   placeholder="+212 6XX XXX XXX">
            @error('phone')
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
                   autocomplete="new-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Confirm password --}}
        <div class="mb-4">
            <label for="password_confirmation" class="form-label">{{ __('messages.confirm_password') }}</label>
            <input type="password"
                   class="form-control"
                   id="password_confirmation"
                   name="password_confirmation"
                   required
                   autocomplete="new-password">
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-ecloria-primary btn-submit">
            {{ __('messages.create_account') }}
        </button>
    </form>

    <div class="auth-footer">
        {{ __('messages.already_account') }}
        <a href="{{ route('login') }}">{{ __('messages.login') }}</a>
    </div>
@endsection
