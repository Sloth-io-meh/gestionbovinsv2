<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GestionBovins — Système de gestion d'élevage</title>
    <link rel="stylesheet" href="{{ asset('vendor/material-dashboard/css/material-dashboard.min.css') }}">
    <style nonce="{{ $cspNonce }}">
        :root {
            --green-dark: #1a3c2a;
            --green-mid: #2d6a4f;
            --green-light: #40916c;
            --green-pale: #d8f3dc;
            --accent: #f4a261;
        }
        body { background: #f0f2f5; }

        .hero {
            background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-mid) 60%, var(--green-light) 100%);
            color: #fff;
            padding: 5rem 1.5rem 4rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .hero-icon { font-size: 4rem; line-height: 1; margin-bottom: 1rem; }
        .hero h1 { font-size: clamp(2rem, 5vw, 3.2rem); font-weight: 800; margin-bottom: .75rem; }
        .hero p.lead { font-size: 1.1rem; opacity: .85; max-width: 520px; margin: 0 auto 2.5rem; }
        .hero-cta {
            display: inline-block;
            background: var(--accent);
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            padding: .75rem 2.25rem;
            border-radius: 50px;
            text-decoration: none;
            transition: background .2s, transform .15s;
            box-shadow: 0 4px 14px rgba(0,0,0,.2);
        }
        .hero-cta:hover { background: #e76f51; color: #fff; transform: translateY(-2px); }

        .stats-bar {
            background: var(--green-dark);
            color: #fff;
            padding: 1.25rem 1rem;
        }
        .stat-number { font-size: 1.8rem; font-weight: 700; color: var(--accent); line-height: 1; }
        .stat-label  { font-size: .8rem; opacity: .7; margin-top: .2rem; }

        .feature-card {
            border: none;
            border-radius: 12px;
            padding: 2rem 1.5rem;
            text-align: center;
            background: #fff;
            height: 100%;
            box-shadow: 0 2px 12px rgba(0,0,0,.07);
            transition: box-shadow .2s, transform .2s;
        }
        .feature-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.12); transform: translateY(-4px); }
        .feature-icon { font-size: 2.5rem; margin-bottom: 1rem; }
        .feature-card h5 { font-weight: 700; color: var(--green-dark); margin-bottom: .5rem; }
        .feature-card p { font-size: .9rem; color: #6c757d; margin: 0; }

        .security-section {
            background: var(--green-pale);
            padding: 3rem 1.5rem;
            border-top: 1px solid #b7e4c7;
        }
        .badge-pill {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: var(--green-mid);
            color: #fff;
            border-radius: 50px;
            padding: .35rem .9rem;
            font-size: .8rem;
            font-weight: 500;
            margin: .3rem;
        }
        footer {
            background: var(--green-dark);
            color: rgba(255,255,255,.6);
            text-align: center;
            padding: 1.5rem;
            font-size: .85rem;
        }
        footer a { color: var(--accent); text-decoration: none; }
    </style>
</head>
<body>

    <section class="hero">
        <div class="hero-icon">🐄</div>
        <h1>GestionBovins</h1>
        <p class="lead">Système de gestion d'élevage bovin sécurisé — suivez votre cheptel, votre stock et vos visites vétérinaires en un seul endroit.</p>
        @auth
            <a href="{{ url('/dashboard') }}" class="hero-cta">📊 Accéder au tableau de bord</a>
        @else
            <a href="{{ route('login') }}" class="hero-cta">🔐 Se connecter</a>
        @endauth
    </section>

    <section class="stats-bar">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-6 col-md-3 py-2">
                    <div class="stat-number">🐄</div>
                    <div class="stat-label">Gestion du cheptel</div>
                </div>
                <div class="col-6 col-md-3 py-2">
                    <div class="stat-number">📦</div>
                    <div class="stat-label">Suivi du stock</div>
                </div>
                <div class="col-6 col-md-3 py-2">
                    <div class="stat-number">💊</div>
                    <div class="stat-label">Gestion des médicaments</div>
                </div>
                <div class="col-6 col-md-3 py-2">
                    <div class="stat-number">🏥</div>
                    <div class="stat-label">Visites vétérinaires</div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container">
            <h2 class="text-center fw-bold mb-2" style="color: var(--green-dark);">Tout ce dont vous avez besoin</h2>
            <p class="text-center text-muted mb-5">Une plateforme complète pour la gestion de votre exploitation agricole</p>
            <div class="row g-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">🐄</div>
                        <h5>Cheptel</h5>
                        <p>Suivez chaque bovin — poids, statut, historique des visites et des traitements.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">📦</div>
                        <h5>Stock &amp; Médicaments</h5>
                        <p>Alertes de stock bas, dates d'expiration et déductions automatiques à la consommation.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">🏥</div>
                        <h5>Visites vétérinaires</h5>
                        <p>Planifiez et consultez l'historique complet des visites et diagnostics.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">📊</div>
                        <h5>Tableau de bord</h5>
                        <p>Vue d'ensemble instantanée — bovins actifs, alertes critiques et accès rapide.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="security-section">
        <div class="container text-center">
            <h4 class="fw-bold mb-2" style="color: var(--green-dark);">Conçu avec la sécurité en priorité</h4>
            <p class="text-muted mb-3">Chaque accès est contrôlé et tracé</p>
            <div>
                <span class="badge-pill">🔒 HTTPS</span>
                <span class="badge-pill">🛡️ RBAC</span>
                <span class="badge-pill">📋 Journal d'activité</span>
                <span class="badge-pill">🚫 Inscription publique désactivée</span>
                <span class="badge-pill">⏱️ Limitation de débit</span>
                <span class="badge-pill">🔑 Mots de passe hachés</span>
            </div>
        </div>
    </section>

    <footer>
        &copy; {{ date('Y') }} GestionBovins &mdash; Système de gestion d'élevage sécurisé
    </footer>

    <script src="{{ asset('vendor/material-dashboard/js/core/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
