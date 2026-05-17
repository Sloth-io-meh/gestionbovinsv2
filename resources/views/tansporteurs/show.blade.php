@extends('layouts.app')

@section('title', 'Détails Transporteur')

@section('content')
    <x-breadcrumbs :items="[
        '🚛 Transp.' => route('tansporteurs.index'),
        'Détails' => route('tansporteurs.show', $tansporteur)
    ]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="font-weight-bolder mb-4">🚛 Transporteur: {{ $tansporteur->nom }} {{ $tansporteur->prenom }}</h5>
        @can('update', $tansporteur)
        <a href="{{ route('tansporteurs.edit', $tansporteur) }}" class="btn btn-warning">✏️ Modifier</a>
        @endcan
    </div>

    <div class="card shadow">
        <div class="card-header pb-0">
            <h6 class="mb-0 font-weight-bolder">Détails du Transporteur</h6>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $tansporteur->id_trans }}</p>
            <p><strong>CIN:</strong> {{ $tansporteur->cin_t }}</p>
            <p><strong>Nom:</strong> {{ $tansporteur->nom }}</p>
            <p><strong>Prénom:</strong> {{ $tansporteur->prenom }}</p>
            <p><strong>Téléphone:</strong> {{ $tansporteur->tel }}</p>
        </div>
    </div>
@endsection
