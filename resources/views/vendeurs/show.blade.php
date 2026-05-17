@extends('layouts.app')

@section('title', 'Détails Vendeur')

@section('content')
    <x-breadcrumbs :items="[
        '🤝 Vendeurs' => route('vendeurs.index'),
        'Détails' => route('vendeurs.show', $vendeur)
    ]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="font-weight-bolder mb-4">🤝 Vendeur: {{ $vendeur->nom_vend }} {{ $vendeur->prenom_vend }}</h5>
        @can('update', $vendeur)
        <a href="{{ route('vendeurs.edit', $vendeur) }}" class="btn btn-warning">✏️ Modifier</a>
        @endcan
    </div>

    <div class="card shadow">
        <div class="card-header pb-0">
            <h6 class="mb-0 font-weight-bolder">Détails du Vendeur</h6>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $vendeur->id_vend }}</p>
            <p><strong>Nom:</strong> {{ $vendeur->nom_vend }}</p>
            <p><strong>Prénom:</strong> {{ $vendeur->prenom_vend }}</p>
            <p><strong>Téléphone:</strong> {{ $vendeur->tel_vend }}</p>
            <p><strong>Ferme:</strong> {{ $vendeur->farm_vend ?? '—' }}</p>
        </div>
    </div>
@endsection
