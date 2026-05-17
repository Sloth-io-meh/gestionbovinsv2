@extends('layouts.app')

@section('title', 'Étables')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="['🏠 Étables' => route('etables.index')]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🏠 Gestion des Étables</h2>
        @can('create', App\Models\Etable::class)
        <a href="{{ route('etables.create') }}" class="btn btn-primary">+ Ajouter une Étable</a>
        @endcan
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-sm table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Actions</th>
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
</div>
@endsection
