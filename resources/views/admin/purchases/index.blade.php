@extends('layouts.admin')
@section('title', 'Achats — Admin')
@section('page-title', 'Achats')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0" style="font-family: 'Playfair Display', serif;">Liste des achats</h5>
    <a href="{{ route('admin.purchases.create') }}" class="btn btn-ecloria-primary">
        <i class="bi bi-plus-lg me-1"></i> Nouvel achat
    </a>
</div>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>N°</th>
                    <th>Fournisseur</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchases as $p)
                    <tr>
                        <td><strong>{{ $p->purchase_number }}</strong></td>
                        <td>{{ $p->supplier->name ?? '-' }}</td>
                        <td class="fw-bold text-ecloria-rose">{{ number_format($p->total_cost, 2) }} DH</td>
                        <td>
                            <span class="badge {{ $p->purchase_status === 'received' ? 'bg-success' : ($p->purchase_status === 'cancelled' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                {{ ucfirst($p->purchase_status) }}
                            </span>
                        </td>
                        <td><small>{{ $p->purchase_date->format('d/m/Y') }}</small></td>
                        <td class="text-end">
                            <a href="{{ route('admin.purchases.show', $p) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Voir</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Aucun achat trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $purchases->links() }}</div>
@endsection
