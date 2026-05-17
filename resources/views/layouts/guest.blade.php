<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GestionBovins') - GestionBovins</title>

    <!-- Material Dashboard 3 -->
    <link rel="stylesheet" href="{{ asset('vendor/material-dashboard/css/material-dashboard.min.css') }}">

    <style nonce="{{ $cspNonce }}">
        body {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25' height='100%25'%3E%3Cdefs%3E%3ClinearGradient id='g' x1='0' y1='0' x2='1' y2='1'%3E%3Cstop offset='0' stop-color='%231a3c2a'/%3E%3Cstop offset='1' stop-color='%232d6a4f'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect fill='url(%23g)' width='100%25' height='100%25'/%3E%3C/svg%3E");
            min-height: 100vh;
        }
        .auth-card { max-width: 420px; width: 100%; }
        .form-control:focus { border-color: #e91e63 !important; box-shadow: 0 0 0 2px rgba(233,30,99,.15) !important; }
        .btn-primary { background: linear-gradient(195deg, #e91e63, #c2185b) !important; border-color: #e91e63 !important; }
        .btn-primary:hover { background: linear-gradient(195deg, #c2185b, #880e4f) !important; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 px-3">

    <div class="auth-card">
        <!-- Logo / Branding -->
        <div class="text-center mb-4">
            <h1 class="text-white fw-bold mb-1">🐄 GestionBovins</h1>
            <p class="text-white opacity-75 small">Système de gestion sécurisé</p>
        </div>

        <!-- Card -->
        <div class="card shadow-lg border-0" style="border-radius: 1rem;">
            <div class="card-body p-4">
                {{ $slot }}
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/material-dashboard/js/core/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
