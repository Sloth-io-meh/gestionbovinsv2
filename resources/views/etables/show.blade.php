@extends('layouts.app')

@section('title', 'Détails Étable')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="[
        '🏠 Étables' => route('etables.index'),
        'Détails' => route('etables.show', $etable)
    ]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🏠 Étable: {{ $etable->nom }}</h2>
        @can('update', $etable)
        <a href="{{ route('etables.edit', $etable) }}" class="btn btn-warning">✏️ Modifier</a>
        @endcan
    </div>

    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $etable->id_etab }}</p>
            <p><strong>Nom:</strong> {{ $etable->nom }}</p>
            <p><strong>Créée le:</strong> {{ $etable->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Dernière modif:</strong> {{ $etable->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</div>
@endsection
