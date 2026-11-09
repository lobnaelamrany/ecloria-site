@extends('layouts.app')

@section('title', __('messages.brands') . ' — ÉCLORIA')

@section('content')
<div class="container py-5">
    <div class="section-title">
        <h2>{{ __('messages.brands') }}</h2>
    </div>

    <div class="row g-4">
        @forelse($brands as $brand)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('brands.show', $brand->slug) }}" class="text-decoration-none">
                    <div class="card-ecloria text-center p-4">
                        @if($brand->logo)
                            @php $img = str_starts_with($brand->logo, 'http') ? $brand->logo : asset('storage/' . $brand->logo); @endphp
                            <img src="{{ $img }}" alt="{{ $brand->name }}" style="height: 80px; object-fit: contain; margin-bottom: 1rem;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" style="height: 80px;">
                                <i class="bi bi-award text-muted" style="font-size: 2rem;"></i>
                            </div>
                        @endif
                        <h5 class="card-title">{{ $brand->name }}</h5>
                        <small class="text-muted">{{ $brand->products_count }} {{ __('messages.products_found') }}</small>
                    </div>
                </a>
            </div>
        @empty
            <p class="text-center text-muted">{{ __('messages.no_products') }}</p>
        @endforelse
    </div>
</div>
@endsection
