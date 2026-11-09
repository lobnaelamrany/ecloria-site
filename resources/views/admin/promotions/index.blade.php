@extends('layouts.admin')
@section('title', 'Promotions — Admin')
@section('page-title', 'Promotions')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0" style="font-family: 'Playfair Display', serif;">Liste des promotions</h5>
    <a href="{{ route('admin.promotions.create') }}" class="btn btn-ecloria-primary">
        <i class="bi bi-plus-lg me-1"></i> Nouvelle promotion
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Titre</th>
                    <th>Type</th>
                    <th>Valeur</th>
                    <th>Période</th>
                    <th>Produits</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promotions as $promo)
                    <tr>
                        <td><strong>{{ $promo->title }}</strong></td>
                        <td>{{ $promo->discount_type === 'percentage' ? 'Pourcentage' : 'Montant fixe' }}</td>
                        <td class="text-ecloria-rose fw-bold">
                            {{ $promo->discount_type === 'percentage' ? $promo->discount_value . '%' : $promo->discount_value . ' DH' }}
                        </td>
                        <td><small>{{ $promo->starts_at->format('d/m/Y') }} → {{ $promo->ends_at->format('d/m/Y') }}</small></td>
                        <td><span class="badge bg-info">{{ $promo->products->count() }}</span></td>
                        <td>
                            <span class="badge {{ $promo->is_active && $promo->ends_at > now() ? 'bg-success' : 'bg-secondary' }}">
                                {{ $promo->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.promotions.edit', $promo) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.promotions.destroy', $promo) }}" class="d-inline" onsubmit="return confirm('Supprimer cette promotion ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">Aucune promotion trouvée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $promotions->links() }}</div>
@endsection
