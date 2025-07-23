<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Ma boutique Laravel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
    header {
        background-color: #343a40;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 1rem;
        overflow-x: visible;
    }

    nav ul {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        gap: 1rem;
        align-items: center;
        white-space: nowrap;
    }

    nav ul li {
        flex-shrink: 0;
    }

    nav ul li a {
        color: #ffffff;
        text-decoration: none;
        font-weight: 500;
        padding: 6px 10px;
        border-radius: 8px;
        transition: background-color 0.3s ease;
        display: inline-block;
        font-size: 0.9rem;
    }

    nav ul li a:hover {
        background-color: #495057;
    }

    nav .panier-icon a {
        font-size: 1.2rem;
        color: #ffc107;
        transition: color 0.3s ease;
    }

    nav .panier-icon a:hover {
        color: #fff;
    }

    .user-welcome {
        color: white;
        font-weight: bold;
        font-size: 0.95rem;
        margin-right: 1rem;
        white-space: nowrap;
    }

    /* Badge panier */
    .badge.bg-danger {
        font-size: 0.7rem;
        padding: 2px 6px;
        border-radius: 50%;
        color: white;
        background-color: #dc3545 !important;
    }

    /* Footer amélioré */
    footer {
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
        padding: 15px 0;
    }

    footer a {
        color: #343a40;
        margin: 0 10px;
        text-decoration: none;
        font-weight: 500;
    }

    footer a:hover {
        text-decoration: underline;
    }
    html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
}

main {
    flex: 1;
}


    /* Bouton WhatsApp flottant */
    .whatsapp-float {
        position: fixed;
        bottom: 25px;
        right: 25px;
        background-color: #25d366;
        color: white;
        border-radius: 50%;
        padding: 15px 18px;
        font-size: 24px;
        z-index: 1000;
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        transition: background-color 0.3s ease;
    }

    .whatsapp-float:hover {
        background-color: #1ebe57;
        color: white;
        text-decoration: none;
    }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="{{ route('accueil') }}">Accueil</a></li>
                <li><a href="{{ route('produits') }}">Nos Produits</a></li>
                <li><a href="{{ route('categories.index') }}">Catégories</a></li>

                <li>
                    <form action="{{ route('produits') }}" method="GET" style="display:flex;">
                        <input type="search" name="search" placeholder="Rechercher..."
                               style="padding: 3px 6px; border-radius: 4px 0 0 4px; border: 1px solid #ccc; outline:none; font-size: 0.9rem;"
                               value="{{ request('search') }}">
                        <button type="submit"
                                style="padding: 3px 8px; border:none; background-color:#ffc107; color:#fff; border-radius: 0 4px 4px 0; cursor:pointer;">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </li>

                <li>
                    <div class="panier-icon position-relative">
                        <a href="{{ route('panier') }}">
                            <i class="fa-solid fa-cart-shopping fa-lg"></i>
                            @php
                                $totalQuantite = 0;
                                $panier = session()->get('panier', []);
                                foreach ($panier as $item) {
                                    $totalQuantite += $item['quantite'];
                                }
                            @endphp
                            @if($totalQuantite > 0)
                                <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                                    {{ $totalQuantite }}
                                </span>
                            @endif
                        </a>
                    </div>
                </li>

                @auth
                    <li class="user-welcome">
                        Bienvenue, {{ Auth::user()->name }}
                        <i class="fa-solid fa-user-circle text-warning ms-2"></i>
                    </li>

                    <li><a href="{{ route('compte') }}">Profil</a></li>
                    <li><a href="{{ route('commandes') }}">Mes commandes</a></li>

                    @if(Auth::user()->is_admin)
                        <li><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                    @endif

                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Se déconnecter
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Se connecter</a></li>
                    <li><a href="{{ route('register') }}">S'inscrire</a></li>
                @endauth
            </ul>
        </nav>
    </header>

    <main class="container-fluid mt-4">
        @yield('content')
    </main>

    <footer class="text-center">
        <div class="container d-flex justify-content-center align-items-center">
            <a href="{{ route('mentions') }}">Mentions légales</a>
            <a href="{{ route('contact') }}">Contact</a>
        </div>
        <small class="d-block mt-2">&copy; {{ date('Y') }} - Ma boutique Laravel</small>
    </footer>

    {{-- Bouton WhatsApp flottant --}}
    <a href="https://wa.me/212617783661" target="_blank" class="whatsapp-float" title="Contactez-nous sur WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
