@extends('layouts.app')

@section('title', 'Stock')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="['📦 Stock' => route('stock.index')]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📦 Gestion du Stock</h2>
        @can('create', App\Models\Stock::class)
        <a href="{{ route('stock.create') }}" class="btn btn-primary">+ Ajouter</a>
        @endcan
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Libellé</th>
                        <th>Quantité Total</th>
                        <th>Quantité Actuelle</th>
                        <th>Prix Unitaire</th>
                        <th>Date Expiration</th>
                        <th>Actions</th>
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
                                    <button class="btn btn-danger" onclick="return confirm('Supprimer?')">🗑️</button>
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
</div>
@endsection
