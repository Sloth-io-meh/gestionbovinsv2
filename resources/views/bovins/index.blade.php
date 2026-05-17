@extends('layouts.app')

@section('title', 'Bovins')

@section('content')
    <x-breadcrumbs :items="['🐄 Bovins' => route('bovins.index')]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🐄 Gestion des Bovins</h2>
        @can('create', App\Models\Bovin::class)
        <a href="{{ route('bovins.create') }}" class="btn btn-primary">+ Ajouter un Animal</a>
        @endcan
    </div>

    <!-- Filters -->
    <form method="GET" class="row mb-4">
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Tous les statuts</option>
                <option value="active" @selected(request('status') === 'active')>Actifs</option>
                <option value="sold" @selected(request('status') === 'sold')>Vendus</option>
                <option value="dead" @selected(request('status') === 'dead')>Décédés</option>
                <option value="quarantine" @selected(request('status') === 'quarantine')>En quarantaine</option>
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
    <div class="card shadow">
        <div class="card-header pb-0">
            <h6 class="mb-0 font-weight-bolder">Liste des Bovins</h6>
        </div>
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Race</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date Achat</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Prix Achat</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Étable</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Statut</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
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
                                <span class="badge bg-info text-white rounded-pill">Vendu</span>
                            @elseif($bovin->mort)
                                <span class="badge bg-danger text-white rounded-pill">Décédé</span>
                            @else
                                <span class="badge bg-success text-white rounded-pill">Actif</span>
                            @endif
                            @if($bovin->quarantaine)
                                <span class="badge bg-warning text-dark rounded-pill">🔒 {{ $bovin->quarantaine->libelle }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('bovins.show', $bovin) }}" class="btn btn-info">👁️</a>
                                @can('update', $bovin)
                                <a href="{{ route('bovins.edit', $bovin) }}" class="btn btn-warning">✏️</a>
                                @endcan
                                @can('delete', $bovin)
                                <form method="POST" action="{{ route('bovins.destroy', $bovin) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger" data-confirm="Supprimer?">🗑️</button>
                                </form>
                                @endcan
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
@endsection
