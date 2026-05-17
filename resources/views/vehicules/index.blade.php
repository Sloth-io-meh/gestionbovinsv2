@extends('layouts.app')

@section('title', 'Véhicules')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="['🚗 Véhicules' => route('vehicules.index')]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🚗 Gestion des Véhicules</h2>
        @can('create', App\Models\Vehicule::class)
        <a href="{{ route('vehicules.create') }}" class="btn btn-primary">+ Ajouter un Véhicule</a>
        @endcan
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Matricule</th>
                        <th>Marque</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicules as $vehicule)
                    <tr>
                        <td>{{ $vehicule->id_veh }}</td>
                        <td>{{ $vehicule->matricule }}</td>
                        <td>{{ $vehicule->marque }}</td>
                        <td>{{ $vehicule->type }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('vehicules.show', $vehicule) }}" class="btn btn-sm btn-info text-white">👁️</a>
                                @can('update', $vehicule)
                                <a href="{{ route('vehicules.edit', $vehicule) }}" class="btn btn-sm btn-warning">✏️</a>
                                @endcan
                                @can('delete', $vehicule)
                                <form action="{{ route('vehicules.destroy', $vehicule) }}" method="POST" data-confirm="Confirmer la suppression ?">
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
            {{ $vehicules->links() }}
        </div>
    </div>
</div>
@endsection
