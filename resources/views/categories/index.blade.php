@extends('layouts.app')

@section('title', __('messages.categories') . ' — ÉCLORIA')

@section('content')
<div class="container py-5">
    <div class="section-title">
        <h2>{{ __('messages.categories') }}</h2>
    </div>

    <div class="row g-4">
        @forelse($categories as $category)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('categories.show', $category->slug) }}" class="text-decoration-none">
                    <div class="card-ecloria">
                        <div class="card-img-wrapper">
                            @if($category->image)
                                @php $img = str_starts_with($category->image, 'http') ? $category->image : asset('storage/' . $category->image); @endphp
                                <img src="{{ $img }}" alt="{{ $category->name }}">
                            @else
                                <img src="https://via.placeholder.com/400x533" alt="{{ $category->name }}">
                            @endif
                        </div>
                        <div class="card-body text-center">
                            <div class="card-title">{{ $category->name }}</div>
                            <small class="text-muted">{{ $category->products_count }} {{ __('messages.products_found') }}</small>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p class="text-center text-muted">{{ __('messages.no_products') }}</p>
        @endforelse
    </div>
</div>
@endsection
