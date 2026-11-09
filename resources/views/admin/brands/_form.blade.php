<div class="row g-3">
    <div class="col-12">
        <label class="form-label">Nom de la marque *</label>
        <input type="text" name="name" class="form-control" required value="{{ old('name', $brand->name ?? '') }}">
        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $brand->description ?? '') }}</textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label">Logo</label>
        <input type="file" name="logo" class="form-control" accept="image/*">
        @error('logo') <small class="text-danger">{{ $message }}</small> @enderror
        @if($brand && $brand->logo)
            @php $imgUrl = str_starts_with($brand->logo, 'http') ? $brand->logo : asset('storage/' . $brand->logo); @endphp
            <div class="mt-2">
                <img src="{{ $imgUrl }}" style="width: 80px; height: 80px; object-fit: contain; border-radius: 4px; background: #f5f5f5;">
            </div>
        @endif
    </div>

    <div class="col-md-6">
        <label class="form-label d-block">Statut</label>
        <div class="form-check form-switch mt-2">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                   {{ old('is_active', $brand->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Actif</label>
        </div>
    </div>
</div>
