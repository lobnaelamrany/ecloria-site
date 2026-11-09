@extends('layouts.app')

@section('title', $product->name . ' — ÉCLORIA')

@section('content')
<div class="container py-5">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('messages.shop') }}</a></li>
            @if($product->category)
                <li class="breadcrumb-item">
                    <a href="{{ route('products.index', ['category' => $product->category->slug]) }}">
                        {{ $product->category->name }}
                    </a>
                </li>
            @endif
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        {{-- Image --}}
        <div class="col-md-6">
            <div class="product-image-large position-relative">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
            </div>
        </div>

        {{-- Details --}}
        <div class="col-md-6">
            @if($product->brand)
                <a href="{{ route('products.index', ['brand' => $product->brand->slug]) }}"
                   class="text-muted text-decoration-none" style="text-transform: uppercase; letter-spacing: 1px; font-size: 0.85rem;">
                    {{ $product->brand->name }}
                </a>
            @endif

            <h1 class="mt-2 mb-3">{{ $product->name }}</h1>

            {{-- السعر مع الخصم --}}
            @php $discount = $product->active_discount; @endphp
            @if($discount)
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="product-price-large text-ecloria-rose">{{ number_format($discount->final_price, 2) }} DH</div>
                    <div class="text-muted text-decoration-line-through fs-5">{{ number_format($product->price, 2) }} DH</div>
                    <span class="badge-ecloria-promo">
                        -{{ $discount->promotion->discount_type === 'percentage' ? $discount->promotion->discount_value . '%' : number_format($discount->promotion->discount_value, 0) . ' DH' }}
                    </span>
                </div>
            @else
                <div class="product-price-large mb-3">{{ number_format($product->price, 2) }} DH</div>
            @endif

            <p class="text-muted mt-4">{{ $product->description }}</p>

            {{-- Stock --}}
            <div class="mt-4">
                @if($product->stock_quantity > 0)
                    <span class="badge bg-success">
                        <i class="bi bi-check-circle me-1"></i> {{ __('messages.in_stock') }} ({{ $product->stock_quantity }})
                    </span>
                @else
                    <span class="badge bg-danger">
                        <i class="bi bi-x-circle me-1"></i> {{ __('messages.out_of_stock') }}
                    </span>
                @endif
            </div>

            {{-- Actions --}}
            <div class="d-flex gap-3 mt-4">
                <form method="POST" action="{{ route('cart.add', $product->slug) }}" class="flex-grow-1 d-flex gap-2">
                    @csrf
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}"
                           class="form-control" style="max-width: 80px;" {{ $product->stock_quantity === 0 ? 'disabled' : '' }}>
                    <button type="submit" class="btn btn-ecloria-primary flex-grow-1" {{ $product->stock_quantity === 0 ? 'disabled' : '' }}>
                        <i class="bi bi-bag-plus me-2"></i> {{ __('messages.add_to_cart') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('favorites.toggle', $product->slug) }}">
                    @csrf
                    <button type="submit" class="btn btn-ecloria-outline" title="{{ __('messages.favorites') }}">
                        <i class="bi bi-heart"></i>
                    </button>
                </form>
            </div>

            {{-- Meta --}}
            <div class="mt-4 pt-4 border-top">
                <small class="text-muted d-block">SKU: {{ $product->sku }}</small>
                @if($product->category)
                    <small class="text-muted d-block">{{ __('messages.categories') }}: {{ $product->category->name }}</small>
                @endif
            </div>
        </div>
    </div>

    {{-- Avis clients --}}
    <div class="mt-5 pt-5 border-top">
        <div class="section-title">
            <h2>{{ __('messages.reviews') }}</h2>
        </div>
        @forelse($product->reviews->where('is_visible', true) as $review)
            <div class="border-bottom py-3">
                <div class="d-flex justify-content-between">
                    <strong>{{ $review->user->full_name ?? 'Client' }}</strong>
                    <span class="text-warning">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                        @endfor
                    </span>
                </div>
                <p class="mb-0 text-muted small">{{ $review->created_at->format('d/m/Y') }}</p>
                @if($review->comment)
                    <p class="mt-2 mb-0">{{ $review->comment }}</p>
                @endif
            </div>
        @empty
            <p class="text-muted text-center">{{ __('messages.no_reviews') }}</p>
        @endforelse
    </div>

    {{-- Related products --}}
    @if($relatedProducts->isNotEmpty())
        <div class="mt-5 pt-5 border-top">
            <div class="section-title">
                <h2>{{ __('messages.related_products') }}</h2>
            </div>
            <div class="row g-4">
                @foreach($relatedProducts as $related)
                    <div class="col-6 col-md-3">
                        <a href="{{ route('products.show', $related->slug) }}" class="text-decoration-none">
                            <div class="card-ecloria">
                                <div class="card-img-wrapper position-relative">
                                    <img src="{{ $related->image_url }}" alt="{{ $related->name }}">
                                    @if($relDiscount = $related->active_discount)
                                        <span class="badge-ecloria-promo position-absolute" style="top: 10px; left: 10px; z-index: 2;">
                                            -{{ $relDiscount->promotion->discount_type === 'percentage' ? $relDiscount->promotion->discount_value . '%' : number_format($relDiscount->promotion->discount_value, 0) . ' DH' }}
                                        </span>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="card-title">{{ $related->name }}</div>

                                    @if($relDiscount)
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="card-price">{{ number_format($relDiscount->final_price, 2) }} DH</div>
                                            <small class="text-muted text-decoration-line-through">{{ number_format($related->price, 2) }} DH</small>
                                        </div>
                                    @else
                                        <div class="card-price">{{ number_format($related->price, 2) }} DH</div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
