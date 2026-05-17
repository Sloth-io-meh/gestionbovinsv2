@extends('layouts.app')

@section('title', 'Modifier Quarantaine')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="[
        '🛡️ Quarantaines' => route('quarantaines.index'),
        'Modifier' => route('quarantaines.edit', $quarantaine)
    ]" />

    <h2>✏️ Modifier Statut Quarantaine: {{ $quarantaine->libelle }}</h2>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('quarantaines.update', $quarantaine) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Libellé <span class="text-danger">*</span></label>
                    <input type="text" name="libelle" class="form-control @error('libelle') is-invalid @enderror" value="{{ old('libelle', $quarantaine->libelle) }}" required>
                    @error('libelle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
                    <a href="{{ route('quarantaines.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
