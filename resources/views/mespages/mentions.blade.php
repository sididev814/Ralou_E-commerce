@extends('layouts.app')

@section('title', 'Mentions Légales')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Mentions Légales</h1>

    <p>Bienvenue sur le site <strong>Ma boutique Laravel</strong>. Conformément à la loi, nous vous informons que :</p>

    <h2>Éditeur du site</h2>
    <p>
        <strong>Ma boutique Laravel</strong><br>
        Adresse : 123 Rue du Commerce, 75000 Paris, France<br>
        Téléphone : +33 1 23 45 67 89<br>
        Email : contact@boutique-laravel.fr<br>
        Directeur de la publication : M. Jean Dupont
    </p>

    <h2>Hébergement</h2>
    <p>
        Le site est hébergé par :<br>
        <strong>OVH SAS</strong><br>
        Adresse : 2 rue Kellermann - 59100 Roubaix - France<br>
        Téléphone : +33 9 72 10 10 07
    </p>

    <h2>Propriété intellectuelle</h2>
    <p>
        Tous les contenus présents sur ce site (textes, images, logos, vidéos, etc.) sont la propriété exclusive de Ma boutique Laravel ou de leurs auteurs respectifs.<br>
        Toute reproduction, distribution, modification ou utilisation sans autorisation est strictement interdite.
    </p>

    <h2>Protection des données personnelles</h2>
    <p>
        Les informations recueillies sur ce site sont destinées à Ma boutique Laravel pour le traitement des commandes et la gestion des clients.<br>
        Conformément à la réglementation RGPD, vous disposez d’un droit d’accès, de rectification et de suppression de vos données.<br>
        Pour exercer ces droits, veuillez nous contacter à l'adresse email ci-dessus.
    </p>

    <h2>Cookies</h2>
    <p>
        Ce site utilise des cookies pour améliorer votre expérience utilisateur et réaliser des statistiques de visite.<br>
        Vous pouvez configurer votre navigateur pour refuser les cookies.
    </p>

    <h2>Responsabilité</h2>
    <p>
        Ma boutique Laravel ne saurait être tenue responsable des dommages résultant de l’utilisation du site ou des informations qu’il contient.
    </p>
</div>
@endsection
