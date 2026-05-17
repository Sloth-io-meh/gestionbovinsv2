@extends('layouts.app')

@section('title', 'Vétos')

@section('content')
    <x-breadcrumbs :items="['🩺 Vétos' => route('vetos.index')]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="font-weight-bolder mb-4">🩺 Gestion des Vétérinaires</h5>
        @can('create', App\Models\Veto::class)
        <a href="{{ route('vetos.create') }}" class="btn btn-primary">+ Ajouter un Vétérinaire</a>
        @endcan
    </div>

    <div class="card shadow">
        <div class="card-header pb-0">
            <h6 class="mb-0 font-weight-bolder">Liste des Vétérinaires</h6>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nom</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Prénom</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Téléphone</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vetos as $veto)
                    <tr>
                        <td>{{ $veto->id_vet }}</td>
                        <td>{{ $veto->nom_vet }}</td>
                        <td>{{ $veto->prenom_vet }}</td>
                        <td>{{ $veto->tel_vet }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('vetos.show', $veto) }}" class="btn btn-sm btn-info text-white">👁️</a>
                                @can('update', $veto)
                                <a href="{{ route('vetos.edit', $veto) }}" class="btn btn-sm btn-warning">✏️</a>
                                @endcan
                                @can('delete', $veto)
                                <form action="{{ route('vetos.destroy', $veto) }}" method="POST" data-confirm="Confirmer la suppression ?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">🗑️</button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $vetos->links() }}
        </div>
    </div>
@endsection
