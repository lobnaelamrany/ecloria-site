<div class="row g-3">
    {{-- Nom --}}
    <div class="col-md-8">
        <label class="form-label">Nom du produit (FR) *</label>
        <input type="text" name="name_fr" class="form-control" required
               value="{{ old('name_fr', $product->name_fr ?? '') }}">
        @error('name_fr') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- SKU --}}
    <div class="col-md-4">
        <label class="form-label">SKU (Référence) *</label>
        <input type="text" name="sku" class="form-control" required
               value="{{ old('sku', $product->sku ?? 'ECL-' . rand(1000, 9999)) }}">
        @error('sku') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- Category --}}
    <div class="col-md-6">
        <label class="form-label">Catégorie *</label>
        <select name="category_id" class="form-select" required>
            <option value="">Sélectionner...</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
        @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- Brand --}}
    <div class="col-md-6">
        <label class="form-label">Marque (Optionnel)</label>
        <select name="brand_id" class="form-select">
            <option value="">Aucune</option>
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                    {{ $brand->name }}
                </option>
            @endforeach
        </select>
        @error('brand_id') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- Price --}}
    <div class="col-md-4">
        <label class="form-label">Prix (DH) *</label>
        <input type="number" step="0.01" name="price" class="form-control" required
               value="{{ old('price', $product->price ?? '') }}">
        @error('price') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- Stock --}}
    <div class="col-md-4">
        <label class="form-label">Quantité en stock *</label>
        <input type="number" name="stock_quantity" class="form-control" required
               value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}">
        @error('stock_quantity') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- Low Stock --}}
    <div class="col-md-4">
        <label class="form-label">Seuil d'alerte *</label>
        <input type="number" name="low_stock_threshold" class="form-control" required
               value="{{ old('low_stock_threshold', $product->low_stock_threshold ?? 5) }}">
        @error('low_stock_threshold') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- Description --}}
    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description_fr" class="form-control" rows="4">{{ old('description_fr', $product->description_fr ?? '') }}</textarea>
    </div>

    {{-- Image --}}
    <div class="col-md-6">
        <label class="form-label">Image du produit</label>
        <input type="file" name="image" class="form-control" accept="image/*">
        @error('image') <small class="text-danger">{{ $message }}</small> @enderror
        @if($product && $product->image)
            @php $imgUrl = str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image); @endphp
            <div class="mt-2">
                <img src="{{ $imgUrl }}" style="width: 80px; height: 100px; object-fit: cover; border-radius: 4px;">
                <small class="text-muted d-block">Image actuelle</small>
            </div>
        @endif
    </div>

    {{-- Statut --}}
    <div class="col-md-6">
        <label class="form-label d-block">Statut</label>
        <div class="form-check form-switch mt-2">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                   {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Produit Actif (Visible en boutique)</label>
        </div>
    </div>
</div>
