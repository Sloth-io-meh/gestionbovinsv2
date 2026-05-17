@extends('layouts.app')

@section('title', 'Modifier Véhicule')

@section('content')

    <x-breadcrumbs :items="[
        '🚗 Véhicules' => route('vehicules.index'),
        'Modifier' => route('vehicules.edit', $vehicule)
    ]" />

    <h2>✏️ Modifier Véhicule: {{ $vehicule->Matricule }}</h2>

    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('vehicules.update', $vehicule) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Matricule <span class="text-danger">*</span></label>
                        <input type="text" name="Matricule" class="form-control @error('Matricule') is-invalid @enderror" value="{{ old('Matricule', $vehicule->Matricule) }}" required maxlength="25">
                        @error('Matricule')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <input type="text" name="type" class="form-control @error('type') is-invalid @enderror" value="{{ old('type', $vehicule->type) }}" required maxlength="25">
                        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
                    <a href="{{ route('vehicules.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection
