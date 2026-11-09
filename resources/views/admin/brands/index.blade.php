@extends('layouts.admin')

@section('title', 'Marques — Admin')
@section('page-title', 'Marques')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0" style="font-family: 'Playfair Display', serif;">Liste des marques</h5>
    <a href="{{ route('admin.brands.create') }}" class="btn btn-ecloria-primary">
        <i class="bi bi-plus-lg me-1"></i> Nouvelle marque
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Logo</th>
                    <th>Nom</th>
                    <th>Slug</th>
                    <th>Produits</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($brands as $brand)
                    <tr>
                        <td>
                            @if($brand->logo)
                                @php $imgUrl = str_starts_with($brand->logo, 'http') ? $brand->logo : asset('storage/' . $brand->logo); @endphp
                                <img src="{{ $imgUrl }}" style="width: 50px; height: 50px; object-fit: contain; border-radius: 4px; background: #f5f5f5;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td><strong>{{ $brand->name }}</strong></td>
                        <td><code>{{ $brand->slug }}</code></td>
                        <td><span class="badge bg-info">{{ $brand->products_count }}</span></td>
                        <td>
                            <span class="badge {{ $brand->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $brand->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.brands.destroy', $brand) }}" class="d-inline" onsubmit="return confirm('Supprimer cette marque ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Aucune marque trouvée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $brands->links() }}</div>
@endsection
