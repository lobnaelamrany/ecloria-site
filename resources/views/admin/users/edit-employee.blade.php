@extends('layouts.admin')
@section('title', 'Modifier Employé — Admin')
@section('page-title', 'Modifier Employé')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.users.employees.update', $user) }}">
            @csrf
            @method('PUT')
            @include('admin.users._form', ['user' => $user])
            <div class="mt-4">
                <button type="submit" class="btn btn-ecloria-primary">Mettre à jour</button>
                <a href="{{ route('admin.users.employees') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
