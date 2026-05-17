<x-guest-layout>
    @if (session('status'))
    <div class="alert alert-success mb-3 text-sm">{{ session('status') }}</div>
    @endif

    <h5 class="mb-1 font-weight-bolder">Connexion</h5>
    <p class="text-sm text-secondary mb-4">Entrez vos identifiants pour accéder au système</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label text-sm font-weight-bold">Adresse email</label>
            <input id="email" type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required autofocus autocomplete="username"
                   placeholder="votre@email.com">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label text-sm font-weight-bold">Mot de passe</label>
            <input id="password" type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   required autocomplete="current-password"
                   placeholder="••••••••">
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
            <label class="form-check-label text-sm text-secondary" for="remember_me">Se souvenir de moi</label>
        </div>

        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary">🔐 Se connecter</button>
        </div>

        @if (Route::has('password.request'))
        <div class="text-center">
            <a href="{{ route('password.request') }}" class="text-sm text-secondary text-decoration-none">
                Mot de passe oublié ?
            </a>
        </div>
        @endif
    </form>
</x-guest-layout>
