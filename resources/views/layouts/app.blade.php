<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'GestionBovins')) - GestionBovins</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

        <style nonce="{{ $cspNonce }}">
            :root {
                --bs-body-bg: #f5f5f5;
            }
            body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            }
            .sidebar {
                background-color: #2c3e50;
                color: white;
                min-height: 100vh;
                padding: 20px;
            }
            .sidebar .nav-link {
                color: rgba(255, 255, 255, 0.8);
                padding: 12px 15px;
                border-radius: 5px;
                margin-bottom: 10px;
                transition: all 0.3s;
            }
            .sidebar .nav-link:hover,
            .sidebar .nav-link.active {
                background-color: #34495e;
                color: white;
            }
            .main-content {
                padding: 30px;
                background-color: #f5f5f5;
            }
            .badge-active { background-color: #28a745; }
            .badge-sold { background-color: #17a2b8; }
            .badge-dead { background-color: #dc3545; }
            .badge-status {
                display: inline-block;
                padding: .35em .65em;
                font-size: .75em;
                font-weight: 700;
                line-height: 1;
                text-align: center;
                white-space: nowrap;
                vertical-align: baseline;
                border-radius: 50rem;
                color: white;
            }
        </style>

        @yield('styles')
    </head>
    <body>
        <div class="container-fluid">
            <div class="row min-vh-100">
                <!-- Sidebar -->
                <div class="col-md-2 sidebar">
                    <h4 class="mb-4">🐄 GestionBovins</h4>
                    @auth
                    <div class="mb-3 px-3 small text-white-50">
                        👤 {{ auth()->user()->name }}
                    </div>
                    @endauth
                    <nav class="nav flex-column">
                        <a href="{{ route('dashboard') }}" class="nav-link @if(Route::currentRouteName() == 'dashboard') active @endif">📊 Dashboard</a>
                        <a href="{{ route('bovins.index') }}" class="nav-link @if(str_starts_with(Route::currentRouteName(), 'bovins')) active @endif">🐄 Bovins</a>
                        <a href="{{ route('stock.index') }}" class="nav-link @if(str_starts_with(Route::currentRouteName(), 'stock')) active @endif">📦 Stock</a>
                        <a href="{{ route('meds.index') }}" class="nav-link @if(str_starts_with(Route::currentRouteName(), 'meds')) active @endif">💊 Médicaments</a>
                        <a href="{{ route('visites.index') }}" class="nav-link @if(str_starts_with(Route::currentRouteName(), 'visites')) active @endif">🏥 Visites</a>
                        <hr class="bg-light">
                        <p class="small text-uppercase px-3 mb-2 opacity-50">Gestion</p>
                        <a href="{{ route('etables.index') }}" class="nav-link @if(str_starts_with(Route::currentRouteName(), 'etables')) active @endif">🏠 Étables</a>
                        <a href="{{ route('vendeurs.index') }}" class="nav-link @if(str_starts_with(Route::currentRouteName(), 'vendeurs')) active @endif">🤝 Vendeurs</a>
                        <a href="{{ route('vetos.index') }}" class="nav-link @if(str_starts_with(Route::currentRouteName(), 'vetos')) active @endif">🩺 Vétos</a>
                        <a href="{{ route('tansporteurs.index') }}" class="nav-link @if(str_starts_with(Route::currentRouteName(), 'tansporteurs')) active @endif">🚛 Transporteurs</a>
                        <a href="{{ route('vehicules.index') }}" class="nav-link @if(str_starts_with(Route::currentRouteName(), 'vehicules')) active @endif">🚗 Véhicules</a>
                        <a href="{{ route('quarantaines.index') }}" class="nav-link @if(str_starts_with(Route::currentRouteName(), 'quarantaines')) active @endif">🛡️ Quarantaines</a>
                        @can('admin')
                        <hr class="bg-light">
                        <p class="small text-uppercase px-3 mb-2 opacity-50">Administration</p>
                        <a href="{{ route('users.index') }}" class="nav-link @if(str_starts_with(Route::currentRouteName(), 'users')) active @endif">👥 Utilisateurs</a>
                        <a href="{{ route('logs.index') }}" class="nav-link @if(str_starts_with(Route::currentRouteName(), 'logs')) active @endif">📋 Logs</a>
                        @endcan
                        <hr class="bg-light">
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="nav-link" style="border: none; background: none; width: 100%; text-align: left;">🚪 Déconnexion</button>
                        </form>
                    </nav>
                </div>

                <!-- Main Content -->
                <div class="col-md-10 main-content">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
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
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

        <!-- Delegated confirm handler — replaces all inline onclick/onsubmit confirm() calls -->
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
