@extends('layouts.app')

@section('title', 'Quarantaines')

@section('content')

    <x-breadcrumbs :items="['🛡️ Quarantaines' => route('quarantaines.index')]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🛡️ Gestion des Statuts de Quarantaine</h2>
        @can('create', App\Models\Quarantaine::class)
        <a href="{{ route('quarantaines.create') }}" class="btn btn-primary">+ Ajouter un Statut</a>
        @endcan
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Libellé</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quarantaines as $quarantaine)
                    <tr>
                        <td>{{ $quarantaine->id_q }}</td>
                        <td>{{ $quarantaine->libelle }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('quarantaines.show', $quarantaine) }}" class="btn btn-sm btn-info text-white">👁️</a>
                                @can('update', $quarantaine)
                                <a href="{{ route('quarantaines.edit', $quarantaine) }}" class="btn btn-sm btn-warning">✏️</a>
                                @endcan
                                @can('delete', $quarantaine)
                                <form action="{{ route('quarantaines.destroy', $quarantaine) }}" method="POST" data-confirm="Confirmer la suppression ?">
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
            {{ $quarantaines->links() }}
        </div>
    </div>
@endsection
