@extends('layouts.app')

@section('title', 'Visites Vétérinaires')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="['🏥 Visites' => route('visites.index')]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🏥 Visites Vétérinaires</h2>
        @can('create', App\Models\Visite::class)
        <a href="{{ route('visites.create') }}" class="btn btn-primary">+ Ajouter</a>
        @endcan
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Animal</th>
                        <th>Vétérinaire</th>
                        <th>Date</th>
                        <th>Prix</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($visites as $visite)
                    <tr>
                        <td>#{{ $visite->bovin?->id_bov }}</td>
                        <td>{{ $visite->veto?->nom_vet ?? '-' }}</td>
                        <td>{{ $visite->datepres?->format('d/m/Y') ?? '-' }}</td>
                        <td>{{ $visite->prix_pres ? number_format($visite->prix_pres, 2) . ' €' : '-' }}</td>
                        <td>{{ Str::limit($visite->description_v, 50) }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('visites.show', $visite) }}" class="btn btn-info">👁️</a>
                                @can('update', $visite)
                                <a href="{{ route('visites.edit', $visite) }}" class="btn btn-warning">✏️</a>
                                @endcan
                                @can('delete', $visite)
                                <form method="POST" action="{{ route('visites.destroy', $visite) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger" data-confirm="Supprimer?">🗑️</button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Aucune visite</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $visites->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
