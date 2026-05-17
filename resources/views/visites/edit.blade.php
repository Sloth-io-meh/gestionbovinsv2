@extends('layouts.app')

@section('title', 'Modifier Visite')

@section('content')
    <h5 class="font-weight-bolder mb-4">Modifier Visite</h5>
    <div class="card shadow">
        <div class="card-header pb-0">
            <h6 class="mb-0 font-weight-bolder">Modifier Visite</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('visites.update', $visite) }}">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Animal</label>
                        <select name="id_bov" class="form-select">
                            @foreach($bovins as $b)
                            <option value="{{ $b->id_bov }}" @selected($visite->id_bov == $b->id_bov)>{{ $b->id_bov }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Vétérinaire</label>
                        <select name="id_vet" class="form-select">
                            @foreach($vetos as $v)
                            <option value="{{ $v->id_vet }}" @selected($visite->id_vet == $v->id_vet)>{{ $v->nom_vet }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="datepres" class="form-control" value="{{ old('datepres', $visite->datepres?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prix</label>
                        <input type="number" name="prix_pres" class="form-control" step="0.01" value="{{ old('prix_pres', $visite->prix_pres) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description_v" class="form-control">{{ old('description_v', $visite->description_v) }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
                <a href="{{ route('visites.show', $visite) }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
@endsection
