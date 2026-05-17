<x-guest-layout>
    @if (session('status'))
    <div class="alert alert-success mb-3">{{ session('status') }}</div>
    @endif

    <h5 class="card-title mb-4 text-center">Connexion</h5>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Adresse email</label>
            <input id="email" type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   required autocomplete="current-password">
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
            <label class="form-check-label text-muted" for="remember_me">Se souvenir de moi</label>
        </div>

        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary">🔐 Se connecter</button>
        </div>

        @if (Route::has('password.request'))
        <div class="text-center">
            <a href="{{ route('password.request') }}" class="text-decoration-none text-muted small">
                Mot de passe oublié ?
            </a>
        </div>
        @endif
    </form>
</x-guest-layout>
