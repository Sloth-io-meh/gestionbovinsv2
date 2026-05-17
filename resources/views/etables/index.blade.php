@extends('layouts.app')

@section('title', 'Étables')

@section('content')
    <x-breadcrumbs :items="['🏠 Étables' => route('etables.index')]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="font-weight-bolder mb-4">🏠 Gestion des Étables</h5>
        @can('create', App\Models\Etable::class)
        <a href="{{ route('etables.create') }}" class="btn btn-primary">+ Ajouter une Étable</a>
        @endcan
    </div>

    <div class="card shadow">
        <div class="card-header pb-0">
            <h6 class="mb-0 font-weight-bolder">Liste des Étables</h6>
        </div>
        <div class="card-body">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nom</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($etables as $etable)
                    <tr>
                        <td>{{ $etable->id_etab }}</td>
                        <td>{{ $etable->nom }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('etables.show', $etable) }}" class="btn btn-sm btn-info text-white">👁️</a>
                                @can('update', $etable)
                                <a href="{{ route('etables.edit', $etable) }}" class="btn btn-sm btn-warning">✏️</a>
                                @endcan
                                @can('delete', $etable)
                                <form action="{{ route('etables.destroy', $etable) }}" method="POST" data-confirm="Confirmer la suppression ?">
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
            <div class="d-flex justify-content-center mt-3">
                {{ $etables->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
