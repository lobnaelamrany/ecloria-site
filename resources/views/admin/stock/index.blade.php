@extends('layouts.admin')
@section('title', 'Stock — Admin')
@section('page-title', 'Stock')

@section('content')
{{-- Stats --}}
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon rose"><i class="bi bi-boxes"></i></div>
            <div>
                <div class="stat-value">{{ $stats['total_batches'] }}</div>
                <div class="stat-label">Lots actifs</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon success"><i class="bi bi-cash-stack"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['total_stock_value'], 0) }} DH</div>
                <div class="stat-label">Valeur stock</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon gold"><i class="bi bi-exclamation-triangle"></i></div>
            <div>
                <div class="stat-value">{{ $stats['low_stock_count'] }}</div>
                <div class="stat-label">Stock faible</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon info"><i class="bi bi-clock-history"></i></div>
            <div>
                <div class="stat-value">{{ $stats['expiring_count'] }}</div>
                <div class="stat-label">Expirent bientôt</div>
            </div>
        </div>
    </div>
</div>

{{-- Buttons --}}
<div class="mb-4">
    <a href="{{ route('admin.stock.batches') }}" class="btn btn-ecloria-primary">
        <i class="bi bi-boxes me-1"></i> Voir les lots
    </a>
    <a href="{{ route('admin.stock.movements') }}" class="btn btn-ecloria-outline">
        <i class="bi bi-arrow-left-right me-1"></i> Mouvements de stock
    </a>
</div>

{{-- Low stock --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0" style="font-family: 'Playfair Display', serif;">Produits en stock faible</h5>
    </div>
    <div class="card-body p-0">
        @if($lowStockProducts->isEmpty())
            <p class="text-center text-muted py-4 mb-0">Aucun produit en stock faible.</p>
        @else
            <table class="table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Produit</th>
                        <th>Catégorie</th>
                        <th>Stock</th>
                        <th>Seuil</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStockProducts as $p)
                        <tr>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->category->name ?? '-' }}</td>
                            <td><span class="badge bg-danger">{{ $p->stock_quantity }}</span></td>
                            <td>{{ $p->low_stock_threshold }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

{{-- Expiring batches --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0" style="font-family: 'Playfair Display', serif;">Lots qui expirent bientôt (30 jours)</h5>
    </div>
    <div class="card-body p-0">
        @if($expiringBatches->isEmpty())
            <p class="text-center text-muted py-4 mb-0">Aucun lot n'expire bientôt.</p>
        @else
            <table class="table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Produit</th>
                        <th>Batch</th>
                        <th>Expiration</th>
                        <th>Quantité restante</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expiringBatches as $b)
                        <tr>
                            <td>{{ $b->product->name ?? '-' }}</td>
                            <td><code>{{ $b->batch_number }}</code></td>
                            <td class="text-danger fw-bold">{{ $b->expiry_date->format('d/m/Y') }}</td>
                            <td>{{ $b->quantity_remaining }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
