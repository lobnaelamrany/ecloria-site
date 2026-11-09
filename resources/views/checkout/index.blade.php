@extends('layouts.app')

@section('title', __('messages.checkout_title') . ' — ÉCLORIA')

@section('content')
<div class="container py-5">
    <div class="section-title">
        <h2>{{ __('messages.checkout_title') }}</h2>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('checkout.store') }}">
        @csrf
        <div class="row g-4">
            <div class="col-lg-7">
                {{-- Informations client --}}
                <div class="checkout-card">
                    <h5 class="checkout-section-title">{{ __('messages.personal_info') }}</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">{{ __('messages.full_name') }} *</label>
                            <input type="text" name="customer_name" class="form-control" required value="{{ old('customer_name', $user->full_name) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('messages.phone') }} *</label>
                            <input type="text" name="customer_phone" class="form-control" required value="{{ old('customer_phone', $user->phone) }}">
                        </div>
                    </div>
                </div>

                {{-- Livraison --}}
                <div class="checkout-card">
                    <h5 class="checkout-section-title">{{ __('messages.delivery_method') }}</h5>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="delivery_method" id="delivery" value="delivery" {{ old('delivery_method', 'delivery') === 'delivery' ? 'checked' : '' }}>
                        <label class="form-check-label" for="delivery">
                            <strong>{{ __('messages.home_delivery') }}</strong> — {{ number_format($shippingFee, 2) }} DH
                            <small class="text-muted d-block">{{ __('messages.free_shipping') }} {{ number_format($freeThreshold, 2) }} DH</small>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="delivery_method" id="store_pickup" value="store_pickup" {{ old('delivery_method') === 'store_pickup' ? 'checked' : '' }}>
                        <label class="form-check-label" for="store_pickup">
                            <strong>{{ __('messages.store_pickup') }}</strong> — {{ __('messages.free_shipping') }}
                        </label>
                    </div>
                </div>

                {{-- Adresse --}}
                <div class="checkout-card">
                    <h5 class="checkout-section-title">{{ __('messages.shipping_address') }}</h5>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">{{ __('messages.city') }} *</label>
                            <input type="text" name="shipping_city" class="form-control" required value="{{ old('shipping_city') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('messages.postal_code') }}</label>
                            <input type="text" name="shipping_postal_code" class="form-control" value="{{ old('shipping_postal_code') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ __('messages.address') }} *</label>
                            <input type="text" name="shipping_address" class="form-control" value="{{ old('shipping_address') }}" placeholder="Rue, numéro, quartier...">
                        </div>
                    </div>
                </div>

                {{-- Paiement --}}
                <div class="checkout-card">
                    <h5 class="checkout-section-title">{{ __('messages.payment_method') }}</h5>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cash_on_delivery" {{ old('payment_method', 'cash_on_delivery') === 'cash_on_delivery' ? 'checked' : '' }}>
                        <label class="form-check-label" for="cod">
                            <strong>{{ __('messages.cash_on_delivery') }}</strong>
                            <small class="text-muted d-block">{{ __('messages.pay_on_reception') }}</small>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="store" value="payment_at_store" {{ old('payment_method') === 'payment_at_store' ? 'checked' : '' }}>
                        <label class="form-check-label" for="store">
                            <strong>{{ __('messages.payment_at_store') }}</strong>
                            <small class="text-muted d-block">{{ __('messages.pay_at_store') }}</small>
                        </label>
                    </div>
                </div>

                {{-- Note --}}
                <div class="checkout-card">
                    <h5 class="checkout-section-title">{{ __('messages.note_optional') }}</h5>
                    <textarea name="customer_note" class="form-control" rows="3" placeholder="{{ __('messages.special_instructions') }}">{{ old('customer_note') }}</textarea>
                </div>
            </div>

            {{-- Summary --}}
            <div class="col-lg-5">
                <div class="checkout-summary">
                    <h5>{{ __('messages.your_order') }}</h5>
                    @php
                        $totalDiscount = 0;
                        foreach ($cart->items as $item) {
                            $promos = $item->product->promotions()->where('is_active', true)->where('starts_at', '<=', now())->where('ends_at', '>=', now())->get();
                            $maxDiscount = 0;
                            foreach ($promos as $promo) {
                                $d = $promo->discount_type === 'percentage' ? $item->product->price * ($promo->discount_value / 100) : $promo->discount_value;
                                $maxDiscount = max($maxDiscount, min($d, $item->product->price));
                            }
                            $totalDiscount += $maxDiscount * $item->quantity;
                        }
                        $finalTotal = $cart->subtotal - $totalDiscount + $shippingFee;
                    @endphp

                    <div class="checkout-items">
                        @foreach($cart->items as $item)
                            <div class="checkout-item">
                                <div class="checkout-item-img">
                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}">
                                </div>
                                <div class="flex-grow-1">
                                    <div class="small fw-medium">{{ $item->product->name }}</div>
                                    <div class="text-muted" style="font-size: 0.8rem;">Qté: {{ $item->quantity }}</div>
                                </div>
                                <div class="small fw-bold">{{ number_format($item->product->price * $item->quantity, 2) }} DH</div>
                            </div>
                        @endforeach
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ __('messages.subtotal') }}</span>
                        <span>{{ number_format($cart->raw_subtotal, 2) }} DH</span>
                    </div>
                    @if($totalDiscount > 0)
                        <div class="d-flex justify-content-between mb-2 text-success">
                            <span>{{ __('messages.discount') }}</span>
                            <span>-{{ number_format($totalDiscount, 2) }} DH</span>
                        </div>
                    @endif
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ __('messages.shipping') }}</span>
                        <span>{{ number_format($shippingFee, 2) }} DH</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>{{ __('messages.total') }}</span>
                        <span class="text-ecloria-rose">{{ number_format($finalTotal, 2) }} DH</span>
                    </div>
                    <button type="submit" class="btn btn-ecloria-primary w-100 mt-4">
                        <i class="bi bi-check-circle me-1"></i> {{ __('messages.confirm_order') }}
                    </button>
                    <a href="{{ route('cart.index') }}" class="btn btn-link w-100 mt-2 text-muted">
                        <i class="bi bi-arrow-left me-1"></i> {{ __('messages.back_to_cart') }}
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
