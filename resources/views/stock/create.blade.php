@extends('layouts.app')

@section('title', 'Ajouter Stock')

@section('content')
<div class="container-fluid">
    <h2>➕ Ajouter Stock</h2>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('stock.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Libellé <span class="text-danger">*</span></label>
                        <input type="text" name="libelle_st" class="form-control @error('libelle_st') is-invalid @enderror" value="{{ old('libelle_st') }}" required>
                        @error('libelle_st')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Quantité <span class="text-danger">*</span></label>
                        <input type="number" name="quantite_s" class="form-control @error('quantite_s') is-invalid @enderror" value="{{ old('quantite_s') }}" required>
                        @error('quantite_s')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description_s" class="form-control">{{ old('description_s') }}</textarea>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Prix <span class="text-danger">*</span></label>
                        <input type="number" name="prix_s" class="form-control @error('prix_s') is-invalid @enderror" value="{{ old('prix_s') }}" step="0.01" required>
                        @error('prix_s')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Date Achat <span class="text-danger">*</span></label>
                        <input type="date" name="dateachat" class="form-control @error('dateachat') is-invalid @enderror" value="{{ old('dateachat') }}" required>
                        @error('dateachat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Date Expiration <span class="text-danger">*</span></label>
                        <input type="date" name="dateexp_s" class="form-control @error('dateexp_s') is-invalid @enderror" value="{{ old('dateexp_s') }}" required>
                        @error('dateexp_s')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">💾 Créer</button>
                <a href="{{ route('stock.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>
@endsection
