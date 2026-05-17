@extends('layouts.app')

@section('title', 'Modifier Bovin #' . $bovin->id_bov)

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="[
        '🐄 Bovins' => route('bovins.index'),
        'Modifier' => route('bovins.edit', $bovin)
    ]" />

    <h2>✏️ Modifier Bovin #{{ $bovin->id_bov }}</h2>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('bovins.update', $bovin) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Race <span class="text-danger">*</span></label>
                        <input type="text" name="race" class="form-control @error('race') is-invalid @enderror" 
                               value="{{ old('race', $bovin->race) }}" required>
                        @error('race')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lieu d'Achat <span class="text-danger">*</span></label>
                        <input type="text" name="lieuachat" class="form-control @error('lieuachat') is-invalid @enderror" 
                               value="{{ old('lieuachat', $bovin->lieuachat) }}" required>
                        @error('lieuachat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Date Achat <span class="text-danger">*</span></label>
                        <input type="date" name="dateachat" class="form-control @error('dateachat') is-invalid @enderror" 
                               value="{{ old('dateachat', $bovin->dateachat?->format('Y-m-d')) }}" required>
                        @error('dateachat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Prix Achat <span class="text-danger">*</span></label>
                        <input type="number" name="prixachat" class="form-control @error('prixachat') is-invalid @enderror" 
                               value="{{ old('prixachat', $bovin->prixachat) }}" step="0.01" required>
                        @error('prixachat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Poids Achat <span class="text-danger">*</span></label>
                        <input type="number" name="poidachat" class="form-control @error('poidachat') is-invalid @enderror" 
                               value="{{ old('poidachat', $bovin->poidachat) }}" step="0.1" required>
                        @error('poidachat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Poids Actuel</label>
                        <input type="number" name="poidAct" class="form-control @error('poidAct') is-invalid @enderror" 
                               value="{{ old('poidAct', $bovin->poidAct) }}" step="0.1">
                        @error('poidAct')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Étable <span class="text-danger">*</span></label>
                        <select name="id_etab" class="form-select @error('id_etab') is-invalid @enderror" required>
                            <option value="">Sélectionner une étable</option>
                            @foreach($etables as $etable)
                            <option value="{{ $etable->id_etab }}" @selected(old('id_etab', $bovin->id_etab) == $etable->id_etab)>
                                {{ $etable->nom }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_etab')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Vendeur <span class="text-danger">*</span></label>
                        <select name="id_vend" class="form-select @error('id_vend') is-invalid @enderror" required>
                            <option value="">Sélectionner un vendeur</option>
                            @foreach($vendeurs as $vendeur)
                            <option value="{{ $vendeur->id_vend }}" @selected(old('id_vend', $bovin->id_vend) == $vendeur->id_vend)>
                                {{ $vendeur->prenom_vend }} {{ $vendeur->nom_vend }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_vend')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Quarantaine <span class="text-danger">*</span></label>
                        <select name="id_q" class="form-select @error('id_q') is-invalid @enderror" required>
                            <option value="">Sélectionner un statut</option>
                            @foreach($quarantaines as $q)
                            <option value="{{ $q->id_q }}" @selected(old('id_q', $bovin->id_q) == $q->id_q)>
                                {{ $q->libelle }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_q')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
                    <a href="{{ route('bovins.show', $bovin) }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
