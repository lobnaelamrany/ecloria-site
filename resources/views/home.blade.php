@extends('layouts.app')

@section('title', 'ÉCLORIA — Beauté & Soin')

@section('content')

{{-- HERO --}}
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="hero-title">
                    {{ __('messages.hero_title') }}
                </h1>
                <p class="hero-subtitle">
                    {{ __('messages.hero_subtitle') }}
                </p>
                <div class="d-flex gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-ecloria-primary">{{ __('messages.discover_products') }}</a>
                    <a href="#" class="btn btn-ecloria-outline">{{ __('messages.see_promotions') }}</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image">
                    <img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=800&h=800&fit=crop" alt="ÉCLORIA Cosmetics">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CATEGORIES --}}
<section class="py-5">
    <div class="container">
        <div class="section-title">
            <h2>{{ __('messages.our_categories') }}</h2>
        </div>
        <div class="row g-4">
            @forelse($categories as $category)
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="text-decoration-none">
                        <div class="card-ecloria">
                            <div class="card-img-wrapper">
                                @if($category->image)
                                    @php $catImg = str_starts_with($category->image, 'http') ? $category->image : asset('storage/' . $category->image); @endphp
                                    <img src="{{ $catImg }}" alt="{{ $category->name }}">
                                @else
                                    <img src="https://via.placeholder.com/400x533" alt="{{ $category->name }}">
                                @endif
                            </div>
                            <div class="card-body text-center">
                                <div class="card-title">{{ $category->name }}</div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <p class="text-center text-muted">Aucune catégorie disponible.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- FEATURED PRODUCTS --}}
<section class="py-5 bg-ecloria-soft" id="featured">
    <div class="container">
        <div class="section-title">
            <h2>{{ __('messages.best_sellers') }}</h2>
        </div>
        <div class="row g-4">
            @forelse($featuredProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                        <div class="card-ecloria">
                            <div class="card-img-wrapper position-relative">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                @if($discount = $product->active_discount)
                                    <span class="badge-ecloria-promo position-absolute" style="top: 10px; left: 10px; z-index: 2;">
                                        -{{ $discount->promotion->discount_type === 'percentage' ? $discount->promotion->discount_value . '%' : number_format($discount->promotion->discount_value, 0) . ' DH' }}
                                    </span>
                                @endif
                            </div>
                            <div class="card-body">
                                @if($product->brand)
                                    <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                        {{ $product->brand->name }}
                                    </div>
                                @endif
                                <div class="card-title">{{ $product->name }}</div>
                                @if($discount)
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="card-price">{{ number_format($discount->final_price, 2) }} DH</div>
                                        <small class="text-muted text-decoration-line-through">{{ number_format($product->price, 2) }} DH</small>
                                    </div>
                                @else
                                    <div class="card-price">{{ number_format($product->price, 2) }} DH</div>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <p class="text-center text-muted">Aucun produit disponible pour le moment.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- PROMO BANNER --}}
<section class="py-5">
    <div class="container">
        <div class="promo-banner">
            <div>
                <h3 class="mb-2">{{ __('messages.promo_banner_title') }}</h3>
                <p class="mb-0">{{ __('messages.promo_banner_text') }}</p>
            </div>
            <a href="#" class="btn btn-ecloria-gold">{{ __('messages.see_promotions') }}</a>
        </div>
    </div>
</section>

@endsection
