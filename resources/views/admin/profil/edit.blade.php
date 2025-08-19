@extends('layouts.admin')

@section('title', 'Modifier Profil Admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Modifier mon profil</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.profil.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nom complet</label>
            <input type="text" id="name" name="name" 
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', auth()->user()->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Adresse Email</label>
            <input type="email" id="email" name="email" 
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', auth()->user()->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Nouveau mot de passe <small>(laisser vide pour ne pas changer)</small></label>
            <input type="password" id="password" name="password" 
                class="form-control @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmer mot de passe</label>
            <input type="password" id="password_confirmation" name="password_confirmation" 
                class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Modifier mon profil</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary ms-2">Retour au dashboard</a>
    </form>
</div>
@endsection
