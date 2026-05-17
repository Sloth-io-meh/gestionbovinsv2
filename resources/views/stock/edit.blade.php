@extends('layouts.app')

@section('title', 'Modifier Stock')

@section('content')
<div class="container-fluid">
    <h2>✏️ Modifier Stock</h2>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('stock.update', $stock) }}">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Libellé</label>
                        <input type="text" name="libelle_st" class="form-control" value="{{ old('libelle_st', $stock->libelle_st) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Quantité</label>
                        <input type="number" name="quantite_s" class="form-control" value="{{ old('quantite_s', $stock->quantite_s) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Quantité Actuelle</label>
                        <input type="number" name="quantiteAct" class="form-control" value="{{ old('quantiteAct', $stock->quantiteAct) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prix</label>
                        <input type="number" name="prix_s" class="form-control" step="0.01" value="{{ old('prix_s', $stock->prix_s) }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
                <a href="{{ route('stock.show', $stock) }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>
@endsection
