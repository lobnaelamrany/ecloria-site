@extends('layouts.admin')
@section('title', 'Nouvelle Promotion — Admin')
@section('page-title', 'Nouvelle Promotion')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.promotions.store') }}">
            @csrf
            @include('admin.promotions._form', ['promotion' => null, 'selectedProducts' => []])
            <div class="mt-4">
                <button type="submit" class="btn btn-ecloria-primary">Enregistrer</button>
                <a href="{{ route('admin.promotions.index') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
