@extends('layouts.admin')

@section('title', 'Nouvelle Catégorie — Admin')
@section('page-title', 'Nouvelle Catégorie')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.categories._form', ['category' => null])
            <div class="mt-4">
                <button type="submit" class="btn btn-ecloria-primary">Enregistrer</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
