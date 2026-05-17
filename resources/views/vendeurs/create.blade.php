@extends('layouts.app')

@section('title', 'Ajouter un Vendeur')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="[
        '🤝 Vendeurs' => route('vendeurs.index'),
        'Ajouter' => route('vendeurs.create')
    ]" />

    <h2>➕ Ajouter un Vendeur</h2>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('vendeurs.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="nom_vend" class="form-control @error('nom_vend') is-invalid @enderror" value="{{ old('nom_vend') }}" required>
                        @error('nom_vend')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prénom <span class="text-danger">*</span></label>
                        <input type="text" name="prenom_vend" class="form-control @error('prenom_vend') is-invalid @enderror" value="{{ old('prenom_vend') }}" required>
                        @error('prenom_vend')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                        <input type="text" name="tel_vend" class="form-control @error('tel_vend') is-invalid @enderror" value="{{ old('tel_vend') }}" required>
                        @error('tel_vend')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Ferme / Exploitation</label>
                        <input type="text" name="farm_vend" class="form-control @error('farm_vend') is-invalid @enderror" value="{{ old('farm_vend') }}" maxlength="25">
                        @error('farm_vend')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">💾 Créer</button>
                    <a href="{{ route('vendeurs.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
