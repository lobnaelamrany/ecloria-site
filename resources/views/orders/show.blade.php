@extends('layouts.app')

@section('title', 'Commande ' . $order->order_number . ' — ÉCLORIA')

@section('content')
<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">{{ __('messages.my_orders') }}</a></li>
            <li class="breadcrumb-item active">{{ $order->order_number }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="checkout-card">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h5 class="mb-1">Commande {{ $order->order_number }}</h5>
                        <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                    <span class="badge {{ $order->order_status === 'delivered' ? 'bg-success' : ($order->order_status === 'cancelled' ? 'bg-danger' : 'bg-warning text-dark') }}">
                        {{ ucfirst($order->order_status) }}
                    </span>
                </div>

                <h6 class="mb-3">{{ __('messages.order_items') }}</h6>
                @foreach($order->items as $item)
                    <div class="order-item-row">
                        <div>
                            <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                            {{-- فورم التقييم --}}
                            @if($order->canBeReturned() && !$item->review)
                                <div class="mt-2">
                                    <form method="POST" action="{{ route('reviews.store', $item) }}" class="d-flex gap-2 align-items-center">
                                        @csrf
                                        <select name="rating" class="form-select form-select-sm" style="width: 90px;" required>
                                            <option value="5">5 ★</option>
                                            <option value="4">4 ★</option>
                                            <option value="3">3 ★</option>
                                            <option value="2">2 ★</option>
                                            <option value="1">1 ★</option>
                                        </select>
                                        <input type="text" name="comment" class="form-control form-control-sm" placeholder="Votre avis...">
                                        <button type="submit" class="btn btn-sm btn-ecloria-primary">Noter</button>
                                    </form>
                                </div>
                            @elseif($item->review)
                                <small class="text-success d-block mt-1"><i class="bi bi-check-circle"></i> Déjà évalué ({{ $item->review->rating }} ★)</small>
                            @endif
                        </div>
                        <span>{{ number_format($item->line_total, 2) }} DH</span>
                    </div>
                @endforeach

                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span>{{ __('messages.subtotal') }}</span>
                    <span>{{ number_format($order->subtotal, 2) }} DH</span>
                </div>
                @if($order->discount_amount > 0)
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>{{ __('messages.discount') }}</span>
                        <span>-{{ number_format($order->discount_amount, 2) }} DH</span>
                    </div>
                @endif
                <div class="d-flex justify-content-between mb-2">
                    <span>{{ __('messages.shipping') }}</span>
                    <span>{{ number_format($order->shipping_fee, 2) }} DH</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>{{ __('messages.total') }}</span>
                    <span class="text-ecloria-rose">{{ number_format($order->total_amount, 2) }} DH</span>
                </div>
            </div>

            {{-- Actions --}}
            <div class="mt-3">
                @if($order->isCancellable())
                    <form method="POST" action="{{ route('orders.cancel', $order->order_number) }}" class="d-inline" onsubmit="return confirm('Annuler cette commande ?');">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-x-circle me-1"></i> {{ __('messages.cancel_order') }}
                        </button>
                    </form>
                @endif

                @if($order->canBeReturned())
                    <a href="{{ route('returns.create', $order) }}" class="btn btn-outline-primary ms-2">
                        <i class="bi bi-arrow-return-left me-1"></i> {{ __('messages.request_return') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="checkout-card">
                <h6 class="mb-3">{{ __('messages.order_shipping') }}</h6>
                <p class="small mb-0">
                    {{ $order->customer_name }}<br>
                    {{ $order->customer_phone }}<br>
                    @if($order->delivery_method === 'store_pickup')
                        <span class="badge bg-info">Retrait en magasin</span>
                    @else
                        {{ $order->shipping_address }}<br>
                        {{ $order->shipping_city }} {{ $order->shipping_postal_code }}
                    @endif
                </p>
            </div>

            <div class="checkout-card mt-3">
                <h6 class="mb-3">{{ __('messages.order_payment') }}</h6>
                <p class="small mb-0">
                    @if($order->payment->payment_method === 'cash_on_delivery')
                        Paiement à la livraison
                    @else
                        Paiement en magasin
                    @endif
                    <br>
                    <span class="badge {{ $order->payment->payment_status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                        {{ ucfirst($order->payment->payment_status) }}
                    </span>
                </p>
            </div>

            @if($order->customer_note)
                <div class="checkout-card mt-3">
                    <h6 class="mb-2">Note</h6>
                    <p class="small mb-0">{{ $order->customer_note }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
