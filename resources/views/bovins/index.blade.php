@extends('layouts.app')

@section('title', 'Bovins')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🐄 Gestion des Bovins</h2>
        <a href="{{ route('bovins.create') }}" class="btn btn-primary">+ Ajouter un Animal</a>
    </div>

    <!-- Filters -->
    <form method="GET" class="row mb-4">
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Tous les statuts</option>
                <option value="active" @selected(request('status') === 'active')>Actifs</option>
                <option value="sold" @selected(request('status') === 'sold')>Vendus</option>
                <option value="dead" @selected(request('status') === 'dead')>Décédés</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="etab" class="form-select">
                <option value="">Toutes les étables</option>
                @foreach($etables as $etable)
                <option value="{{ $etable->id_etab }}" @selected(request('etab') == $etable->id_etab)>
                    {{ $etable->nom }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-secondary w-100">🔍 Filtrer</button>
        </div>
    </form>

    <!-- Bovins Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Race</th>
                        <th>Date Achat</th>
                        <th>Prix Achat</th>
                        <th>Étable</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bovins as $bovin)
                    <tr>
                        <td><strong>{{ $bovin->id_bov }}</strong></td>
                        <td>{{ $bovin->race }}</td>
                        <td>{{ $bovin->dateachat?->format('d/m/Y') ?? '-' }}</td>
                        <td>{{ $bovin->prixachat ? number_format($bovin->prixachat, 2) . ' €' : '-' }}</td>
                        <td>{{ $bovin->etable?->nom ?? '-' }}</td>
                        <td>
                            @if($bovin->vendu)
                                <span class="badge-status badge-sold">Vendu</span>
                            @elseif($bovin->mort)
                                <span class="badge-status badge-dead">Décédé</span>
                            @else
                                <span class="badge-status badge-active">Actif</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('bovins.show', $bovin) }}" class="btn btn-info">👁️</a>
                                <a href="{{ route('bovins.edit', $bovin) }}" class="btn btn-warning">✏️</a>
                                <form method="POST" action="{{ route('bovins.destroy', $bovin) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer?')">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Aucun bovin trouvé</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $bovins->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
