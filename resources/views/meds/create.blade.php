@extends('layouts.app')

@section('title', 'Ajouter Médicament')

@section('content')
<div class="container-fluid">
    <h2>➕ Ajouter Médicament</h2>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('meds.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Libellé <span class="text-danger">*</span></label>
                        <input type="text" name="libelle" class="form-control @error('libelle') is-invalid @enderror" value="{{ old('libelle') }}" required>
                        @error('libelle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Quantité <span class="text-danger">*</span></label>
                        <input type="number" name="quantite_med" class="form-control" value="{{ old('quantite_med') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Prix <span class="text-danger">*</span></label>
                        <input type="number" name="prix_med" class="form-control" step="0.01" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Date Expiration <span class="text-danger">*</span></label>
                        <input type="date" name="dateexp_med" class="form-control" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">💾 Créer</button>
                <a href="{{ route('meds.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>
@endsection
