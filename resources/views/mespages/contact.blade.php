@extends('layouts.app')

@section('title', 'Contactez-nous')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Contactez-nous</h1>

    <p>Vous avez une question ? Une suggestion ? N’hésitez pas à nous contacter via le formulaire ci-dessous :</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('contact.send') }}" method="POST" novalidate>
        @csrf

        <div class="mb-3">
            <label for="nom" class="form-label">Votre nom <span class="text-danger">*</span></label>
            <input
                type="text"
                class="form-control @error('nom') is-invalid @enderror"
                id="nom"
                name="nom"
                value="{{ old('nom') }}"
                required
            >
            @error('nom')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Votre email <span class="text-danger">*</span></label>
            <input
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
            <textarea
                class="form-control @error('message') is-invalid @enderror"
                id="message"
                name="message"
                rows="5"
                required
            >{{ old('message') }}</textarea>
            @error('message')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>

    <hr class="my-5">

    <h2>Nos coordonnées</h2>
    <p>
        <strong>Ma boutique Laravel</strong><br>
        Adresse : 123 Rue du Commerce, 75000 Paris, France<br>
        Téléphone : +33 1 23 45 67 89<br>
        Email : contact@boutique-laravel.fr
    </p>

    <h2>Horaires d’ouverture</h2>
    <p>
        Du lundi au vendredi : 9h00 - 18h00<br>
        Samedi : 10h00 - 16h00<br>
        Dimanche : Fermé
    </p>
</div>
@endsection
