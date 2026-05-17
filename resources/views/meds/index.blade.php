@extends('layouts.app')

@section('title', 'Médicaments')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="['💊 Médicaments' => route('meds.index')]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>💊 Gestion des Médicaments</h2>
        @can('create', App\Models\Meds::class)
        <a href="{{ route('meds.create') }}" class="btn btn-primary">+ Ajouter</a>
        @endcan
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Libellé</th>
                        <th>Quantité</th>
                        <th>Prix Unitaire</th>
                        <th>Date Expiration</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($meds as $med)
                    <tr @if($med->quantite_med < 5) class="table-warning" @endif @if($med->dateexp_med && $med->dateexp_med < now()) class="table-danger" @endif>
                        <td>{{ $med->libelle }}</td>
                        <td><strong>{{ $med->quantite_med }}</strong></td>
                        <td>{{ number_format($med->prix_med, 2) }} €</td>
                        <td>{{ $med->dateexp_med?->format('d/m/Y') ?? '-' }}</td>
                        <td>
                            @if($med->quantite_med < 5)
                                <span class="badge bg-warning">Stock bas</span>
                            @elseif($med->dateexp_med && $med->dateexp_med < now())
                                <span class="badge bg-danger">Expiré</span>
                            @else
                                <span class="badge bg-success">OK</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('meds.show', $med) }}" class="btn btn-info">👁️</a>
                                @can('update', $med)
                                <a href="{{ route('meds.edit', $med) }}" class="btn btn-warning">✏️</a>
                                @endcan
                                @can('delete', $med)
                                <form method="POST" action="{{ route('meds.destroy', $med) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger" onclick="return confirm('Supprimer?')">🗑️</button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Aucun médicament</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $meds->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
