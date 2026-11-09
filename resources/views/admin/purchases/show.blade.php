@extends('layouts.admin')
@section('title', 'Achat ' . $purchase->purchase_number)
@section('page-title', 'Achat ' . $purchase->purchase_number)

@section('content')
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

{{-- إظهار أخطاء الـ validation --}}
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="row mb-3">
            <div class="col-md-6">
                <p class="mb-1"><strong>Fournisseur:</strong> {{ $purchase->supplier->name }}</p>
                <p class="mb-1"><strong>Date:</strong> {{ $purchase->purchase_date->format('d/m/Y') }}</p>
                <p class="mb-1"><strong>Statut:</strong>
                    <span class="badge {{ $purchase->purchase_status === 'received' ? 'bg-success' : 'bg-warning text-dark' }}">
                        {{ ucfirst($purchase->purchase_status) }}
                    </span>
                </p>
            </div>
            <div class="col-md-6 text-end">
                <p class="fs-5 fw-bold text-ecloria-rose">{{ number_format($purchase->total_cost, 2) }} DH</p>
                <p class="text-muted small">Créé par {{ $purchase->creator->full_name ?? '-' }}</p>
            </div>
        </div>

        <h6>Produits</h6>
        <form method="POST" action="{{ route('admin.purchases.receive', $purchase) }}">
            @csrf @method('PATCH')
            <table class="table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Qté commandée</th>
                        <th>Coût unitaire</th>
                        <th>Qté reçue</th>
                        <th>N° Batch</th>
                        <th>Date d'expiration</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchase->items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? '-' }}</td>
                            <td>{{ $item->quantity_ordered }}</td>
                            <td>{{ number_format($item->unit_cost, 2) }} DH</td>
                            <td>
                                @if($purchase->purchase_status === 'received')
                                    {{ $item->quantity_received }}
                                @else
                                    {{-- هاد الـ name مهم بزاف --}}
                                    <input type="number" name="items[{{ $item->id }}][quantity_received]" class="form-control form-control-sm" min="1" max="{{ $item->quantity_ordered }}" value="{{ $item->quantity_ordered }}" required>
                                @endif
                            </td>
                            <td>
                                @if($purchase->purchase_status !== 'received')
                                    <input type="text" name="items[{{ $item->id }}][batch_number]" class="form-control form-control-sm" placeholder="BATCH-001">
                                @endif
                            </td>
                            <td>
                                @if($purchase->purchase_status !== 'received')
                                    <input type="date" name="items[{{ $item->id }}][expiry_date]" class="form-control form-control-sm">
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($purchase->purchase_status !== 'received' && $purchase->purchase_status !== 'cancelled')
                <button type="submit" class="btn btn-ecloria-primary">Confirmer la réception</button>
            @endif
        </form>

        @if($purchase->purchase_status !== 'received' && $purchase->purchase_status !== 'cancelled')
            <form method="POST" action="{{ route('admin.purchases.cancel', $purchase) }}" class="mt-2" onsubmit="return confirm('Annuler cet achat ?');">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-outline-danger">Annuler l'achat</button>
            </form>
        @endif
    </div>
</div>

<a href="{{ route('admin.purchases.index') }}" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left me-1"></i> Retour
</a>
@endsection
