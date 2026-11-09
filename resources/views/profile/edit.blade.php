@extends('layouts.app')

@section('title', __('messages.profile_title') . ' — ÉCLORIA')

@section('content')
<div class="container py-5">
    <div class="section-title">
        <h2>{{ __('messages.profile_title') }}</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="checkout-card">
                <h6 class="mb-3">{{ __('messages.personal_info') }}</h6>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PATCH')
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label">{{ __('messages.first_name') }} *</label>
                            <input type="text" name="first_name" class="form-control" required value="{{ old('first_name', $user->first_name) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('messages.last_name') }} *</label>
                            <input type="text" name="last_name" class="form-control" required value="{{ old('last_name', $user->last_name) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('messages.email') }} *</label>
                            <input type="email" name="email" class="form-control" required value="{{ old('email', $user->email) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('messages.phone') }}</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-ecloria-primary mt-3">{{ __('messages.save') }}</button>
                </form>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="checkout-card">
                <h6 class="mb-3">{{ __('messages.change_password') }}</h6>
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf @method('PATCH')
                    <div class="mb-2">
                        <label class="form-label">{{ __('messages.current_password') }} *</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">{{ __('messages.new_password') }} *</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">{{ __('messages.confirm_password') }} *</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-ecloria-outline mt-2">{{ __('messages.change_password') }}</button>
                </form>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h5 class="mb-3" style="font-family: 'Playfair Display', serif;">{{ __('messages.my_addresses') }}</h5>
        <div class="row g-3 mb-3">
            @forelse($addresses as $address)
                <div class="col-md-4">
                    <div class="checkout-card h-100 position-relative">
                        @if($address->is_default)
                            <span class="badge bg-success position-absolute" style="top: 10px; right: 10px;">{{ __('messages.default') }}</span>
                        @endif
                        <h6>{{ $address->title }}</h6>
                        <p class="small mb-1">{{ $address->full_name }}</p>
                        <p class="small mb-1">{{ $address->phone }}</p>
                        <p class="small mb-1">{{ $address->street_address }}, {{ $address->city }}</p>
                        <form method="POST" action="{{ route('profile.addresses.destroy', $address) }}" onsubmit="return confirm('Supprimer cette adresse ?');" class="mt-3">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('messages.delete') }}</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-muted">Aucune adresse enregistrée.</p>
            @endforelse
        </div>

        <div class="checkout-card">
            <h6 class="mb-3">{{ __('messages.add_address') }}</h6>
            <form method="POST" action="{{ route('profile.addresses.store') }}">
                @csrf
                <div class="row g-2">
                    <div class="col-md-3">
                        <label class="form-label">{{ __('messages.address_title') }} *</label>
                        <input type="text" name="title" class="form-control" placeholder="Maison..." required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('messages.full_name') }} *</label>
                        <input type="text" name="full_name" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('messages.phone') }} *</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('messages.city') }} *</label>
                        <input type="text" name="city" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('messages.neighborhood') }}</label>
                        <input type="text" name="neighborhood" class="form-control">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">{{ __('messages.address') }} *</label>
                        <input type="text" name="street_address" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">{{ __('messages.postal_code') }}</label>
                        <input type="text" name="postal_code" class="form-control">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <div class="form-check">
                            <input type="checkbox" name="is_default" class="form-check-input" id="is_default" value="1">
                            <label class="form-check-label" for="is_default">{{ __('messages.default') }}</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-ecloria-primary mt-3">{{ __('messages.add_address') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
