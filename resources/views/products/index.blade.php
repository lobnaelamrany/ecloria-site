@extends('layouts.app')

@section('title', __('messages.our_products') . ' — ÉCLORIA')

@section('content')
<div class="container py-5">
    <div class="section-title">
        <h2>{{ __('messages.our_products') }}</h2>
    </div>
    <div class="row g-4">
        {{-- Sidebar فلاتر --}}
        <div class="col-lg-3">
            <div class="filter-card">
                <h5 class="filter-title">{{ __('messages.filters') }}</h5>

                <form method="GET" action="{{ route('products.index') }}">
                    {{-- Search --}}
                    <div class="mb-3">
                        <label class="form-label small">{{ __('messages.search') }}</label>
                        <input type="text" name="search" class="form-control form-control-sm"
                               value="{{ request('search') }}" placeholder="{{ __('messages.search_placeholder') }}">
                    </div>

                    {{-- Categories --}}
                    <div class="mb-3">
                        <label class="form-label small">{{ __('messages.categories') }}</label>
                        <select name="category" class="form-select form-select-sm">
                            <option value="">{{ __('messages.all_categories') }}</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Brands --}}
                    <div class="mb-3">
                        <label class="form-label small">{{ __('messages.brands') }}</label>
                        <select name="brand" class="form-select form-select-sm">
                            <option value="">{{ __('messages.all_categories') }}</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->slug }}" {{ request('brand') === $brand->slug ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sort --}}
                    <div class="mb-3">
                        <label class="form-label small">{{ __('messages.sort_by') }}</label>
                        <select name="sort" class="form-select form-select-sm">
                            <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>{{ __('messages.newest') }}</option>
                            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>{{ __('messages.price_asc') }}</option>
                            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>{{ __('messages.price_desc') }}</option>
                            <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>{{ __('messages.name_asc') }}</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-ecloria-primary btn-sm w-100">{{ __('messages.apply') }}</button>
                    <a href="{{ route('products.index') }}" class="btn btn-link btn-sm w-100 mt-1">{{ __('messages.reset') }}</a>
                </form>
            </div>
        </div>

        {{-- Products Grid --}}
        <div class="col-lg-9">
            @if($products->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-search" style="font-size: 3rem; color: var(--ecloria-gray);"></i>
                    <p class="mt-3 text-muted">{{ __('messages.no_products') }}</p>
                </div>
            @else
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <small class="text-muted">{{ $products->total() }} {{ __('messages.products_found') }}</small>
                </div>

                <div class="row g-4">
                    @foreach($products as $product)
                        <div class="col-6 col-md-4">
                            <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                                <div class="card-ecloria">
                                    <div class="card-img-wrapper position-relative">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                        {{-- شارة التخفيض --}}
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

                                        {{-- السعر مع الخصم --}}
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
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
