<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin - Ma boutique')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 + Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        .admin-wrapper {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            width: 240px;
            background-color: #212529;
            color: #fff;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }

        .sidebar h4 {
            padding: 1.2rem;
            text-align: center;
            border-bottom: 1px solid #444;
        }

        .sidebar a {
            padding: 1rem 1.5rem;
            color: #fff;
            text-decoration: none;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #343a40;
        }

        .content-area {
            flex: 1;
            overflow-y: auto;
            background-color: #f8f9fa;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 1030;
            background-color: #fff;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #dee2e6;
        }

        .main-content {
            padding: 2rem;
        }
    </style>
</head>
<body>

<div class="admin-wrapper">

    <!-- Sidebar -->
    <aside class="sidebar">
        <h4>Admin Panel</h4>
        <a href="{{ route('admin.dashboard') }}"><i class="fa fa-chart-line me-2"></i> Dashboard</a>
        <a href="{{ route('admin.produits.index') }}"><i class="fa fa-box me-2"></i> Produits</a>
        <a href="{{ route('admin.categories.index') }}"><i class="fa fa-list me-2"></i> Catégories</a>
        <a href="{{ route('admin.commandes.index') }}"><i class="fa fa-shopping-cart me-2"></i> Commandes</a>
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
           <i class="fa fa-sign-out-alt me-2"></i> Déconnexion
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </aside>

    <!-- Content Area -->
    <div class="content-area">
       <div class="topbar d-flex justify-content-between align-items-center">
    <span><i class="fa fa-user-circle me-2"></i> Bienvenue, {{ Auth::user()->name }}</span>

    <div style="position: relative;">
        <span style="cursor:pointer; color: #6c757d;" id="adminLabel">Admin</span>
        <a href="{{ route('admin.profil.edit') }}" id="profilLink"
           style="position: absolute; top: 120%; right: 0; background: white; border: 1px solid #ccc; padding: 5px 10px; display: none; text-decoration: none; color: #0d6efd; border-radius: 4px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); white-space: nowrap;">
             Profil
        </a>
    </div>
</div>

<script>
    const adminLabel = document.getElementById('adminLabel');
    const profilLink = document.getElementById('profilLink');

    adminLabel.addEventListener('mouseenter', () => {
        profilLink.style.display = 'inline-block';
    });
    adminLabel.addEventListener('mouseleave', () => {
        // on donne un délai pour que le curseur puisse aller sur le lien
        setTimeout(() => {
            if (!profilLink.matches(':hover') && !adminLabel.matches(':hover')) {
                profilLink.style.display = 'none';
            }
        }, 200);
    });

    profilLink.addEventListener('mouseleave', () => {
        profilLink.style.display = 'none';
    });
    profilLink.addEventListener('mouseenter', () => {
        profilLink.style.display = 'inline-block';
    });
</script>


        <div class="main-content">
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
