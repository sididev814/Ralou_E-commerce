@extends('layouts.admin')

@section('title', 'Modifier le produit')

@section('content')
<div class="container">
    <h1 class="mb-4">Modifier le produit</h1>

    {{-- Affichage des erreurs de validation --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops !</strong> Veuillez corriger les erreurs suivantes :
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.produits.update', $produit->id) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')

        <div class="card shadow-sm p-4 border rounded-3">
            {{-- Nom --}}
            <div class="mb-4">
                <label for="nom" class="form-label fw-semibold">Nom du produit <span class="text-danger">*</span></label>
                <input
                    type="text"
                    class="form-control @error('nom') is-invalid @enderror"
                    id="nom"
                    name="nom"
                    value="{{ old('nom', $produit->nom) }}"
                    required
                    placeholder="Ex : Smartphone XYZ"
                >
                @error('nom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Prix --}}
            <div class="mb-4">
                <label for="prix" class="form-label fw-semibold">Prix (F CFA) <span class="text-danger">*</span></label>
                <input
                    type="number"
                    step="0.01"
                    class="form-control @error('prix') is-invalid @enderror"
                    id="prix"
                    name="prix"
                    value="{{ old('prix', $produit->prix) }}"
                    required
                    placeholder="Ex : 15000"
                    min="0"
                >
                @error('prix')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label for="description" class="form-label fw-semibold">Description</label>
                <textarea
                    class="form-control @error('description') is-invalid @enderror"
                    id="description"
                    name="description"
                    rows="5"
                    placeholder="Description détaillée du produit"
                >{{ old('description', $produit->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Stock --}}
            <div class="mb-4">
                <label for="stock" class="form-label fw-semibold">Quantité en stock <span class="text-danger">*</span></label>
                <input
                    type="number"
                    class="form-control @error('stock') is-invalid @enderror"
                    id="stock"
                    name="stock"
                    value="{{ old('stock', $produit->stock) }}"
                    required
                    min="0"
                >
                @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Catégorie --}}
            <div class="mb-4">
                <label for="categorie_produit_id" class="form-label fw-semibold">Catégorie <span class="text-danger">*</span></label>
                <select
                    class="form-select @error('categorie_produit_id') is-invalid @enderror"
                    id="categorie_produit_id"
                    name="categorie_produit_id"
                    required
                >
                    <option value="" disabled {{ old('categorie_produit_id', $produit->categorie_produit_id) ? '' : 'selected' }}>Sélectionnez une catégorie</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id }}" {{ old('categorie_produit_id', $produit->categorie_produit_id) == $categorie->id ? 'selected' : '' }}>
                            {{ $categorie->nom }}
                        </option>
                    @endforeach
                </select>
                @error('categorie_produit_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Image --}}
            <div class="mb-4">
                <label for="image" class="form-label fw-semibold">Photo du produit (JPEG, PNG)</label>
                <input
                    class="form-control @error('image') is-invalid @enderror"
                    type="file"
                    id="image"
                    name="image"
                    accept="image/jpeg,image/png,image/jpg"
                >
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Taille max : 2 Mo</div>

                {{-- Affichage de l'image actuelle --}}
                @if ($produit->image)
                    <div class="mt-3">
                        <p>Image actuelle :</p>
                        <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" class="img-thumbnail" style="max-width: 150px; height: auto;">
                    </div>
                @endif
            </div>

            {{-- Boutons --}}
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('admin.produits.index') }}" class="btn btn-outline-secondary">
                    <i class="fa fa-arrow-left me-1"></i> Retour à la liste
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save me-1"></i> Enregistrer les modifications
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
