@extends('layouts.admin')

@section('title', 'Dashboard — Admin ÉCLORIA')
@section('page-title', 'Dashboard')

@section('content')

{{-- Stats cards --}}
<div class="row g-4 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon rose">
                <i class="bi bi-receipt"></i>
            </div>
            <div>
                <div class="stat-value">{{ $stats['total_orders'] }}</div>
                <div class="stat-label">Commandes</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="bi bi-cash-coin"></i>
            </div>
            <div>
                <div class="stat-value">{{ number_format($stats['total_revenue'], 0) }} DH</div>
                <div class="stat-label">Revenus</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon gold">
                <i class="bi bi-box-seam"></i>
            </div>
            <div>
                <div class="stat-value">{{ $stats['total_products'] }}</div>
                <div class="stat-label">Produits</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon info">
                <i class="bi bi-people"></i>
            </div>
            <div>
                <div class="stat-value">{{ $stats['total_clients'] }}</div>
                <div class="stat-label">Clients</div>
            </div>
        </div>
    </div>
</div>

{{-- Alerts --}}
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card border-warning shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 text-warning"><i class="bi bi-clock-history me-1"></i> Commandes en attente</h6>
                    <p class="mb-0 text-muted small">Commandes qui n'ont pas encore été confirmées.</p>
                </div>
                <div class="fs-3 fw-bold text-warning">{{ $stats['pending_orders'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-danger shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 text-danger"><i class="bi bi-exclamation-triangle me-1"></i> Stock faible</h6>
                    <p class="mb-0 text-muted small">Produits en dessous du seuil minimum.</p>
                </div>
                <div class="fs-3 fw-bold text-danger">{{ $stats['low_stock_products'] }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Recent orders --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0" style="font-family: 'Playfair Display', serif;">Dernières commandes</h5>
        <a href="#" class="btn btn-sm btn-ecloria-outline">Voir toutes</a>
    </div>
    <div class="card-body p-0">
        @if($recentOrders->isEmpty())
            <p class="text-center text-muted py-4 mb-0">Aucune commande pour le moment.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>N°</th>
                            <th>Client</th>
                            <th>Statut</th>
                            <th>Total</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                            <tr>
                                <td><strong>{{ $order->order_number }}</strong></td>
                                <td>{{ $order->customer_name }}</td>
                                <td>
                                    <span class="badge {{ $order->order_status === 'delivered' ? 'bg-success' : ($order->order_status === 'cancelled' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </td>
                                <td class="text-ecloria-rose fw-bold">{{ number_format($order->total_amount, 2) }} DH</td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection
