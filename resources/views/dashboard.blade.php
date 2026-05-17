@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')

{{-- Stat cards row --}}
<div class="row mb-4">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card shadow">
            <div class="card-header p-3 pt-2" style="background: transparent; border-bottom: none;">
                <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                    <span style="font-size:1.8rem;line-height:2.5rem;">🐄</span>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold" style="color:#7b809a;">Bovins Actifs</p>
                    <h4 class="mb-0 font-weight-bolder">{{ $activeBovins }}</h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                <a href="{{ route('bovins.index') }}?status=active" class="text-sm text-body font-weight-light mb-0 text-decoration-none">
                    Voir les bovins actifs →
                </a>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card shadow">
            <div class="card-header p-3 pt-2" style="background: transparent; border-bottom: none;">
                <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                    <span style="font-size:1.8rem;line-height:2.5rem;">✅</span>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold" style="color:#7b809a;">Bovins Vendus</p>
                    <h4 class="mb-0 font-weight-bolder">{{ $soldBovins }}</h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                <a href="{{ route('bovins.index') }}?status=sold" class="text-sm text-body font-weight-light mb-0 text-decoration-none">
                    Voir les bovins vendus →
                </a>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card shadow">
            <div class="card-header p-3 pt-2" style="background: transparent; border-bottom: none;">
                <div class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute">
                    <span style="font-size:1.8rem;line-height:2.5rem;">💀</span>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold" style="color:#7b809a;">Bovins Décédés</p>
                    <h4 class="mb-0 font-weight-bolder">{{ $deadBovins }}</h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                <a href="{{ route('bovins.index') }}?status=dead" class="text-sm text-body font-weight-light mb-0 text-decoration-none">
                    Voir les bovins décédés →
                </a>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card shadow">
            <div class="card-header p-3 pt-2" style="background: transparent; border-bottom: none;">
                <div class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                    <span style="font-size:1.8rem;line-height:2.5rem;">⚠️</span>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold" style="color:#7b809a;">Stock Bas</p>
                    <h4 class="mb-0 font-weight-bolder">{{ $lowStockCount }}</h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                <a href="{{ route('stock.index') }}" class="text-sm text-body font-weight-light mb-0 text-decoration-none">
                    Voir le stock →
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Quick access --}}
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header pb-0">
                <h6 class="mb-0 font-weight-bolder">Accès Rapide</h6>
                <p class="text-sm text-secondary mb-0">Navigation vers les modules principaux</p>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('bovins.index') }}" class="btn btn-sm btn-primary mb-0">🐄 Bovins</a>
                    <a href="{{ route('stock.index') }}" class="btn btn-sm bg-gradient-secondary mb-0">📦 Stock</a>
                    <a href="{{ route('meds.index') }}" class="btn btn-sm bg-gradient-info mb-0 text-white">💊 Médicaments</a>
                    <a href="{{ route('visites.index') }}" class="btn btn-sm bg-gradient-danger mb-0">🏥 Visites</a>
                    <a href="{{ route('quarantaines.index') }}" class="btn btn-sm bg-gradient-warning mb-0">🛡️ Quarantaines</a>
                    <a href="{{ route('etables.index') }}" class="btn btn-sm btn-outline-secondary mb-0">🏠 Étables</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
