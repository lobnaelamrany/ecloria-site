@extends('layouts.admin')
@section('title', 'Clients — Admin')
@section('page-title', 'Clients')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0" style="font-family: 'Playfair Display', serif;">Liste des clients</h5>
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
                    <th>Téléphone</th>
                    <th>Statut</th>
                    <th>Inscription</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                    <tr>
                        <td><strong>{{ $client->full_name }}</strong></td>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->phone ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $client->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $client->is_active ? 'Actif' : 'Désactivé' }}
                            </span>
                        </td>
                        <td><small>{{ $client->created_at->format('d/m/Y') }}</small></td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('admin.users.clients.toggle', $client) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $client->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                    {{ $client->is_active ? 'Désactiver' : 'Activer' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Aucun client trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $clients->links() }}</div>
@endsection
