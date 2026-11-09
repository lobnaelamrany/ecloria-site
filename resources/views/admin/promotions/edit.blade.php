@extends('layouts.admin')
@section('title', 'Modifier Promotion — Admin')
@section('page-title', 'Modifier Promotion')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.promotions.update', $promotion) }}">
            @csrf @method('PUT')
            @include('admin.promotions._form', ['promotion' => $promotion, 'selectedProducts' => $selectedProducts])
            <div class="mt-4">
                <button type="submit" class="btn btn-ecloria-primary">Mettre à jour</button>
                <a href="{{ route('admin.promotions.index') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
