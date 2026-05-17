@extends('layouts.app')

@section('title', 'Vendeurs')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="['🤝 Vendeurs' => route('vendeurs.index')]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🤝 Gestion des Vendeurs</h2>
        @can('create', App\Models\Vendeur::class)
        <a href="{{ route('vendeurs.create') }}" class="btn btn-primary">+ Ajouter un Vendeur</a>
        @endcan
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Téléphone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vendeurs as $vendeur)
                    <tr>
                        <td>{{ $vendeur->id_vend }}</td>
                        <td>{{ $vendeur->nom_vend }}</td>
                        <td>{{ $vendeur->prenom_vend }}</td>
                        <td>{{ $vendeur->tel_vend }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('vendeurs.show', $vendeur) }}" class="btn btn-sm btn-info text-white">👁️</a>
                                @can('update', $vendeur)
                                <a href="{{ route('vendeurs.edit', $vendeur) }}" class="btn btn-sm btn-warning">✏️</a>
                                @endcan
                                @can('delete', $vendeur)
                                <form action="{{ route('vendeurs.destroy', $vendeur) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')">
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
            {{ $vendeurs->links() }}
        </div>
    </div>
</div>
@endsection
