@extends('layouts.admin')

@section('title', 'Tableau de bord Admin')

@section('content')
<div class="container-fluid">
    <!-- Titre + Breadcrumb alignés avec les cartes -->
    <div class="row align-items-center mb-3">
        <div class="col-md-6">
            <h2 class="mb-0">Dashboard</h2>
        </div>
        <div class="col-md-6 text-md-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-md-end mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Cartes statistiques -->
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Produits</h5>
                    <p class="card-text fs-4">{{ $nombreProduits }}</p>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('admin.produits.index') }}" class="text-white text-decoration-none">Voir les produits</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Commandes</h5>
                    <p class="card-text fs-4">{{ $nombreCommandes }}</p>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('admin.commandes.index') }}" class="text-white text-decoration-none">Voir les commandes</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-warning shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Clients</h5>
                    <p class="card-text fs-4">{{ $nombreUsers }}</p>
                </div>
                <div class="card-footer text-end">
                    <span class="text-white">Utilisateurs inscrits</span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-info shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Catégories</h5>
                    <p class="card-text fs-4">{{ $nombreCategories }}</p>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('admin.categories.index') }}" class="text-white text-decoration-none">Voir les catégories</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
