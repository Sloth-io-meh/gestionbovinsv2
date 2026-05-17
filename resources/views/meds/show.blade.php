@extends('layouts.app')

@section('title', 'Médicament')

@section('content')
<div class="container-fluid">
    <h2>💊 Médicament #{{ $meds->id_med }}</h2>
    <div class="card">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Libellé:</dt>
                <dd class="col-sm-9">{{ $meds->libelle }}</dd>
                <dt class="col-sm-3">Description:</dt>
                <dd class="col-sm-9">{{ $meds->description }}</dd>
                <dt class="col-sm-3">Quantité:</dt>
                <dd class="col-sm-9">{{ $meds->quantite_med }}</dd>
                <dt class="col-sm-3">Prix:</dt>
                <dd class="col-sm-9">{{ number_format($meds->prix_med, 2) }} €</dd>
                <dt class="col-sm-3">Date Expiration:</dt>
                <dd class="col-sm-9">{{ $meds->dateexp_med?->format('d/m/Y') ?? '-' }}</dd>
            </dl>
            <a href="{{ route('meds.index') }}" class="btn btn-secondary">← Retour</a>
            <a href="{{ route('meds.edit', $meds) }}" class="btn btn-warning">✏️ Modifier</a>
            <form method="POST" action="{{ route('meds.destroy', $meds) }}" style="display:inline;">
                @csrf @method('DELETE')
                <button class="btn btn-danger" data-confirm="Supprimer?">🗑️ Supprimer</button>
            </form>
        </div>
    </div>
</div>
@endsection
