@extends('layouts.app')

@section('title', 'Détails Véhicule')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="[
        '🚗 Véhicules' => route('vehicules.index'),
        'Détails' => route('vehicules.show', $vehicule)
    ]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🚗 Véhicule: {{ $vehicule->Matricule }}</h2>
        @can('update', $vehicule)
        <a href="{{ route('vehicules.edit', $vehicule) }}" class="btn btn-warning">✏️ Modifier</a>
        @endcan
    </div>

    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $vehicule->id_veh }}</p>
            <p><strong>Matricule:</strong> {{ $vehicule->Matricule }}</p>
            <p><strong>Type:</strong> {{ $vehicule->type }}</p>
            <p><strong>Transporteur:</strong> {{ $vehicule->tansporteur?->nom }} {{ $vehicule->tansporteur?->prenom ?? '—' }}</p>
        </div>
    </div>
</div>
@endsection
