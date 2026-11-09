<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nom du fournisseur *</label>
        <input type="text" name="name" class="form-control" required value="{{ old('name', $supplier->name ?? '') }}">
        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Personne de contact</label>
        <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person', $supplier->contact_person ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $supplier->email ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Téléphone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $supplier->phone ?? '') }}">
    </div>
    <div class="col-md-8">
        <label class="form-label">Adresse</label>
        <input type="text" name="address" class="form-control" value="{{ old('address', $supplier->address ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Ville</label>
        <input type="text" name="city" class="form-control" value="{{ old('city', $supplier->city ?? '') }}">
    </div>
    <div class="col-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $supplier->notes ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                   {{ old('is_active', $supplier->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Actif</label>
        </div>
    </div>
</div>
