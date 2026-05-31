<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .sidebar { width: 220px; min-height: 100vh; }
        .sidebar .nav-link { color: #adb5bd; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background: rgba(255,255,255,.1); }
    </style>
</head>
<body class="bg-light">

    {{-- Navbar móvil --}}
    <nav class="navbar navbar-dark bg-dark d-md-none px-3">
        <span class="navbar-brand fw-bold" style="letter-spacing:1px;">ELITESCOUTING</span>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    {{-- Offcanvas sidebar (móvil) --}}
    <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="sidebarMobile">
        <div class="offcanvas-header border-bottom border-secondary">
            <span class="fw-bold fs-6" style="letter-spacing:1px;">ELITESCOUTING</span>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-3">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}"><i class="bi bi-house-door me-2"></i>Dashboard</a></li>
                <li><a href="{{ route('partidos.principal') }}" class="nav-link {{ request()->is('partidos*') ? 'active' : '' }}"><i class="fa-regular fa-futbol me-2"></i>Partidos</a></li>
                <li><a href="{{ route('usuarios.principal') }}" class="nav-link {{ request()->is('usuarios*') ? 'active' : '' }}"><i class="bi bi-people me-2"></i>Usuarios</a></li>
                <li><a href="{{ route('ojeadores.principal') }}" class="nav-link {{ request()->is('ojeadores*') ? 'active' : '' }}"><i class="bi bi-binoculars me-2"></i>Ojeadores</a></li>
                <li><a href="{{ route('jugadores.principal') }}" class="nav-link {{ request()->is('jugadores*') ? 'active' : '' }}"><i class="bi bi-person-badge me-2"></i>Jugadores</a></li>
                <li><a href="{{ route('agentes.principal') }}" class="nav-link {{ request()->is('agentes*') ? 'active' : '' }}"><i class="bi bi-person-lines-fill me-2"></i>Agentes</a></li>
                <li><a href="{{ route('clubes.principal') }}" class="nav-link {{ request()->is('clubes*') ? 'active' : '' }}"><i class="bi bi-shield me-2"></i>Clubes</a></li>
                <li><a href="{{ route('informes.principal') }}" class="nav-link {{ request()->is('informes*') ? 'active' : '' }}"><i class="bi bi-journal me-2"></i>Informes</a></li>
                <li><a href="{{ route('competiciones.principal') }}" class="nav-link {{ request()->is('competiciones*') ? 'active' : '' }}"><i class="bi bi-trophy me-2"></i>Competiciones</a></li>
            </ul>
            <hr class="text-secondary">
            <form action="/logout" method="POST">
                @csrf
                <button class="btn btn-link text-danger p-0 text-decoration-none"><i class="bi bi-box-arrow-left me-1"></i>Cerrar Sesión</button>
            </form>
        </div>
    </div>

    <div class="d-flex">
        {{-- Sidebar escritorio --}}
        <aside class="sidebar d-none d-md-flex flex-column p-3 bg-dark">
            <div class="d-flex align-items-center mb-3 px-2 pt-1">
                <img src="{{ asset('favicon.ico') }}" alt="EliteScouting" width="30" height="30" class="me-2" style="object-fit:contain;">
                <span class="fw-bold text-white fs-6" style="letter-spacing:1px;">ELITESCOUTING</span>
            </div>
            <hr class="text-secondary mt-0 mb-2">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}"><i class="bi bi-house-door me-2"></i>Dashboard</a></li>
                <li><a href="{{ route('partidos.principal') }}" class="nav-link {{ request()->is('partidos*') ? 'active' : '' }}"><i class="fa-regular fa-futbol me-2"></i>Partidos</a></li>
                <li><a href="{{ route('usuarios.principal') }}" class="nav-link {{ request()->is('usuarios*') ? 'active' : '' }}"><i class="bi bi-people me-2"></i>Usuarios</a></li>
                <li><a href="{{ route('ojeadores.principal') }}" class="nav-link {{ request()->is('ojeadores*') ? 'active' : '' }}"><i class="bi bi-binoculars me-2"></i>Ojeadores</a></li>
                <li><a href="{{ route('jugadores.principal') }}" class="nav-link {{ request()->is('jugadores*') ? 'active' : '' }}"><i class="bi bi-person-badge me-2"></i>Jugadores</a></li>
                <li><a href="{{ route('agentes.principal') }}" class="nav-link {{ request()->is('agentes*') ? 'active' : '' }}"><i class="bi bi-person-lines-fill me-2"></i>Agentes</a></li>
                <li><a href="{{ route('clubes.principal') }}" class="nav-link {{ request()->is('clubes*') ? 'active' : '' }}"><i class="bi bi-shield me-2"></i>Clubes</a></li>
                <li><a href="{{ route('informes.principal') }}" class="nav-link {{ request()->is('informes*') ? 'active' : '' }}"><i class="bi bi-journal me-2"></i>Informes</a></li>
                <li><a href="{{ route('competiciones.principal') }}" class="nav-link {{ request()->is('competiciones*') ? 'active' : '' }}"><i class="bi bi-trophy me-2"></i>Competiciones</a></li>
            </ul>
            <hr class="text-secondary">
            <form action="/logout" method="POST" class="px-3">
                @csrf
                <button class="btn btn-link text-danger p-0 text-decoration-none"><i class="bi bi-box-arrow-left me-1"></i>Cerrar Sesión</button>
            </form>
        </aside>

        <div class="flex-grow-1 overflow-hidden">
            <main class="p-3 p-md-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>