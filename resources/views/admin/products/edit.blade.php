@extends('layouts.admin')

@section('title', 'Modifier Produit — Admin')
@section('page-title', 'Modifier le Produit')

@section('content')
<div class="card border-0 shadow-sm max-w-3xl">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.products._form', ['product' => $product])

            <div class="mt-4">
                <button type="submit" class="btn btn-ecloria-primary">Mettre à jour</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
