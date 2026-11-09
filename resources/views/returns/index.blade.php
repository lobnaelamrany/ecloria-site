@extends('layouts.app')
@section('title', 'Mes Retours — ÉCLORIA')

@section('content')
<div class="container py-5">
    <div class="section-title"><h2>Mes Retours</h2></div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    @if($returns->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-arrow-return-left" style="font-size: 4rem; color: var(--ecloria-gray);"></i>
            <h3 class="mt-4">Aucun retour</h3>
            <p class="text-muted">Vous n'avez demandé aucun retour pour le moment.</p>
            <a href="{{ route('orders.index') }}" class="btn btn-ecloria-primary mt-3">Voir mes commandes</a>
        </div>
    @else
        <div class="orders-list">
            @foreach($returns as $ret)
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <h5 class="mb-1">{{ $ret->return_number }}</h5>
                            <small class="text-muted">Commande: {{ $ret->order->order_number }}</small>
                        </div>
                        <span class="badge
                            @if($ret->return_status === 'refunded') bg-success
                            @elseif($ret->return_status === 'rejected' || $ret->return_status === 'cancelled') bg-danger
                            @else bg-warning text-dark @endif">
                            {{ ucfirst($ret->return_status) }}
                        </span>
                    </div>
                    <div class="order-body">
                        <p class="mb-2 small"><strong>Raison:</strong> {{ $ret->reason }}</p>
                        <p class="mb-0 small text-muted">{{ $ret->items->count() }} article(s) — Total remboursement: {{ number_format($ret->items->sum('refund_amount'), 2) }} DH</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $returns->links() }}</div>
    @endif
</div>
@endsection
