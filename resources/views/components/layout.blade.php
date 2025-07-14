<!DOCTYPE html>
<html lang="pl">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link rel="icon" href="{{ asset('images/favicon.ico') }}" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet" />
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />

        <title>Projekt KK</title>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light px-4 py-2 shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                </a>

                <!-- Hamburger -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                    aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menu -->
                <div class="collapse navbar-collapse" id="mainNavbar">
                    <ul class="navbar-nav ms-auto align-items-center gap-3">

                        @auth
                            <!-- Tylko ADMIN -->
                            @if (auth()->user()->role === 'admin')
                                <li class="nav-item">
                                    <a href="{{ route('concerts.create') }}" class="nav-link">
                                        <i class="fa-solid fa-plus"></i> Dodaj koncert
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('concerts.manage') }}" class="nav-link">
                                        <i class="fa-solid fa-gear"></i> Zarządzaj ogłoszeniami
                                    </a>
                                </li>
                            @endif

                            <!-- Widoczne dla wszystkich zalogowanych -->
                            <li class="nav-item">
                                <a href="{{ route('reservations.index') }}" class="nav-link">
                                    <i class="fa-solid fa-ticket"></i> Moje rezerwacje
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('reservations.history') }}" class="nav-link">
                                    <i class="fa-solid fa-clock-rotate-left"></i> Moja historia
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('favorites.index') }}" class="nav-link">
                                    <i class="fa-solid fa-bookmark"></i> Ulubione koncerty
                                </a>
                            </li>

                            <li class="nav-item">
                                <span class="nav-link disabled">
                                    <i class="fa-regular fa-user me-1"></i> Witaj, {{ auth()->user()->name }}
                                </span>
                            </li>

                            <li class="nav-item">
                                <form action="/logout" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-door-closed"></i> Wyloguj się
                                    </button>
                                </form>
                            </li>
                        @else
                            <!-- Gość -->
                            <li class="nav-item">
                                <a class="nav-link" href="/register">
                                    <i class="fa-solid fa-user-plus"></i> Rejestracja
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/login">
                                    <i class="fa-solid fa-arrow-right-to-bracket"></i> Logowanie
                                </a>
                            </li>
                        @endauth

                    </ul>
                </div>
            </div>
        </nav>

        <main class="container">
            {{ $slot }}
        </main>

        <footer class="footer mt-5 py-4 text-center text-light">
            &copy; 2025 Projekt KK
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <x-flash-message />
    </body>

</html>
