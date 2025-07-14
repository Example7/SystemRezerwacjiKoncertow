<x-layout>
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 500px;">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Logowanie</h2>
                <p class="text-center text-muted mb-4">Zaloguj się, aby zarządzać swoimi koncertami</p>

                <form action="{{ route('users.authenticate') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Adres email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Hasło</label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label for="remember" class="form-check-label">Zapamiętaj mnie</label>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary">Zaloguj się</button>
                    </div>

                    <div class="text-center">
                        <small>Nie masz konta?
                            <a href="{{ route('users.register') }}">Zarejestruj się</a>
                        </small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
