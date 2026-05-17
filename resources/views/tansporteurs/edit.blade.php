@extends('layouts.app')

@section('title', 'Modifier Transporteur')

@section('content')

    <x-breadcrumbs :items="[
        '🚛 Transp.' => route('tansporteurs.index'),
        'Modifier' => route('tansporteurs.edit', $tansporteur)
    ]" />

    <h2>✏️ Modifier Transporteur: {{ $tansporteur->nom }} {{ $tansporteur->prenom }}</h2>

    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('tansporteurs.update', $tansporteur) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">CIN <span class="text-danger">*</span></label>
                        <input type="text" name="cin_t" class="form-control @error('cin_t') is-invalid @enderror" value="{{ old('cin_t', $tansporteur->cin_t) }}" maxlength="10" required>
                        @error('cin_t')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $tansporteur->nom) }}" maxlength="25" required>
                        @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prénom <span class="text-danger">*</span></label>
                        <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom', $tansporteur->prenom) }}" maxlength="25" required>
                        @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                        <input type="text" name="tel" class="form-control @error('tel') is-invalid @enderror" value="{{ old('tel', $tansporteur->tel) }}" maxlength="25" required>
                        @error('tel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
                    <a href="{{ route('tansporteurs.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection
