<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Titre *</label>
        <input type="text" name="title" class="form-control" required value="{{ old('title', $promotion->title ?? '') }}">
        @error('title') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label d-block">Statut</label>
        <div class="form-check form-switch mt-2">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                   {{ old('is_active', $promotion->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
    </div>

    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="2">{{ old('description', $promotion->description ?? '') }}</textarea>
    </div>

    <div class="col-md-4">
        <label class="form-label">Type de réduction *</label>
        <select name="discount_type" class="form-select" required>
            <option value="percentage" {{ old('discount_type', $promotion->discount_type ?? '') === 'percentage' ? 'selected' : '' }}>Pourcentage (%)</option>
            <option value="fixed" {{ old('discount_type', $promotion->discount_type ?? '') === 'fixed' ? 'selected' : '' }}>Montant fixe (DH)</option>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Valeur *</label>
        <input type="number" step="0.01" name="discount_value" class="form-control" required value="{{ old('discount_value', $promotion->discount_value ?? '') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Début *</label>
        <input type="datetime-local" name="starts_at" class="form-control" required
               value="{{ old('starts_at', isset($promotion) ? $promotion->starts_at->format('Y-m-d\TH:i') : '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Fin *</label>
        <input type="datetime-local" name="ends_at" class="form-control" required
               value="{{ old('ends_at', isset($promotion) ? $promotion->ends_at->format('Y-m-d\TH:i') : '') }}">
    </div>

    <div class="col-12">
        <label class="form-label">Produits concernés * <small class="text-muted">(Ctrl/Cmd + clic pour sélection multiple)</small></label>
        <select name="product_ids[]" class="form-select" multiple size="8" required>
            @foreach($products as $product)
                <option value="{{ $product->id }}" {{ in_array($product->id, old('product_ids', $selectedProducts)) ? 'selected' : '' }}>
                    {{ $product->name }} — {{ number_format($product->price, 2) }} DH
                </option>
            @endforeach
        </select>
        @error('product_ids') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
</div>
