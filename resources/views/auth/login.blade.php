@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card border-0 shadow-lg p-5" style="width: 100%; max-width: 500px; border-radius: 1rem;">
        <h3 class="text-center mb-4 text-primary fw-semibold">
            <i class="fa-solid fa-right-to-bracket me-2"></i>Connexion
        </h3>

        @if (session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email" name="email" class="form-control form-control-lg" placeholder="exemple@mail.com" required>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control form-control-lg" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-3" style="border-radius: 30px; font-weight: 500;">
                Se connecter
            </button>
        </form>
    </div>
</div>
@endsection
