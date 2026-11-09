@extends('layouts.admin')
@section('title', 'Nouvel Employé — Admin')
@section('page-title', 'Nouvel Employé')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.users.employees.store') }}">
            @csrf
            @include('admin.users._form', ['user' => null])
            <div class="mt-4">
                <button type="submit" class="btn btn-ecloria-primary">Créer</button>
                <a href="{{ route('admin.users.employees') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
