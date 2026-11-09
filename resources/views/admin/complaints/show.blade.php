@extends('layouts.admin')
@section('title', 'Réclamation — Admin')
@section('page-title', 'Réclamation')

@section('content')
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <h5>{{ $complaint->subject }}</h5>
        <p class="text-muted small">De {{ $complaint->user->full_name }} — {{ $complaint->created_at->format('d/m/Y H:i') }}</p>
        <p>{{ $complaint->message }}</p>

        <hr>
        <form method="POST" action="{{ route('admin.complaints.updateStatus', $complaint) }}">
            @csrf @method('PATCH')
            <label class="form-label">Statut</label>
            <div class="d-flex gap-2">
                <select name="status" class="form-select" style="max-width: 200px;">
                    @foreach(['open', 'in_progress', 'resolved', 'closed'] as $st)
                        <option value="{{ $st }}" {{ $complaint->status === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-ecloria-primary">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>

<a href="{{ route('admin.complaints.index') }}" class="btn btn-outline-secondary mt-3">
    <i class="bi bi-arrow-left me-1"></i> Retour
</a>
@endsection
