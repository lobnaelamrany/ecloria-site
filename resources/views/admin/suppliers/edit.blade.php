@extends('layouts.admin')
@section('title', 'Modifier Fournisseur — Admin')
@section('page-title', 'Modifier Fournisseur')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.suppliers.update', $supplier) }}">
            @csrf @method('PUT')
            @include('admin.suppliers._form', ['supplier' => $supplier])
            <div class="mt-4">
                <button type="submit" class="btn btn-ecloria-primary">Mettre à jour</button>
                <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
