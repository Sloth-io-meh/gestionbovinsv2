@extends('layouts.app')

@section('title', 'Ajouter Visite')

@section('content')
    <h5 class="font-weight-bolder mb-4">Ajouter Visite</h5>
    <div class="card shadow">
        <div class="card-header pb-0">
            <h6 class="mb-0 font-weight-bolder">Ajouter Visite</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('visites.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Animal <span class="text-danger">*</span></label>
                        <select name="id_bov" class="form-select @error('id_bov') is-invalid @enderror" required>
                            <option value="">Sélectionner un animal</option>
                            @foreach($bovins as $b)
                            <option value="{{ $b->id_bov }}">{{ $b->id_bov }} - {{ $b->race }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Vétérinaire <span class="text-danger">*</span></label>
                        <select name="id_vet" class="form-select @error('id_vet') is-invalid @enderror" required>
                            <option value="">Sélectionner un vétérinaire</option>
                            @foreach($vetos as $v)
                            <option value="{{ $v->id_vet }}">{{ $v->nom_vet }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Date <span class="text-danger">*</span></label>
                        <input type="date" name="datepres" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prix</label>
                        <input type="number" name="prix_pres" class="form-control" step="0.01">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description_v" class="form-control"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">💾 Créer</button>
                <a href="{{ route('visites.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
@endsection
