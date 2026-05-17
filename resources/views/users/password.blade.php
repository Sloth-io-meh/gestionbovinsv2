@extends('layouts.app')

@section('title', 'Réinitialiser le mot de passe')

@section('content')

    <x-breadcrumbs :items="[
        '👥 Utilisateurs' => route('users.index'),
        $user->name => route('users.show', $user),
        'Mot de passe' => route('users.edit-password', $user)
    ]" />

    <h2>🔑 Réinitialiser le mot de passe : {{ $user->name }}</h2>

    <div class="card" style="max-width: 500px;">
        <div class="card-body">
            <form method="POST" action="{{ route('users.update-password', $user) }}" autocomplete="off">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label class="form-label">Nouveau mot de passe <span class="text-danger">*</span></label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required minlength="8" autocomplete="new-password">
                    <div class="form-text">Minimum 8 caractères.</div>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Confirmer le nouveau mot de passe <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation"
                           class="form-control"
                           required minlength="8" autocomplete="new-password">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning">🔑 Réinitialiser</button>
                    <a href="{{ route('users.show', $user) }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection
