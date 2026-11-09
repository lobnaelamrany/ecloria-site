@extends('layouts.admin')

@section('title', 'Commande ' . $order->order_number)
@section('page-title', 'Commande ' . $order->order_number)

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row g-4">
    {{-- Main info --}}
    <div class="col-lg-8">
        {{-- Articles --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="mb-3" style="font-family: 'Playfair Display', serif;">Articles commandés</h5>
                @foreach($order->items as $item)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <div class="fw-bold">{{ $item->product_name }}</div>
                            <small class="text-muted">SKU: {{ $item->product_sku }}</small>
                        </div>
                        <div class="text-end">
                            <div>{{ number_format($item->unit_price, 2) }} DH × {{ $item->quantity }}</div>
                            <div class="fw-bold">{{ number_format($item->line_total, 2) }} DH</div>
                        </div>
                    </div>
                @endforeach

                <hr>
                <div class="d-flex justify-content-between"><span>Sous-total</span><span>{{ number_format($order->subtotal, 2) }} DH</span></div>
                <div class="d-flex justify-content-between"><span>Livraison</span><span>{{ number_format($order->shipping_fee, 2) }} DH</span></div>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span class="text-ecloria-rose">{{ number_format($order->total_amount, 2) }} DH</span>
                </div>
            </div>
        </div>

        {{-- Livraison --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="mb-3" style="font-family: 'Playfair Display', serif;">Livraison</h5>
                <p class="mb-1"><strong>{{ $order->customer_name }}</strong></p>
                <p class="mb-1">{{ $order->customer_phone }}</p>
                @if($order->delivery_method === 'store_pickup')
                    <span class="badge bg-info">Retrait en magasin</span>
                @else
                    <p class="mb-0">{{ $order->shipping_address }}, {{ $order->shipping_city }} {{ $order->shipping_postal_code }}</p>
                @endif
                @if($order->customer_note)
                    <hr>
                    <p class="mb-0"><strong>Note client :</strong> {{ $order->customer_note }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="col-lg-4">
        {{-- Statut commande --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="mb-3">Statut de la commande</h6>
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                    @csrf
                    @method('PATCH')
                    <select name="order_status" class="form-select mb-2">
                        @foreach(['pending', 'confirmed', 'preparing', 'ready', 'out_for_delivery', 'delivered', 'collected', 'cancelled'] as $status)
                            <option value="{{ $status }}" {{ $order->order_status === $status ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-ecloria-primary w-100">Mettre à jour</button>
                </form>
            </div>
        </div>

        {{-- Paiement --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6 class="mb-3">Paiement</h6>
                <p class="small mb-2">
                    Méthode : <strong>{{ $order->payment->payment_method === 'cash_on_delivery' ? 'À la livraison' : 'En magasin' }}</strong><br>
                    Montant : <strong>{{ number_format($order->payment->amount, 2) }} DH</strong>
                </p>
                <form method="POST" action="{{ route('admin.orders.updatePayment', $order) }}">
                    @csrf
                    @method('PATCH')
                    <select name="payment_status" class="form-select mb-2">
                        <option value="pending" {{ $order->payment->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $order->payment->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="partially_refunded" {{ $order->payment->payment_status === 'partially_refunded' ? 'selected' : '' }}>Partiellement remboursé</option>
                        <option value="refunded" {{ $order->payment->payment_status === 'refunded' ? 'selected' : '' }}>Remboursé</option>
                    </select>
                    <button type="submit" class="btn btn-ecloria-outline w-100">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour aux commandes
    </a>
</div>
@endsection
