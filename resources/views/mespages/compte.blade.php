@extends('layouts.app')

@section('title', 'Mon compte')

@section('content')
    <div class="container py-5">
        <h2>Mon compte</h2>

        @php
            $user = \App\Models\User::find(session('user_id'));
        @endphp

        @if ($user)
            <div class="card mt-4">
                <div class="card-body">
                    <p><strong>Nom :</strong> {{ $user->name }}</p>
                    <p><strong>Email :</strong> {{ $user->email }}</p>
                    <p><strong>Rôle :</strong> {{ $user->role }}</p>
                    <p><strong>Date d’inscription :</strong> {{ $user->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        @else
            <p>Impossible de charger les informations de l'utilisateur.</p>
        @endif
    </div>
@endsection
