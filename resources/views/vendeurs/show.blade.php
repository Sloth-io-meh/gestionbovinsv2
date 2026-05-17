@extends('layouts.app')

@section('title', 'Détails Vendeur')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="[
        '🤝 Vendeurs' => route('vendeurs.index'),
        'Détails' => route('vendeurs.show', $vendeur)
    ]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🤝 Vendeur: {{ $vendeur->nom_vend }} {{ $vendeur->prenom_vend }}</h2>
        @can('update', $vendeur)
        <a href="{{ route('vendeurs.edit', $vendeur) }}" class="btn btn-warning">✏️ Modifier</a>
        @endcan
    </div>

    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $vendeur->id_vend }}</p>
            <p><strong>Nom:</strong> {{ $vendeur->nom_vend }}</p>
            <p><strong>Prénom:</strong> {{ $vendeur->prenom_vend }}</p>
            <p><strong>Téléphone:</strong> {{ $vendeur->tel_vend }}</p>
            <p><strong>Ferme:</strong> {{ $vendeur->farm_vend ?? '—' }}</p>
        </div>
    </div>
</div>
@endsection
