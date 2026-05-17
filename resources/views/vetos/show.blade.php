@extends('layouts.app')

@section('title', 'Détails Vétérinaire')

@section('content')
    <x-breadcrumbs :items="[
        '🩺 Vétos' => route('vetos.index'),
        'Détails' => route('vetos.show', $veto)
    ]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="font-weight-bolder mb-4">🩺 Vétérinaire: {{ $veto->nom_vet }} {{ $veto->prenom_vet }}</h5>
        @can('update', $veto)
        <a href="{{ route('vetos.edit', $veto) }}" class="btn btn-warning">✏️ Modifier</a>
        @endcan
    </div>

    <div class="card shadow">
        <div class="card-header pb-0">
            <h6 class="mb-0 font-weight-bolder">Détails du Vétérinaire</h6>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $veto->id_vet }}</p>
            <p><strong>Nom:</strong> {{ $veto->nom_vet }}</p>
            <p><strong>Prénom:</strong> {{ $veto->prenom_vet }}</p>
            <p><strong>Téléphone:</strong> {{ $veto->tel_vet }}</p>
        </div>
    </div>
@endsection
