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
                        <label class="form-label">Libellé <span class="text-danger">*</span></label>
                        <input type="text" name="libelle" class="form-control @error('libelle') is-invalid @enderror" value="{{ old('libelle', $meds->libelle) }}">
                        @error('libelle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Quantité <span class="text-danger">*</span></label>
                        <input type="number" name="quantite_med" class="form-control @error('quantite_med') is-invalid @enderror" value="{{ old('quantite_med', $meds->quantite_med) }}">
                        @error('quantite_med')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prix <span class="text-danger">*</span></label>
                        <input type="number" name="prix_med" class="form-control @error('prix_med') is-invalid @enderror" step="0.01" value="{{ old('prix_med', $meds->prix_med) }}">
                        @error('prix_med')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date Expiration <span class="text-danger">*</span></label>
                        <input type="date" name="dateexp_med" class="form-control @error('dateexp_med') is-invalid @enderror" value="{{ old('dateexp_med', $meds->dateexp_med?->format('Y-m-d')) }}">
                        @error('dateexp_med')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $meds->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
                <a href="{{ route('meds.show', $meds) }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>
@endsection
