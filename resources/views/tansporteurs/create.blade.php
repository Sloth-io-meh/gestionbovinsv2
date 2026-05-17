@extends('layouts.app')

@section('title', 'Ajouter un Transporteur')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="[
        '🚛 Transp.' => route('tansporteurs.index'),
        'Ajouter' => route('tansporteurs.create')
    ]" />

    <h2>➕ Ajouter un Transporteur</h2>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('tansporteurs.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">CIN <span class="text-danger">*</span></label>
                        <input type="text" name="cin_t" class="form-control @error('cin_t') is-invalid @enderror" value="{{ old('cin_t') }}" maxlength="10" required>
                        @error('cin_t')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" maxlength="25" required>
                        @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prénom <span class="text-danger">*</span></label>
                        <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" maxlength="25" required>
                        @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                        <input type="text" name="tel" class="form-control @error('tel') is-invalid @enderror" value="{{ old('tel') }}" maxlength="25" required>
                        @error('tel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">💾 Créer</button>
                    <a href="{{ route('tansporteurs.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
