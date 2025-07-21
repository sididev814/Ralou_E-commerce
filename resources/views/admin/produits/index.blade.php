@extends('layouts.admin')

@section('title', 'Liste des produits')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Produits</h2>
        <a href="{{ route('admin.produits.create') }}" class="btn btn-primary">+ Ajouter un produit</a>
    </div>

    <div class="table-responsive shadow-sm">
        <table class="table table-bordered table-hover align-middle bg-white">
            <thead class="table-light">
                <tr>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Ajouté le</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produits as $produit)
                    <tr>
                        <td class="text-center" style="width: 80px;">
                            @if($produit->image)
                                <img src="{{ asset('images/' . $produit->image) }}" alt="{{ $produit->nom }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <span class="text-muted">Aucune</span>
                            @endif
                        </td>
                        <td>{{ $produit->nom }}</td>
                        <td>{{ $produit->categorie?->nom ?? 'Non défini' }}</td>
                        <td>{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</td>
                        <td>
                            @if($produit->stock > 0)
                                <span class="badge bg-success">{{ $produit->stock }}</span>
                            @else
                                <span class="badge bg-danger">Rupture</span>
                            @endif
                        </td>
                        <td>{{ $produit->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.produits.edit', $produit->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                            <form action="{{ route('admin.produits.create', $produit->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Confirmer la suppression ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Aucun produit trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
    {{ $produits->links() }}
</div>

</div>
@endsection
