@extends('layouts.app')

@section('title', 'Vendeurs')

@section('content')
    <x-breadcrumbs :items="['🤝 Vendeurs' => route('vendeurs.index')]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="font-weight-bolder mb-4">🤝 Gestion des Vendeurs</h5>
        @can('create', App\Models\Vendeur::class)
        <a href="{{ route('vendeurs.create') }}" class="btn btn-primary">+ Ajouter un Vendeur</a>
        @endcan
    </div>

    <div class="card shadow">
        <div class="card-header pb-0">
            <h6 class="mb-0 font-weight-bolder">Liste des Vendeurs</h6>
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
                    @foreach($vendeurs as $vendeur)
                    <tr>
                        <td>{{ $vendeur->id_vend }}</td>
                        <td>{{ $vendeur->nom_vend }}</td>
                        <td>{{ $vendeur->prenom_vend }}</td>
                        <td>{{ $vendeur->tel_vend }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('vendeurs.show', $vendeur) }}" class="btn btn-sm btn-info text-white">👁️</a>
                                @can('update', $vendeur)
                                <a href="{{ route('vendeurs.edit', $vendeur) }}" class="btn btn-sm btn-warning">✏️</a>
                                @endcan
                                @can('delete', $vendeur)
                                <form action="{{ route('vendeurs.destroy', $vendeur) }}" method="POST" data-confirm="Confirmer la suppression ?">
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
            {{ $vendeurs->links() }}
        </div>
    </div>
@endsection
