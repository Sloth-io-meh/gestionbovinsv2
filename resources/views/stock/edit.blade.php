@extends('layouts.app')

@section('title', 'Modifier Stock')

@section('content')
    <h5 class="font-weight-bolder mb-4">Modifier Stock</h5>
    <div class="card shadow">
        <div class="card-header pb-0">
            <h6 class="mb-0 font-weight-bolder">Modifier Stock</h6>
        </div>
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
@endsection
