@extends('layouts.app')

@section('title', 'Détails Transporteur')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="[
        '🚛 Transp.' => route('tansporteurs.index'),
        'Détails' => route('tansporteurs.show', $tansporteur)
    ]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🚛 Transporteur: {{ $tansporteur->nom }} {{ $tansporteur->prenom }}</h2>
        @can('update', $tansporteur)
        <a href="{{ route('tansporteurs.edit', $tansporteur) }}" class="btn btn-warning">✏️ Modifier</a>
        @endcan
    </div>

    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $tansporteur->id_trans }}</p>
            <p><strong>CIN:</strong> {{ $tansporteur->cin_t }}</p>
            <p><strong>Nom:</strong> {{ $tansporteur->nom }}</p>
            <p><strong>Prénom:</strong> {{ $tansporteur->prenom }}</p>
            <p><strong>Téléphone:</strong> {{ $tansporteur->tel }}</p>
        </div>
    </div>
</div>
@endsection
