@extends('layouts.admin')
@section('title', 'Réclamations — Admin')
@section('page-title', 'Réclamations')

@section('content')
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Sujet</th>
                    <th>Client</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($complaints as $c)
                    <tr>
                        <td><strong>{{ $c->subject }}</strong></td>
                        <td>{{ $c->user->full_name ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $c->status === 'resolved' || $c->status === 'closed' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ ucfirst($c->status) }}
                            </span>
                        </td>
                        <td><small>{{ $c->created_at->format('d/m/Y') }}</small></td>
                        <td class="text-end">
                            <a href="{{ route('admin.complaints.show', $c) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Voir
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">Aucune réclamation.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $complaints->links() }}</div>
@endsection
