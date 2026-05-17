@extends('layouts.app')

@section('title', 'Ajouter un Vétérinaire')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="[
        '🩺 Vétos' => route('vetos.index'),
        'Ajouter' => route('vetos.create')
    ]" />

    <h2>➕ Ajouter un Vétérinaire</h2>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('vetos.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ID Vétérinaire <span class="text-danger">*</span></label>
                        <input type="number" name="id_vet" class="form-control @error('id_vet') is-invalid @enderror" value="{{ old('id_vet') }}" required>
                        @error('id_vet')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="nom_vet" class="form-control @error('nom_vet') is-invalid @enderror" value="{{ old('nom_vet') }}" required>
                        @error('nom_vet')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prénom <span class="text-danger">*</span></label>
                        <input type="text" name="prenom_vet" class="form-control @error('prenom_vet') is-invalid @enderror" value="{{ old('prenom_vet') }}" required>
                        @error('prenom_vet')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                        <input type="text" name="tel_vet" class="form-control @error('tel_vet') is-invalid @enderror" value="{{ old('tel_vet') }}" required>
                        @error('tel_vet')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">💾 Créer</button>
                    <a href="{{ route('vetos.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
