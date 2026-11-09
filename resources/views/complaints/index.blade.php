@extends('layouts.app')

@section('title', __('messages.my_complaints') . ' — ÉCLORIA')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="section-title mb-0"><h2>{{ __('messages.my_complaints') }}</h2></div>
        <a href="{{ route('client.complaints.create') }}" class="btn btn-ecloria-primary">{{ __('messages.new_complaint') }}</a>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    @if($complaints->isEmpty())
        <p class="text-muted text-center py-4">{{ __('messages.no_complaints') }}</p>
    @else
        <div class="orders-list">
            @foreach($complaints as $c)
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <h5 class="mb-1">{{ $c->subject }}</h5>
                            <small class="text-muted">{{ $c->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <span class="badge {{ $c->status === 'resolved' || $c->status === 'closed' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ ucfirst($c->status) }}
                        </span>
                    </div>
                    <div class="order-body">
                        <p class="mb-0 small">{{ Str::limit($c->message, 150) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $complaints->links() }}</div>
    @endif
</div>
@endsection
