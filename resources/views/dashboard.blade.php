@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
<div class="container-fluid">
    <h2>📊 Tableau de Bord</h2>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Bovins Actifs</h5>
                    <h2>{{ $activeBovins }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Bovins Vendus</h5>
                    <h2>{{ $soldBovins }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Bovins Décédés</h5>
                    <h2>{{ $deadBovins }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Stock Bas</h5>
                    <h2>{{ $lowStockCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Gestion Rapide</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('bovins.index') }}" class="btn btn-primary me-2">🐄 Bovins</a>
                    <a href="{{ route('stock.index') }}" class="btn btn-secondary me-2">📦 Stock</a>
                    <a href="{{ route('meds.index') }}" class="btn btn-info me-2">💊 Médicaments</a>
                    <a href="{{ route('visites.index') }}" class="btn btn-danger">🏥 Visites Vétérinaires</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
