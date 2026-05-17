@extends('layouts.app')

@section('title', 'Détails Quarantaine')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="[
        '🛡️ Quarantaines' => route('quarantaines.index'),
        'Détails' => route('quarantaines.show', $quarantaine)
    ]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🛡️ Statut Quarantaine: {{ $quarantaine->libelle }}</h2>
        @can('update', $quarantaine)
        <a href="{{ route('quarantaines.edit', $quarantaine) }}" class="btn btn-warning">✏️ Modifier</a>
        @endcan
    </div>

    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $quarantaine->id_q }}</p>
            <p><strong>Libellé:</strong> {{ $quarantaine->libelle }}</p>
        </div>
    </div>
</div>
@endsection
