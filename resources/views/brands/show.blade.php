@extends('layouts.app')

@section('title', $brand->name . ' — ÉCLORIA')

@section('content')
<div class="container py-5">
    <div class="section-title">
        <h2>{{ $brand->name }}</h2>
    </div>

    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                    <div class="card-ecloria">
                        <div class="card-img-wrapper">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                        </div>
                        <div class="card-body">
                            <div class="card-title">{{ $product->name }}</div>
                            <div class="card-price">{{ number_format($product->price, 2) }} DH</div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p class="text-center text-muted">{{ __('messages.no_products') }}</p>
        @endforelse
    </div>

    <div class="mt-4">{{ $products->links() }}</div>
</div>
@endsection
