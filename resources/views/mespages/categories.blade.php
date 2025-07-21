@extends('layouts.app')

@section('title', 'Catégories')

@section('content')
    <h1>Nos Catégories</h1>
    <ul>
        @foreach ($categories as $categorie)
            <li>
                <a href="{{ route('produits') }}?categorie={{ $categorie->id }}">
                    {{ $categorie->nom }}
                </a>
            </li>
        @endforeach
    </ul>
@endsection
