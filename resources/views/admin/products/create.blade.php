@extends('layouts.admin')

@section('title', 'Nouveau Produit — Admin')
@section('page-title', 'Nouveau Produit')

@section('content')
<div class="card border-0 shadow-sm max-w-3xl">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.products._form', ['product' => null])

            <div class="mt-4">
                <button type="submit" class="btn btn-ecloria-primary">Enregistrer</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
