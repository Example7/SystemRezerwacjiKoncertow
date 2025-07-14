<section class="hero d-flex align-items-center justify-content-center text-center text-white py-5 mb-5">
    <div class="container">
        <h1 class="display-3 fw-bold mb-3" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
            Koncertomat
        </h1>
        <p class="lead mb-4" style="font-size: 1.5rem;">
            Znajdź najlepsze koncerty w swojej okolicy — dodawaj, zarządzaj lub rezerwuj bilety!
        </p>

        @auth
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('concerts.create') }}" class="btn btn-light btn-lg fw-semibold px-4 shadow-sm">
                    <i class="fa-solid fa-plus"></i> Dodaj nowy koncert
                </a>
            @else
                <p class="lead mb-0 fw-semibold">
                    <i class="fa-solid fa-ticket"></i> Możesz rezerwować bilety na dostępne koncerty
                </p>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn btn-light btn-lg fw-semibold px-4 shadow-sm">
                <i class="fa-solid fa-arrow-right-to-bracket"></i> Zaloguj się, aby korzystać z pełni możliwości!
            </a>
        @endauth
    </div>
</section>
