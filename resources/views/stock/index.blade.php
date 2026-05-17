@extends('layouts.app')

@section('title', 'Stock')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📦 Gestion du Stock</h2>
        <a href="{{ route('stock.create') }}" class="btn btn-primary">+ Ajouter</a>
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
                    <tr @if($item->quantiteAct < 5) class="table-warning" @endif @if($item->dateexp_s < now()) class="table-danger" @endif>
                        <td>{{ $item->libelle_st }}</td>
                        <td>{{ $item->quantite_s }}</td>
                        <td><strong>{{ $item->quantiteAct }}</strong></td>
                        <td>{{ number_format($item->prix_s, 2) }} €</td>
                        <td>{{ $item->dateexp_s?->format('d/m/Y') ?? '-' }}</td>
                        <td>
                            <a href="{{ route('stock.show', $item) }}" class="btn btn-sm btn-info">👁️</a>
                            <a href="{{ route('stock.edit', $item) }}" class="btn btn-sm btn-warning">✏️</a>
                            <form method="POST" action="{{ route('stock.destroy', $item) }}" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer?')">🗑️</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Aucun élément</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
