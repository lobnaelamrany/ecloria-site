@extends('layouts.app')

@section('title', __('messages.my_cart') . ' — ÉCLORIA')

@section('content')
<div class="container py-5">
    <div class="section-title">
        <h2>{{ __('messages.my_cart') }}</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($cart->items->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-bag" style="font-size: 4rem; color: var(--ecloria-gray);"></i>
            <h3 class="mt-4">{{ __('messages.empty_cart') }}</h3>
            <p class="text-muted">{{ __('messages.empty_cart_hint') }}</p>
            <a href="{{ route('products.index') }}" class="btn btn-ecloria-primary mt-3">
                {{ __('messages.discover_products_btn') }}
            </a>
        </div>
    @else
        <div class="row g-4">
            {{-- Items --}}
            <div class="col-lg-8">
                <div class="cart-items-card">
                    @foreach($cart->items as $item)
                        @php
                            $discount = $item->product->active_discount;
                            $unitPrice = $discount ? $discount->final_price : $item->product->price;
                        @endphp
                        <div class="cart-item">
                            <div class="cart-item-image">
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}">
                            </div>
                            <div class="cart-item-info">
                                <a href="{{ route('products.show', $item->product->slug) }}" class="cart-item-name">
                                    {{ $item->product->name }}
                                </a>
                                <div class="cart-item-price">
                                    {{ number_format($unitPrice, 2) }} DH
                                    @if($discount)
                                        <small class="text-muted text-decoration-line-through ms-1">{{ number_format($item->product->price, 2) }} DH</small>
                                    @endif
                                </div>
                            </div>
                            <div class="cart-item-actions">
                                <form method="POST" action="{{ route('cart.update', $item) }}" class="d-flex align-items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock_quantity }}" class="form-control form-control-sm" style="width: 70px;">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary" title="{{ __('messages.update') }}">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('cart.remove', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="{{ __('messages.remove') }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="cart-item-total">
                                {{ number_format($unitPrice * $item->quantity, 2) }} DH
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> {{ __('messages.continue_shopping') }}
                    </a>
                    <form method="POST" action="{{ route('cart.clear') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-trash me-1"></i> {{ __('messages.clear_cart') }}
                        </button>
                    </form>
                </div>
            </div>

            {{-- Summary --}}
            <div class="col-lg-4">
                <div class="cart-summary">
                    <h5>{{ __('messages.summary') }}</h5>
                    <div class="d-flex justify-content-between mt-3">
                        <span>{{ __('messages.subtotal') }}</span>
                        <span>{{ number_format($cart->raw_subtotal, 2) }} DH</span>
                    </div>

                    @if($cart->total_discount > 0)
                        <div class="d-flex justify-content-between mt-2 text-success">
                            <span>{{ __('messages.discount') }}</span>
                            <span>-{{ number_format($cart->total_discount, 2) }} DH</span>
                        </div>
                    @endif

                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>{{ __('messages.total') }}</span>
                        <span class="text-ecloria-rose">{{ number_format($cart->subtotal, 2) }} DH</span>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn btn-ecloria-primary w-100 mt-4">
                        {{ __('messages.checkout_btn') }} <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    <small class="text-muted d-block text-center mt-2">{{ __('messages.checkout_note') }}</small>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
