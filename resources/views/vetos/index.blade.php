@extends('layouts.app')

@section('title', 'Vétos')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="['🩺 Vétos' => route('vetos.index')]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🩺 Gestion des Vétérinaires</h2>
        @can('create', App\Models\Veto::class)
        <a href="{{ route('vetos.create') }}" class="btn btn-primary">+ Ajouter un Vétérinaire</a>
        @endcan
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Téléphone</th>
                        <th>Actions</th>
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
</div>
@endsection
