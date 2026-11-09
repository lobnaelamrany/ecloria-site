@extends('layouts.admin')

@section('title', 'Produits — Admin')
@section('page-title', 'Produits')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0" style="font-family: 'Playfair Display', serif;">Liste des produits</h5>
    <a href="{{ route('admin.products.create') }}" class="btn btn-ecloria-primary">
        <i class="bi bi-plus-lg me-1"></i> Nouveau produit
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>SKU</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Statut</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                @if($product->image)
                                    @php
                                        $imgUrl = str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image);
                                    @endphp
                                    <img src="{{ $imgUrl }}" alt="{{ $product->name }}" style="width: 50px; height: 60px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 60px;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold">{{ $product->name }}</div>
                                <small class="text-muted">{{ $product->category->name ?? '-' }}</small>
                            </td>
                            <td><code>{{ $product->sku }}</code></td>
                            <td class="fw-bold text-ecloria-rose">{{ number_format($product->price, 2) }} DH</td>
                            <td>
                                <span class="badge {{ $product->stock_quantity <= $product->low_stock_threshold ? 'bg-danger' : 'bg-success' }}">
                                    {{ $product->stock_quantity }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $product->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="d-inline" onsubmit="return confirm('Supprimer ce produit ?');">
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
                            <td colspan="7" class="text-center py-4 text-muted">Aucun produit trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $products->links() }}</div>
@endsection
