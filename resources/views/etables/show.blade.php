@extends('layouts.app')

@section('title', 'Détails Étable')

@section('content')
    <x-breadcrumbs :items="[
        '🏠 Étables' => route('etables.index'),
        'Détails' => route('etables.show', $etable)
    ]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="font-weight-bolder mb-4">🏠 Étable: {{ $etable->nom }}</h5>
        @can('update', $etable)
        <a href="{{ route('etables.edit', $etable) }}" class="btn btn-warning">✏️ Modifier</a>
        @endcan
    </div>

    <div class="card shadow">
        <div class="card-header pb-0">
            <h6 class="mb-0 font-weight-bolder">Détails de l'Étable</h6>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $etable->id_etab }}</p>
            <p><strong>Nom:</strong> {{ $etable->nom }}</p>
            <p><strong>Créée le:</strong> {{ $etable->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Dernière modif:</strong> {{ $etable->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
@endsection
