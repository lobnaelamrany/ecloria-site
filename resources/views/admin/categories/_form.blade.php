<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Nom (FR) *</label>
        <input type="text" name="name_fr" class="form-control" required value="{{ old('name_fr', $category->name_fr ?? '') }}">
        @error('name_fr') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Nom (EN)</label>
        <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $category->name_en ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Nom (DE)</label>
        <input type="text" name="name_de" class="form-control" value="{{ old('name_de', $category->name_de ?? '') }}">
    </div>

    <div class="col-12">
        <label class="form-label">Description (FR)</label>
        <textarea name="description_fr" class="form-control" rows="3">{{ old('description_fr', $category->description_fr ?? '') }}</textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label">Image</label>
        <input type="file" name="image" class="form-control" accept="image/*">
        @error('image') <small class="text-danger">{{ $message }}</small> @enderror
        @if($category && $category->image)
            @php $imgUrl = str_starts_with($category->image, 'http') ? $category->image : asset('storage/' . $category->image); @endphp
            <div class="mt-2">
                <img src="{{ $imgUrl }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
            </div>
        @endif
    </div>

    <div class="col-md-6">
        <label class="form-label d-block">Statut</label>
        <div class="form-check form-switch mt-2">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                   {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Actif</label>
        </div>
    </div>
</div>
