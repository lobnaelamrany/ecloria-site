@extends('layouts.admin')
@section('title', 'Retours — Admin')
@section('page-title', 'Retours')

@section('content')
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>N°</th>
                    <th>Client</th>
                    <th>Commande</th>
                    <th>Raison</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($returns as $r)
                    <tr>
                        <td><strong>{{ $r->return_number }}</strong></td>
                        <td>{{ $r->user->full_name ?? '-' }}</td>
                        <td>{{ $r->order->order_number ?? '-' }}</td>
                        <td><small>{{ Str::limit($r->reason, 50) }}</small></td>
                        <td>
                            <span class="badge
                                @if($r->return_status === 'refunded') bg-success
                                @elseif($r->return_status === 'rejected' || $r->return_status === 'cancelled') bg-danger
                                @else bg-warning text-dark @endif">
                                {{ ucfirst($r->return_status) }}
                            </span>
                        </td>
                        <td><small>{{ $r->created_at->format('d/m/Y') }}</small></td>
                        <td class="text-end">
                            <a href="{{ route('admin.returns.show', $r) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Voir
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">Aucun retour trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $returns->links() }}</div>
@endsection
