<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Prénom *</label>
        <input type="text" name="first_name" class="form-control" required value="{{ old('first_name', $user->first_name ?? '') }}">
        @error('first_name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Nom *</label>
        <input type="text" name="last_name" class="form-control" required value="{{ old('last_name', $user->last_name ?? '') }}">
        @error('last_name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Email *</label>
        <input type="email" name="email" class="form-control" required value="{{ old('email', $user->email ?? '') }}">
        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Téléphone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Mot de passe {{ $user ? '(laisser vide pour ne pas changer)' : '*' }}</label>
        <input type="password" name="password" class="form-control" {{ $user ? '' : 'required' }}>
        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Confirmer le mot de passe</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>

    <div class="col-12">
        <label class="form-label d-block">Permissions</label>
        <div class="row g-2">
            @foreach($permissions as $perm)
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $perm->id }}"
                               id="perm_{{ $perm->id }}"
                               {{ in_array($perm->id, old('permissions', $user->permissions->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="perm_{{ $perm->id }}">{{ $perm->label }}</label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if($user)
        <div class="col-12">
            <label class="form-label d-block">Statut</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Actif</label>
            </div>
        </div>
    @endif
</div>
