@extends('layouts.admin')

@section('title', 'Modifier Catégorie — Admin')
@section('page-title', 'Modifier Catégorie')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.categories._form', ['category' => $category])
            <div class="mt-4">
                <button type="submit" class="btn btn-ecloria-primary">Mettre à jour</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
