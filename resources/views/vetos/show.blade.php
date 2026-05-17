@extends('layouts.app')

@section('title', 'Détails Vétérinaire')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="[
        '🩺 Vétos' => route('vetos.index'),
        'Détails' => route('vetos.show', $veto)
    ]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🩺 Vétérinaire: {{ $veto->nom_vet }} {{ $veto->prenom_vet }}</h2>
        @can('update', $veto)
        <a href="{{ route('vetos.edit', $veto) }}" class="btn btn-warning">✏️ Modifier</a>
        @endcan
    </div>

    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $veto->id_vet }}</p>
            <p><strong>Nom:</strong> {{ $veto->nom_vet }}</p>
            <p><strong>Prénom:</strong> {{ $veto->prenom_vet }}</p>
            <p><strong>Téléphone:</strong> {{ $veto->tel_vet }}</p>
        </div>
    </div>
</div>
@endsection
