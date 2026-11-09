@extends('layouts.admin')
@section('title', 'Fournisseurs — Admin')
@section('page-title', 'Fournisseurs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0" style="font-family: 'Playfair Display', serif;">Liste des fournisseurs</h5>
    <a href="{{ route('admin.suppliers.create') }}" class="btn btn-ecloria-primary">
        <i class="bi bi-plus-lg me-1"></i> Nouveau fournisseur
    </a>
</div>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Achats</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $s)
                    <tr>
                        <td><strong>{{ $s->name }}</strong></td>
                        <td>{{ $s->contact_person ?? '-' }}</td>
                        <td>{{ $s->email ?? '-' }}</td>
                        <td>{{ $s->phone ?? '-' }}</td>
                        <td><span class="badge bg-info">{{ $s->purchases_count }}</span></td>
                        <td>
                            <span class="badge {{ $s->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $s->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.suppliers.edit', $s) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.suppliers.destroy', $s) }}" class="d-inline" onsubmit="return confirm('Supprimer ce fournisseur ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">Aucun fournisseur trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $suppliers->links() }}</div>
@endsection
