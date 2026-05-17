@extends('layouts.app')

@section('title', 'Stock')

@section('content')
    <x-breadcrumbs :items="['📦 Stock' => route('stock.index')]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="font-weight-bolder mb-4">📦 Gestion du Stock</h5>
        @can('create', App\Models\Stock::class)
        <a href="{{ route('stock.create') }}" class="btn btn-primary">+ Ajouter</a>
        @endcan
    </div>

    <div class="card shadow">
        <div class="card-header pb-0">
            <h6 class="mb-0 font-weight-bolder">Liste du Stock</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Libellé</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantité Total</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantité Actuelle</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Prix Unitaire</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date Expiration</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stock as $item)
                    <tr @if($item->quantiteAct < 5) class="table-warning" @endif @if($item->dateexp_s && $item->dateexp_s < now()) class="table-danger" @endif>
                        <td>{{ $item->libelle_st }}</td>
                        <td>{{ $item->quantite_s }}</td>
                        <td><strong>{{ $item->quantiteAct }}</strong></td>
                        <td>{{ number_format($item->prix_s, 2) }} €</td>
                        <td>{{ $item->dateexp_s?->format('d/m/Y') ?? '-' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('stock.show', $item) }}" class="btn btn-info">👁️</a>
                                @can('update', $item)
                                <a href="{{ route('stock.edit', $item) }}" class="btn btn-warning">✏️</a>
                                @endcan
                                @can('delete', $item)
                                <form method="POST" action="{{ route('stock.destroy', $item) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger" data-confirm="Supprimer?">🗑️</button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Aucun élément</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $stock->links('pagination::bootstrap-5') }}
    </div>
@endsection
