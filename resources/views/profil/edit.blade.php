@extends('layouts.app')

@section('title', 'Modifier mon profil')

@section('content')
<div class="container py-5">
    <h2 class="mb-4"><i class="bi bi-pencil-square"></i> Modifier profil</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profil.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nom complet</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Adresse email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe (laisser vide pour ne pas changer)</label>
            <input type="password" name="password" id="password" class="form-control" autocomplete="new-password">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('compte') }}" class="btn btn-secondary ms-2">Annuler</a>
    </form>
</div>
@endsection
