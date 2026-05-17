@extends('layouts.app')

@section('title', 'Détails Utilisateur')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="[
        '👥 Utilisateurs' => route('users.index'),
        'Détails' => route('users.show', $user)
    ]" />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>👤 {{ $user->name }}</h2>
        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">✏️ Modifier</a>
    </div>

    <div class="card mb-4">
        <div class="card-header"><strong>Informations</strong></div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $user->id }}</dd>

                <dt class="col-sm-3">Nom complet</dt>
                <dd class="col-sm-9">{{ $user->name }}</dd>

                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $user->email }}</dd>

                <dt class="col-sm-3">Rôle</dt>
                <dd class="col-sm-9">
                    @if($user->is_admin)
                        <span class="badge bg-danger rounded-pill">Admin</span>
                    @else
                        <span class="badge bg-secondary rounded-pill">Utilisateur</span>
                    @endif
                </dd>

                <dt class="col-sm-3">Téléphone</dt>
                <dd class="col-sm-9">{{ $user->tel ?? '—' }}</dd>

                <dt class="col-sm-3">Email vérifié</dt>
                <dd class="col-sm-9">
                    @if($user->email_verified_at)
                        <span class="badge bg-success">Oui — {{ $user->email_verified_at->format('d/m/Y') }}</span>
                    @else
                        <span class="badge bg-warning text-dark">Non vérifié</span>
                    @endif
                </dd>

                <dt class="col-sm-3">Créé le</dt>
                <dd class="col-sm-9">{{ $user->created_at->format('d/m/Y H:i') }}</dd>
            </dl>
        </div>
    </div>
</div>
@endsection
