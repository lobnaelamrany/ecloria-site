@extends('layouts.admin')
@section('title', 'Lots — Admin')
@section('page-title', 'Lots de stock')

@section('content')
<a href="{{ route('admin.stock.index') }}" class="btn btn-outline-secondary mb-3">
    <i class="bi bi-arrow-left me-1"></i> Retour au stock
</a>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Produit</th>
                    <th>Batch</th>
                    <th>Expiration</th>
                    <th>Reçu</th>
                    <th>Restant</th>
                    <th>Date réception</th>
                </tr>
            </thead>
            <tbody>
                @forelse($batches as $b)
                    <tr>
                        <td><strong>{{ $b->product->name ?? '-' }}</strong></td>
                        <td><code>{{ $b->batch_number }}</code></td>
                        <td>
                            @if($b->expiry_date)
                                <span class="{{ $b->expiry_date->isPast() ? 'text-danger fw-bold' : '' }}">
                                    {{ $b->expiry_date->format('d/m/Y') }}
                                </span>
                            @else
                                <small class="text-muted">N/A</small>
                            @endif
                        </td>
                        <td>{{ $b->quantity_received }}</td>
                        <td>
                            <span class="badge {{ $b->quantity_remaining > 0 ? 'bg-success' : 'bg-secondary' }}">
                                {{ $b->quantity_remaining }}
                            </span>
                        </td>
                        <td><small>{{ $b->received_at->format('d/m/Y') }}</small></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Aucun lot trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $batches->links() }}</div>
@endsection
