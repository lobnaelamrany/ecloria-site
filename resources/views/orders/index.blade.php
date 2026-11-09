@extends('layouts.app')

@section('title', __('messages.my_orders') . ' — ÉCLORIA')

@section('content')
<div class="container py-5">
    <div class="section-title">
        <h2>{{ __('messages.my_orders') }}</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($orders->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-bag" style="font-size: 4rem; color: var(--ecloria-gray);"></i>
            <h3 class="mt-4">{{ __('messages.no_orders') }}</h3>
            <p class="text-muted">{{ __('messages.empty_cart_hint') }}</p>
            <a href="{{ route('products.index') }}" class="btn btn-ecloria-primary mt-3">
                {{ __('messages.discover_products_btn') }}
            </a>
        </div>
    @else
        <div class="orders-list">
            @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <h5 class="mb-1">{{ $order->order_number }}</h5>
                            <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <div class="text-end">
                            <span class="badge {{ $order->order_status === 'delivered' ? 'bg-success' : ($order->order_status === 'cancelled' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                {{ ucfirst($order->order_status) }}
                            </span>
                            <div class="mt-2 fw-bold text-ecloria-rose">{{ number_format($order->total_amount, 2) }} DH</div>
                        </div>
                    </div>
                    <div class="order-body">
                        <div class="d-flex flex-wrap gap-3 mb-3">
                            @foreach($order->items->take(3) as $item)
                                <div class="small">
                                    {{ $item->product_name }} <strong>×{{ $item->quantity }}</strong>
                                </div>
                            @endforeach
                            @if($order->items->count() > 3)
                                <small class="text-muted">+{{ $order->items->count() - 3 }} autre(s)</small>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                @if($order->delivery_method === 'store_pickup')
                                    <i class="bi bi-shop"></i> {{ __('messages.order_shipping') }} (Magasin)
                                @else
                                    <i class="bi bi-truck"></i> {{ __('messages.order_shipping') }} (Domicile)
                                @endif
                            </small>
                            <a href="{{ route('orders.show', $order->order_number) }}" class="btn btn-sm btn-ecloria-outline">
                                {{ __('messages.order_details') }} <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
