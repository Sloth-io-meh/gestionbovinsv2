@extends('layouts.app')

@section('title', 'Modifier Médicament')

@section('content')
<div class="container-fluid">
    <h2>✏️ Modifier Médicament</h2>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('meds.update', $meds) }}">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Libellé</label>
                        <input type="text" name="libelle" class="form-control" value="{{ old('libelle', $meds->libelle) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Quantité</label>
                        <input type="number" name="quantite_med" class="form-control" value="{{ old('quantite_med', $meds->quantite_med) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prix</label>
                        <input type="number" name="prix_med" class="form-control" step="0.01" value="{{ old('prix_med', $meds->prix_med) }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
                <a href="{{ route('meds.show', $meds) }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>
@endsection
