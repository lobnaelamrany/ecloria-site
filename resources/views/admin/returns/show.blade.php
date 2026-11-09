@extends('layouts.admin')
@section('title', 'Retour ' . $return->return_number)
@section('page-title', 'Retour ' . $return->return_number)

@section('content')
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6>Détails du retour</h6>
                <p><strong>Client:</strong> {{ $return->user->full_name }}</p>
                <p><strong>Commande:</strong> {{ $return->order->order_number }}</p>
                <p><strong>Raison:</strong> {{ $return->reason }}</p>

                <h6 class="mt-4">Articles</h6>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Qté</th>
                            <th>État</th>
                            <th>Revendable</th>
                            <th>Remboursement</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($return->items as $item)
                            <tr>
                                <td>{{ $item->orderItem->product_name ?? '-' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ ucfirst($item->item_condition) }}</td>
                                <td>{!! $item->restockable ? '<span class="badge bg-success">Oui</span>' : '<span class="badge bg-secondary">Non</span>' !!}</td>
                                <td class="fw-bold text-ecloria-rose">{{ number_format($item->refund_amount, 2) }} DH</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="text-end fw-bold">Total remboursement: {{ number_format($return->items->sum('refund_amount'), 2) }} DH</p>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6>Statut</h6>
                <p>Statut actuel:
                    <span class="badge
                        @if($return->return_status === 'refunded') bg-success
                        @elseif($return->return_status === 'rejected' || $return->return_status === 'cancelled') bg-danger
                        @else bg-warning text-dark @endif">
                        {{ ucfirst($return->return_status) }}
                    </span>
                </p>

                <form method="POST" action="{{ route('admin.returns.updateStatus', $return) }}">
                    @csrf @method('PATCH')
                    <select name="return_status" class="form-select mb-2">
                        @foreach(['approved', 'rejected', 'received', 'refunded', 'cancelled'] as $st)
                            <option value="{{ $st }}" {{ $return->return_status === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-ecloria-primary w-100">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('admin.returns.index') }}" class="btn btn-outline-secondary mt-3">
    <i class="bi bi-arrow-left me-1"></i> Retour
</a>
@endsection
