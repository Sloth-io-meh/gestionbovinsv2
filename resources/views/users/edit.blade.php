@extends('layouts.app')

@section('title', 'Modifier Utilisateur')

@section('content')
<div class="container-fluid">
    <x-breadcrumbs :items="[
        '👥 Utilisateurs' => route('users.index'),
        'Modifier' => route('users.edit', $user)
    ]" />

    <h2>✏️ Modifier: {{ $user->name }}</h2>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('users.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom d'affichage <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror"
                               value="{{ old('prenom', $user->prenom) }}" maxlength="100">
                        @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
                               value="{{ old('nom', $user->nom) }}" maxlength="100">
                        @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="tel" class="form-control @error('tel') is-invalid @enderror"
                               value="{{ old('tel', $user->tel) }}" maxlength="25">
                        @error('tel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3 d-flex align-items-end">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_admin" id="is_admin" value="1"
                                   @checked(old('is_admin', $user->is_admin))
                                   @if($user->id === auth()->id()) disabled @endif>
                            <label class="form-check-label" for="is_admin">
                                Administrateur
                                @if($user->id === auth()->id())
                                    <small class="text-muted">(impossible de modifier son propre rôle)</small>
                                @endif
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
