@extends('layouts.app')

@section('title', 'Mon compte')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 d-flex justify-content-between align-items-center">
        <span class="d-flex align-items-center gap-2">
            <i class="bi bi-person-circle fs-2"></i> Mon compte
        </span>
        <a href="{{ route('profil.edit') }}" class="btn btn-secondary d-flex align-items-center gap-2">
            <i class="bi bi-pencil-square"></i> Modifier profil
        </a>
    </h2>

    @if(Auth::check())
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-primary text-white d-flex align-items-center gap-2">
                <i class="bi bi-info-circle-fill fs-4"></i>
                <h5 class="mb-0">Informations personnelles</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex align-items-center">
                        <i class="bi bi-person-fill me-3 text-primary fs-5"></i>
                        <div>
                            <strong>Nom complet :</strong>
                            <p class="mb-0 text-muted">{{ Auth::user()->name }}</p>
                        </div>
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <i class="bi bi-envelope-fill me-3 text-primary fs-5"></i>
                        <div>
                            <strong>Email :</strong>
                            <p class="mb-0 text-muted">{{ Auth::user()->email }}</p>
                        </div>
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <i class="bi bi-shield-lock-fill me-3 text-primary fs-5"></i>
                        <div>
                            <strong>Rôle :</strong>
                            <span class="badge bg-info">{{ Auth::user()->role }}</span>
                        </div>
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <i class="bi bi-calendar-event-fill me-3 text-primary fs-5"></i>
                        <div>
                            <strong>Date d’inscription :</strong>
                            <p class="mb-0 text-muted">{{ Auth::user()->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('accueil') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                <i class="bi bi-house-door-fill"></i> Retour à l'accueil
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger d-flex align-items-center gap-2">
                    <i class="bi bi-box-arrow-right"></i> Se déconnecter
                </button>
            </form>
        </div>
    @else
        <div class="alert alert-warning d-flex align-items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill"></i>
            Vous devez être connecté pour voir cette page.
        </div>
        <a href="{{ route('login') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="bi bi-box-arrow-in-right"></i> Se connecter
        </a>
    @endif
</div>
@endsection
