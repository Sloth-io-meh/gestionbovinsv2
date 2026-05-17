@extends('layouts.app')

@section('title', 'Ajouter Statut Quarantaine')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="[
        '🛡️ Quarantaines' => route('quarantaines.index'),
        'Ajouter' => route('quarantaines.create')
    ]" />

    <h2>➕ Ajouter un Statut de Quarantaine</h2>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('quarantaines.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Libellé <span class="text-danger">*</span></label>
                    <input type="text" name="libelle" class="form-control @error('libelle') is-invalid @enderror" value="{{ old('libelle') }}" required>
                    @error('libelle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">💾 Créer</button>
                    <a href="{{ route('quarantaines.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
