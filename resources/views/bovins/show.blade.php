@extends('layouts.app')

@section('title', 'Bovin #' . $bovin->id_bov)

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="[
        '🐄 Bovins' => route('bovins.index'),
        'Animal #' . $bovin->id_bov => route('bovins.show', $bovin),
    ]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🐄 Bovin #{{ $bovin->id_bov }}</h2>
        <div>
            @can('update', $bovin)
                <a href="{{ route('bovins.edit', $bovin) }}" class="btn btn-warning">✏️ Modifier</a>
            @endcan
            <a href="{{ route('bovins.index') }}" class="btn btn-secondary">← Retour</a>
        </div>
    </div>

    <div class="row">
        <!-- Information -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Informations Générales</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Race:</dt>
                        <dd class="col-sm-8"><strong>{{ $bovin->race }}</strong></dd>

                        <dt class="col-sm-4">Étable:</dt>
                        <dd class="col-sm-8">{{ $bovin->etable?->nom ?? '-' }}</dd>

                        <dt class="col-sm-4">Vendeur:</dt>
                        <dd class="col-sm-8">{{ $bovin->vendeur?->prenom_vend }} {{ $bovin->vendeur?->nom_vend ?? '-' }}</dd>

                        <dt class="col-sm-4">Statut:</dt>
                        <dd class="col-sm-8">
                            @if($bovin->vendu)
                                <span class="badge bg-info">Vendu</span>
                            @elseif($bovin->mort)
                                <span class="badge bg-danger">Décédé</span>
                            @else
                                <span class="badge bg-success">Actif</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Quarantaine:</dt>
                        <dd class="col-sm-8">{{ $bovin->quarantaine?->libelle ?? '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Achat -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Achat</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Date:</dt>
                        <dd class="col-sm-8">{{ $bovin->dateachat?->format('d/m/Y') ?? '-' }}</dd>

                        <dt class="col-sm-4">Lieu:</dt>
                        <dd class="col-sm-8">{{ $bovin->lieuachat ?? '-' }}</dd>

                        <dt class="col-sm-4">Prix:</dt>
                        <dd class="col-sm-8">{{ $bovin->prixachat ? number_format($bovin->prixachat, 2) . ' €' : '-' }}</dd>

                        <dt class="col-sm-4">Poids:</dt>
                        <dd class="col-sm-8">{{ $bovin->poidachat ?? '-' }} kg</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Vente -->
        @if($bovin->vendu)
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Vente</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Date:</dt>
                        <dd class="col-sm-8">{{ $bovin->datevente?->format('d/m/Y') ?? '-' }}</dd>

                        <dt class="col-sm-4">Lieu:</dt>
                        <dd class="col-sm-8">{{ $bovin->lieuvente ?? '-' }}</dd>

                        <dt class="col-sm-4">Prix:</dt>
                        <dd class="col-sm-8">{{ $bovin->prixavente ? number_format($bovin->prixavente, 2) . ' €' : '-' }}</dd>

                        <dt class="col-sm-4">Poids:</dt>
                        <dd class="col-sm-8">{{ $bovin->poidvente ?? '-' }} kg</dd>
                    </dl>
                </div>
            </div>
        </div>
        @else
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Poids Actuel</h5>
                </div>
                <div class="card-body">
                    <p class="mb-3">Poids: <strong>{{ $bovin->poidAct ?? '?' }} kg</strong></p>
                    <form method="POST" action="{{ route('bovins.update-weight', $bovin) }}">
                        @csrf
                        <div class="input-group">
                            <input type="number" name="poidAct" class="form-control" step="0.1" placeholder="Nouveau poids" required>
                            <button class="btn btn-primary" type="submit">⚖️ Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <!-- Mort -->
        @if($bovin->mort)
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Décès</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Date:</dt>
                        <dd class="col-sm-8">{{ $bovin->datemort?->format('d/m/Y') ?? '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        @endif

        <!-- Journaux (Logs) -->
        @if($bovin->nourriture->count() > 0)
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Alimentation ({{ $bovin->nourriture->count() }} entrées)</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr><th>Libellé</th><th>Quantité</th><th>Date</th></tr>
                        </thead>
                        <tbody>
                            @foreach($bovin->nourriture as $log)
                            <tr>
                                <td>{{ $log->libelle_n }}</td>
                                <td>{{ $log->quantite_n }}</td>
                                <td>{{ $log->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        @if($bovin->medicsconsumed->count() > 0)
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Médicaments ({{ $bovin->medicsconsumed->count() }} entrées)</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr><th>Médicament</th><th>Quantité</th><th>Date</th></tr>
                        </thead>
                        <tbody>
                            @foreach($bovin->medicsconsumed as $log)
                            <tr>
                                <td>{{ $log->libelle_m }}</td>
                                <td>{{ $log->quantite_m }}</td>
                                <td>{{ $log->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        @if($bovin->visites->count() > 0)
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Visites Vétérinaires ({{ $bovin->visites->count() }} entrées)</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr><th>Vétérinaire</th><th>Description</th><th>Date</th><th>Prix</th></tr>
                        </thead>
                        <tbody>
                            @foreach($bovin->visites as $visite)
                            <tr>
                                <td>{{ $visite->veto?->nom_vet }}</td>
                                <td>{{ $visite->description_v }}</td>
                                <td>{{ $visite->datepres?->format('d/m/Y') ?? '-' }}</td>
                                <td>{{ $visite->prix_pres ? number_format($visite->prix_pres, 2) . ' €' : '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Actions -->
    <div class="card mt-4">
        <div class="card-body">
            @can('update', $bovin)
                @if(!$bovin->vendu && !$bovin->mort)
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#markSoldModal">💰 Marquer comme vendu</button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#markDeadModal">☠️ Marquer comme décédé</button>
                @endif
            @endcan

            @can('delete', $bovin)
                <form method="POST" action="{{ route('bovins.destroy', $bovin) }}" style="display: inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Êtes-vous sûr?')">🗑️ Supprimer</button>
                </form>
            @endcan
        </div>
    </div>
</div>

<!-- Mark Sold Modal -->
<div class="modal fade" id="markSoldModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('bovins.mark-sold', $bovin) }}">
                @csrf
                <div class="modal-header">
                    <h5>Marquer comme vendu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Date de Vente</label>
                        <input type="date" name="datevente" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lieu de Vente</label>
                        <input type="text" name="lieuvente" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prix de Vente</label>
                        <input type="number" name="prixavente" class="form-control" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Poids à la Vente</label>
                        <input type="number" name="poidvente" class="form-control" step="0.1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Confirmer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Mark Dead Modal -->
<div class="modal fade" id="markDeadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('bovins.mark-dead', $bovin) }}">
                @csrf
                <div class="modal-header">
                    <h5>Marquer comme décédé</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Date du Décès</label>
                        <input type="date" name="datemort" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Confirmer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
