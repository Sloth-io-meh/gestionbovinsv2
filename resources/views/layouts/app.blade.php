<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'GestionBovins')) - GestionBovins</title>

        <!-- Material Dashboard 3 -->
        <link rel="stylesheet" href="{{ asset('vendor/material-dashboard/css/material-dashboard.min.css') }}">

        <style nonce="{{ $cspNonce }}">
            .nav-link.text-white:hover { background: rgba(255,255,255,.1) !important; border-radius: 8px; }
            .sidenav .nav-link { padding: .5rem 1rem !important; }
            .badge-active { background-color: #4caf50; }
            .badge-sold   { background-color: #1a73e8; }
            .badge-dead   { background-color: #f44335; }
            .badge-status {
                display: inline-block; padding: .35em .65em; font-size: .75em;
                font-weight: 700; line-height: 1; text-align: center;
                white-space: nowrap; vertical-align: baseline;
                border-radius: 50rem; color: white;
            }
        </style>

        @yield('styles')
    </head>
    <body class="g-sidenav-show bg-gray-100">

        <!-- ── Sidenav ── -->
        <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
            <div class="sidenav-header d-flex align-items-center px-3 py-3">
                <a class="navbar-brand m-0 text-decoration-none" href="{{ route('dashboard') }}">
                    <span class="text-white font-weight-bold">🐄 GestionBovins</span>
                </a>
            </div>
            <hr class="horizontal light mt-0 mb-1">

            @auth
            <div class="px-3 py-2">
                <p class="text-xs text-white opacity-6 mb-0">👤 {{ auth()->user()->name }}</p>
            </div>
            <hr class="horizontal light mt-0 mb-1">
            @endauth

            <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
                <ul class="navbar-nav">

                    <li class="nav-item mt-1">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-6">Principal</h6>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white {{ Route::is('dashboard') ? 'active bg-gradient-primary' : '' }}"
                           href="{{ route('dashboard') }}">
                            <span class="nav-link-text ms-2">📊 Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ str_starts_with(Route::currentRouteName(), 'bovins') ? 'active bg-gradient-primary' : '' }}"
                           href="{{ route('bovins.index') }}">
                            <span class="nav-link-text ms-2">🐄 Bovins</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ str_starts_with(Route::currentRouteName(), 'stock') ? 'active bg-gradient-primary' : '' }}"
                           href="{{ route('stock.index') }}">
                            <span class="nav-link-text ms-2">📦 Stock</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ str_starts_with(Route::currentRouteName(), 'meds') ? 'active bg-gradient-primary' : '' }}"
                           href="{{ route('meds.index') }}">
                            <span class="nav-link-text ms-2">💊 Médicaments</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ str_starts_with(Route::currentRouteName(), 'visites') ? 'active bg-gradient-primary' : '' }}"
                           href="{{ route('visites.index') }}">
                            <span class="nav-link-text ms-2">🏥 Visites</span>
                        </a>
                    </li>

                    <li class="nav-item mt-3">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-6">Gestion</h6>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white {{ str_starts_with(Route::currentRouteName(), 'etables') ? 'active bg-gradient-primary' : '' }}"
                           href="{{ route('etables.index') }}">
                            <span class="nav-link-text ms-2">🏠 Étables</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ str_starts_with(Route::currentRouteName(), 'vendeurs') ? 'active bg-gradient-primary' : '' }}"
                           href="{{ route('vendeurs.index') }}">
                            <span class="nav-link-text ms-2">🤝 Vendeurs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ str_starts_with(Route::currentRouteName(), 'vetos') ? 'active bg-gradient-primary' : '' }}"
                           href="{{ route('vetos.index') }}">
                            <span class="nav-link-text ms-2">🩺 Vétos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ str_starts_with(Route::currentRouteName(), 'tansporteurs') ? 'active bg-gradient-primary' : '' }}"
                           href="{{ route('tansporteurs.index') }}">
                            <span class="nav-link-text ms-2">🚛 Transporteurs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ str_starts_with(Route::currentRouteName(), 'vehicules') ? 'active bg-gradient-primary' : '' }}"
                           href="{{ route('vehicules.index') }}">
                            <span class="nav-link-text ms-2">🚗 Véhicules</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ str_starts_with(Route::currentRouteName(), 'quarantaines') ? 'active bg-gradient-primary' : '' }}"
                           href="{{ route('quarantaines.index') }}">
                            <span class="nav-link-text ms-2">🛡️ Quarantaines</span>
                        </a>
                    </li>

                    @can('admin')
                    <li class="nav-item mt-3">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-6">Administration</h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ str_starts_with(Route::currentRouteName(), 'users') ? 'active bg-gradient-primary' : '' }}"
                           href="{{ route('users.index') }}">
                            <span class="nav-link-text ms-2">👥 Utilisateurs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ str_starts_with(Route::currentRouteName(), 'logs') ? 'active bg-gradient-primary' : '' }}"
                           href="{{ route('logs.index') }}">
                            <span class="nav-link-text ms-2">📋 Logs</span>
                        </a>
                    </li>
                    @endcan

                    <li class="nav-item mt-3">
                        <hr class="horizontal light my-0">
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link text-white btn btn-link w-100 text-start border-0 bg-transparent">
                                🚪 Déconnexion
                            </button>
                        </form>
                    </li>

                </ul>
            </div>
        </aside>

        <!-- ── Main Content ── -->
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

            <!-- Top Navbar -->
            <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
                <div class="container-fluid py-1 px-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                            <li class="breadcrumb-item text-sm">
                                <a class="opacity-5 text-dark" href="{{ route('dashboard') }}">GestionBovins</a>
                            </li>
                            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                                @yield('title', 'Dashboard')
                            </li>
                        </ol>
                    </nav>
                    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                        <ul class="navbar-nav ms-md-auto flex-row align-items-center">
                            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                                <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                                    <div class="sidenav-toggler-inner">
                                        <i class="sidenav-toggler-line"></i>
                                        <i class="sidenav-toggler-line"></i>
                                        <i class="sidenav-toggler-line"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="container-fluid py-4">

                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @yield('content')

            </div>
        </main>

        <!-- ── Scripts ── -->
        <script src="{{ asset('vendor/material-dashboard/js/core/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/material-dashboard/js/plugins/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('vendor/material-dashboard/js/material-dashboard.min.js') }}"></script>

        <script nonce="{{ $cspNonce }}">
        document.addEventListener('DOMContentLoaded', function () {
            document.addEventListener('submit', function (e) {
                var msg = e.target.dataset.confirm;
                if (msg && !confirm(msg)) e.preventDefault();
            });
            document.addEventListener('click', function (e) {
                var btn = e.target.closest('button[data-confirm]');
                if (btn && !confirm(btn.dataset.confirm)) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
        });
        </script>

        @stack('scripts')
    </body>
</html>
