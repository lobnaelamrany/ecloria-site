@extends('layouts.admin')
@section('title', 'Nouveau Fournisseur — Admin')
@section('page-title', 'Nouveau Fournisseur')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.suppliers.store') }}">
            @csrf
            @include('admin.suppliers._form', ['supplier' => null])
            <div class="mt-4">
                <button type="submit" class="btn btn-ecloria-primary">Enregistrer</button>
                <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
