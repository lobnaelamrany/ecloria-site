@extends('layouts.admin')

@section('title', 'Modifier Marque — Admin')
@section('page-title', 'Modifier Marque')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.brands.update', $brand) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.brands._form', ['brand' => $brand])
            <div class="mt-4">
                <button type="submit" class="btn btn-ecloria-primary">Mettre à jour</button>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
