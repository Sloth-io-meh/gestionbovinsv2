@extends('layouts.app')

@section('title', 'Utilisateurs')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="['👥 Utilisateurs' => route('users.index')]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>👥 Gestion des Utilisateurs</h2>
        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-secondary">{{ $users->total() }} utilisateur(s)</span>
            <a href="{{ route('users.create') }}" class="btn btn-success btn-sm">➕ Nouvel utilisateur</a>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Créé le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr @if($user->id === auth()->id()) class="table-info" @endif>
                        <td>{{ $user->id }}</td>
                        <td>
                            {{ $user->name }}
                            @if($user->id === auth()->id())
                                <span class="badge bg-primary ms-1">Vous</span>
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->is_admin)
                                <span class="badge bg-danger rounded-pill">Admin</span>
                            @else
                                <span class="badge bg-secondary rounded-pill">Utilisateur</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('users.show', $user) }}" class="btn btn-info">👁️</a>
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">✏️</a>
                                <a href="{{ route('users.edit-password', $user) }}" class="btn btn-secondary" title="Réinitialiser le mot de passe">🔑</a>
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('users.destroy', $user) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger" data-confirm="Supprimer {{ $user->name }} ?">🗑️</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Aucun utilisateur</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
