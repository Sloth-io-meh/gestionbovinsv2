@extends('layouts.app')

@section('title', 'Transporteurs')

@section('content')
    <x-breadcrumbs :items="['🚛 Transporteurs' => route('tansporteurs.index')]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="font-weight-bolder mb-4">🚛 Gestion des Transporteurs</h5>
        @can('create', App\Models\Tansporteur::class)
        <a href="{{ route('tansporteurs.create') }}" class="btn btn-primary">+ Ajouter un Transporteur</a>
        @endcan
    </div>

    <div class="card shadow">
        <div class="card-header pb-0">
            <h6 class="mb-0 font-weight-bolder">Liste des Transporteurs</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">CIN</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nom</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Prénom</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Téléphone</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tansporteurs as $tansporteur)
                    <tr>
                        <td>{{ $tansporteur->cin_t }}</td>
                        <td>{{ $tansporteur->nom }}</td>
                        <td>{{ $tansporteur->prenom }}</td>
                        <td>{{ $tansporteur->tel }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('tansporteurs.show', $tansporteur) }}" class="btn btn-info">👁️</a>
                                @can('update', $tansporteur)
                                <a href="{{ route('tansporteurs.edit', $tansporteur) }}" class="btn btn-warning">✏️</a>
                                @endcan
                                @can('delete', $tansporteur)
                                <form action="{{ route('tansporteurs.destroy', $tansporteur) }}" method="POST" data-confirm="Confirmer la suppression ?" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">🗑️</button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Aucun transporteur</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $tansporteurs->links('pagination::bootstrap-5') }}
    </div>
@endsection
