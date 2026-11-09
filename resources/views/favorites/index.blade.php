@extends('layouts.app')

@section('title', __('messages.my_favorites') . ' — ÉCLORIA')

@section('content')
<div class="container py-5">
    <div class="section-title">
        <h2>{{ __('messages.my_favorites') }}</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($favorites->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-heart" style="font-size: 4rem; color: var(--ecloria-gray);"></i>
            <h3 class="mt-4">{{ __('messages.no_favorites') }}</h3>
            <p class="text-muted">{{ __('messages.add_favorites_hint') }}</p>
            <a href="{{ route('products.index') }}" class="btn btn-ecloria-primary mt-3">
                {{ __('messages.discover_products_btn') }}
            </a>
        </div>
    @else
        <div class="row g-4">
            @foreach($favorites as $favorite)
                @if($favorite->product)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card-ecloria position-relative">
                            <form method="POST" action="{{ route('favorites.toggle', $favorite->product->slug) }}"
                                  class="position-absolute" style="top: 10px; right: 10px; z-index: 2;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-light rounded-circle shadow-sm" title="{{ __('messages.remove') }}">
                                    <i class="bi bi-x-lg text-danger"></i>
                                </button>
                            </form>

                            <a href="{{ route('products.show', $favorite->product->slug) }}" class="text-decoration-none">
                                <div class="card-img-wrapper">
                                    <img src="{{ $favorite->product->image_url }}" alt="{{ $favorite->product->name }}">
                                </div>
                                <div class="card-body">
                                    @if($favorite->product->brand)
                                        <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                            {{ $favorite->product->brand->name }}
                                        </div>
                                    @endif
                                    <div class="card-title">{{ $favorite->product->name }}</div>
                                    <div class="card-price">{{ number_format($favorite->product->price, 2) }} DH</div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
@endsection
