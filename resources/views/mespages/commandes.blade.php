@extends('layouts.app')

@section('title', 'Mes commandes')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Historique des commandes</h2>

    @if ($commandes->count() > 0)
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Numéro</th>
                    <th>Date</th>
                    <th>Total (MAD)</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($commandes as $commande)
                    <tr>
                        <td>{{ $commande->id }}</td>
                        <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ number_format($commande->total, 2, ',', ' ') }}</td>
                        <td>{{ ucfirst($commande->statut) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Aucune commande trouvée.</p>
    @endif
</div>
@endsection
