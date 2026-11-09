@extends('layouts.app')

@section('title', 'Commande confirmée — ÉCLORIA')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <div class="success-icon">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <h1 class="mt-3">Merci pour votre commande !</h1>
        <p class="text-muted">Votre commande a bien été enregistrée.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="checkout-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="mb-1">Commande {{ $order->order_number }}</h5>
                        <small class="text-muted">{{ $order->created_at->format('d/m/Y à H:i') }}</small>
                    </div>
                    <span class="badge bg-warning text-dark">{{ ucfirst($order->order_status) }}</span>
                </div>

                <h6 class="mb-3">Articles commandés</h6>
                @foreach($order->items as $item)
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                        <span>{{ number_format($item->line_total, 2) }} DH</span>
                    </div>
                @endforeach

                <hr>

                <div class="d-flex justify-content-between mb-2">
                    <span>Sous-total</span>
                    <span>{{ number_format($order->subtotal, 2) }} DH</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Livraison</span>
                    <span>{{ number_format($order->shipping_fee, 2) }} DH</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span class="text-ecloria-rose">{{ number_format($order->total_amount, 2) }} DH</span>
                </div>

                <hr class="my-4">

                <div class="row">
                    <div class="col-md-6">
                        <h6>Livraison</h6>
                        <p class="mb-0 small">
                            {{ $order->customer_name }}<br>
                            {{ $order->customer_phone }}<br>
                            @if($order->delivery_method === 'store_pickup')
                                <span class="badge bg-info">Retrait en magasin</span>
                            @else
                                {{ $order->shipping_address }}, {{ $order->shipping_city }}
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6>Paiement</h6>
                        <p class="mb-0 small">
                            @if($order->payment->payment_method === 'cash_on_delivery')
                                Paiement à la livraison
                            @else
                                Paiement en magasin
                            @endif
                            <br>
                            <span class="badge bg-warning text-dark">{{ ucfirst($order->payment->payment_status) }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('products.index') }}" class="btn btn-ecloria-outline">
                    Continuer mes achats
                </a>
                <a href="{{ route('home') }}" class="btn btn-ecloria-primary ms-2">
                    Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
