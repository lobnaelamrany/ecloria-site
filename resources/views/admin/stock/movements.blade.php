@extends('layouts.admin')
@section('title', 'Mouvements — Admin')
@section('page-title', 'Mouvements de stock')

@section('content')
<a href="{{ route('admin.stock.index') }}" class="btn btn-outline-secondary mb-3">
    <i class="bi bi-arrow-left me-1"></i> Retour au stock
</a>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Produit</th>
                    <th>Type</th>
                    <th>Direction</th>
                    <th>Quantité</th>
                    <th>Batch</th>
                    <th>Par</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movements as $m)
                    <tr>
                        <td><small>{{ $m->created_at->format('d/m/Y H:i') }}</small></td>
                        <td>{{ $m->product->name ?? '-' }}</td>
                        <td>
                            <span class="badge
                                @if($m->movement_type === 'purchase') bg-success
                                @elseif($m->movement_type === 'sale') bg-primary
                                @elseif($m->movement_type === 'return') bg-info
                                @elseif($m->movement_type === 'damage') bg-danger
                                @else bg-secondary @endif">
                                {{ ucfirst($m->movement_type) }}
                            </span>
                        </td>
                        <td>
                            <i class="bi bi-arrow-{{ $m->direction === 'in' ? 'down' : 'up' }} text-{{ $m->direction === 'in' ? 'success' : 'danger' }}"></i>
                            {{ $m->direction === 'in' ? 'Entrée' : 'Sortie' }}
                        </td>
                        <td class="fw-bold">{{ $m->quantity }}</td>
                        <td><code>{{ $m->batch->batch_number ?? '-' }}</code></td>
                        <td><small>{{ $m->creator->full_name ?? '-' }}</small></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">Aucun mouvement trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $movements->links() }}</div>
@endsection
