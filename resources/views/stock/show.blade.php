@extends('layouts.app')

@section('title', 'Stock')

@section('content')
<div class="container-fluid">
    <h2>Stock #{{ $stock->id_stock }}</h2>
    <div class="card">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Libellé:</dt>
                <dd class="col-sm-9">{{ $stock->libelle_st }}</dd>
                <dt class="col-sm-3">Description:</dt>
                <dd class="col-sm-9">{{ $stock->description_s }}</dd>
                <dt class="col-sm-3">Quantité Total:</dt>
                <dd class="col-sm-9">{{ $stock->quantite_s }}</dd>
                <dt class="col-sm-3">Quantité Actuelle:</dt>
                <dd class="col-sm-9">{{ $stock->quantiteAct }}</dd>
                <dt class="col-sm-3">Prix:</dt>
                <dd class="col-sm-9">{{ number_format($stock->prix_s, 2) }} €</dd>
                <dt class="col-sm-3">Date Expiration:</dt>
                <dd class="col-sm-9">{{ $stock->dateexp_s?->format('d/m/Y') ?? '-' }}</dd>
            </dl>
            <a href="{{ route('stock.index') }}" class="btn btn-secondary">← Retour</a>
            <a href="{{ route('stock.edit', $stock) }}" class="btn btn-warning">✏️ Modifier</a>
            <form method="POST" action="{{ route('stock.destroy', $stock) }}" style="display:inline;">
                @csrf @method('DELETE')
                <button class="btn btn-danger" data-confirm="Supprimer?">🗑️ Supprimer</button>
            </form>
        </div>
    </div>
</div>
@endsection
