@extends('layouts.app')

@section('title', 'Ajouter un Véhicule')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="[
        '🚗 Véhicules' => route('vehicules.index'),
        'Ajouter' => route('vehicules.create')
    ]" />

    <h2>➕ Ajouter un Véhicule</h2>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('vehicules.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Matricule <span class="text-danger">*</span></label>
                        <input type="text" name="Matricule" class="form-control @error('Matricule') is-invalid @enderror" value="{{ old('Matricule') }}" required maxlength="25">
                        @error('Matricule')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <input type="text" name="type" class="form-control @error('type') is-invalid @enderror" value="{{ old('type') }}" required maxlength="25">
                        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Transporteur</label>
                        <select name="id_trans" class="form-select @error('id_trans') is-invalid @enderror">
                            <option value="">— Aucun —</option>
                            @foreach($tansporteurs as $t)
                            <option value="{{ $t->id_trans }}" @selected(old('id_trans') == $t->id_trans)>
                                {{ $t->nom }} {{ $t->prenom }} ({{ $t->cin_t }})
                            </option>
                            @endforeach
                        </select>
                        @error('id_trans')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">💾 Créer</button>
                    <a href="{{ route('vehicules.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
