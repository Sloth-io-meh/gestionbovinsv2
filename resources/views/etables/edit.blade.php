@extends('layouts.app')

@section('title', 'Modifier Étable')

@section('content')
    <x-breadcrumbs :items="[
        '🏠 Étables' => route('etables.index'),
        'Modifier' => route('etables.edit', $etable)
    ]" />

    <h5 class="font-weight-bolder mb-4">Modifier l'Étable: {{ $etable->nom }}</h5>

    <div class="card shadow">
        <div class="card-header pb-0">
            <h6 class="mb-0 font-weight-bolder">Modifier Étable</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('etables.update', $etable) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nom <span class="text-danger">*</span></label>
                    <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $etable->nom) }}" required>
                    @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
                    <a href="{{ route('etables.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection
