@extends('layouts.admin')

@section('title', 'Nouvelle Marque — Admin')
@section('page-title', 'Nouvelle Marque')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.brands.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.brands._form', ['brand' => null])
            <div class="mt-4">
                <button type="submit" class="btn btn-ecloria-primary">Enregistrer</button>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
