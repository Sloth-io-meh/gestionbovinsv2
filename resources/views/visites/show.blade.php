@extends('layouts.app')

@section('title', 'Visite')

@section('content')
    <h5 class="font-weight-bolder mb-4">🏥 Visite #{{ $visite->id_pres }}</h5>
    <div class="card shadow">
        <div class="card-header pb-0">
            <h6 class="mb-0 font-weight-bolder">Détails de la Visite</h6>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Animal:</dt>
                <dd class="col-sm-9">#{{ $visite->bovin?->id_bov }}</dd>
                <dt class="col-sm-3">Vétérinaire:</dt>
                <dd class="col-sm-9">{{ $visite->veto?->nom_vet ?? '-' }}</dd>
                <dt class="col-sm-3">Date:</dt>
                <dd class="col-sm-9">{{ $visite->datepres?->format('d/m/Y') ?? '-' }}</dd>
                <dt class="col-sm-3">Prix:</dt>
                <dd class="col-sm-9">{{ $visite->prix_pres ? number_format($visite->prix_pres, 2) . ' €' : '-' }}</dd>
                <dt class="col-sm-3">Description:</dt>
                <dd class="col-sm-9">{{ $visite->description_v }}</dd>
            </dl>
            <a href="{{ route('visites.index') }}" class="btn btn-secondary">← Retour</a>
            <a href="{{ route('visites.edit', $visite) }}" class="btn btn-warning">✏️ Modifier</a>
            <form method="POST" action="{{ route('visites.destroy', $visite) }}" style="display:inline;">
                @csrf @method('DELETE')
                <button class="btn btn-danger" data-confirm="Supprimer?">🗑️ Supprimer</button>
            </form>
        </div>
    </div>
@endsection
