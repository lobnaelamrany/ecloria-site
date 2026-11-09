@extends('layouts.app')

@section('title', __('messages.new_complaint') . ' — ÉCLORIA')

@section('content')
<div class="container py-5">
    <div class="section-title"><h2>{{ __('messages.new_complaint') }}</h2></div>
    <div class="card border-0 shadow-sm p-4" style="max-width: 700px; margin: 0 auto;">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form method="POST" action="{{ route('client.complaints.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{ __('messages.subject') }} *</label>
                <input type="text" name="subject" class="form-control" required value="{{ old('subject') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('messages.message') }} *</label>
                <textarea name="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
            </div>
            <button type="submit" class="btn btn-ecloria-primary">{{ __('messages.send') }}</button>
            <a href="{{ route('client.complaints.index') }}" class="btn btn-outline-secondary ms-2">{{ __('messages.cancel') }}</a>
        </form>
    </div>
</div>
@endsection
