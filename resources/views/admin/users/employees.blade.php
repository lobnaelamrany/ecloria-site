@extends('layouts.admin')
@section('title', 'Employés — Admin')
@section('page-title', 'Employés')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0" style="font-family: 'Playfair Display', serif;">Liste des employés</h5>
    <a href="{{ route('admin.users.employees.create') }}" class="btn btn-ecloria-primary">
        <i class="bi bi-plus-lg me-1"></i> Nouvel employé
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Permissions</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $emp)
                    <tr>
                        <td><strong>{{ $emp->full_name }}</strong></td>
                        <td>{{ $emp->email }}</td>
                        <td>
                            @foreach($emp->permissions as $perm)
                                <span class="badge bg-info" style="font-size: 0.7rem;">{{ $perm->label }}</span>
                            @endforeach
                            @if($emp->permissions->isEmpty())
                                <small class="text-muted">Aucune permission</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $emp->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $emp->is_active ? 'Actif' : 'Désactivé' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.users.employees.edit', $emp) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.users.employees.destroy', $emp) }}" class="d-inline" onsubmit="return confirm('Supprimer cet employé ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">Aucun employé trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $employees->links() }}</div>
@endsection
