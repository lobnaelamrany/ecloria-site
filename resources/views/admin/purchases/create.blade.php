@extends('layouts.admin')
@section('title', 'Nouvel Achat — Admin')
@section('page-title', 'Nouvel Achat')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.purchases.store') }}">
            @csrf
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Fournisseur *</label>
                    <select name="supplier_id" class="form-select" required>
                        <option value="">Sélectionner...</option>
                        @foreach($suppliers as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date d'achat *</label>
                    <input type="date" name="purchase_date" class="form-control" required value="{{ now()->format('Y-m-d') }}">
                </div>
            </div>

            <h6>Produits</h6>
            <div id="items-container">
                {{-- السطر الأول (إجباري، بلا زر X) --}}
                <div class="row g-2 mb-2 item-row">
                    <div class="col-md-5">
                        <select name="items[0][product_id]" class="form-select" required>
                            <option value="">Produit...</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} (Stock: {{ $p->stock_quantity }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="items[0][quantity_ordered]" class="form-control" placeholder="Qté" required min="1">
                    </div>
                    <div class="col-md-2">
                        <input type="number" step="0.01" name="items[0][unit_cost]" class="form-control" placeholder="Coût DH" required min="0">
                    </div>
                    <div class="col-md-2">
                        {{-- الزر مخفي فـ السطر الأول --}}
                        <button type="button" class="btn btn-outline-danger remove-item d-none" disabled>X</button>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-outline-secondary btn-sm mt-2" id="add-item">+ Ajouter un produit</button>

            <div class="mt-4">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="2"></textarea>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-ecloria-primary">Enregistrer l'achat</button>
                <a href="{{ route('admin.purchases.index') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let itemCount = 1;
        const container = document.getElementById('items-container');
        const addButton = document.getElementById('add-item');

        // دالة باش نبنو سطر جديد (زر X ظاهر)
        function createRow(index) {
            const productsHtml = `@foreach($products as $p)<option value="{{ $p->id }}">{{ $p->name }} (Stock: {{ $p->stock_quantity }})</option>@endforeach`;

            const row = document.createElement('div');
            row.className = 'row g-2 mb-2 item-row';
            row.innerHTML = `
                <div class="col-md-5">
                    <select name="items[${index}][product_id]" class="form-select" required>
                        <option value="">Produit...</option>
                        ${productsHtml}
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="items[${index}][quantity_ordered]" class="form-control" placeholder="Qté" required min="1">
                </div>
                <div class="col-md-2">
                    <input type="number" step="0.01" name="items[${index}][unit_cost]" class="form-control" placeholder="Coût DH" required min="0">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger remove-item">X</button>
                </div>
            `;
            return row;
        }

        // زر الإضافة
        addButton.addEventListener('click', function() {
            container.appendChild(createRow(itemCount));
            itemCount++;
        });

        // زر الحذف
        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-item')) {
                const rows = container.querySelectorAll('.item-row');
                if (rows.length > 1) {
                    e.target.closest('.item-row').remove();
                }
            }
        });
    });
</script>
@endpush
@endsection
