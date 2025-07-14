@php
    $count = $concert->ratings_count;
    $label = match (true) {
        $count === 1 => 'ocena',
        $count >= 2 && $count <= 4 => 'oceny',
        default => 'ocen',
    };
@endphp

<x-layout>
    <a href="{{ url()->previous() }}" class="btn btn-link mb-1 mt-5 text-decoration-none text-muted">
        <i class="fa-solid fa-arrow-left"></i> Wróć
    </a>

    <div class="container my-4">
        <x-card class="p-5">
            <div class="d-flex flex-column align-items-center text-center">
                <div class="row align-items-center py-4">
                    <div class="col-md-5 text-center">
                        <img src="{{ asset('images/' . ($concert->image ?? 'concert-logo.png')) }}"
                            alt="{{ $concert->title }}" class="img-fluid" style="max-height: 300px; object-fit: cover;">
                    </div>
                    <div class="col-md-7">
                        <div id="countdown" class="mb-4 d-flex align-items-center text-danger fw-bold fs-5 gap-2">
                            <i class="fa-regular fa-clock"></i>
                            <span></span>
                        </div>
                        <h2
                            class="fw-bold text-primary d-flex justify-content-center align-items-center gap-2 mb-4 text-center">
                            <i class="fa-solid fa-music"></i> {{ $concert->title }}
                        </h2>

                        <ul class="list-inline mb-2">
                            @foreach ($concert->artists as $artist)
                                <li class="list-inline-item">
                                    <span class="badge bg-primary fs-6">
                                        <i class="fa-solid fa-microphone me-1"></i>{{ $artist->name }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>

                        <ul class="list-inline tag-list mb-4 p-3">
                            <x-concert-tags :tags="$concert->tags_array" />
                        </ul>
                    </div>
                </div>

                <div class="mb-4 fs-5 text-muted d-flex align-items-center justify-content-center">
                    <div>
                        <strong>{{ $concert->location->name }}</strong><br />
                        <i class="fa-solid fa-location-dot me-2 text-danger"></i>
                        <small class="text-secondary">{{ $concert->location->address }}</small>
                    </div>
                </div>

                @auth
                    <form action="{{ route('favorites.toggle', $concert->id) }}" method="POST" class="d-inline">
                        @csrf
                        @if (auth()->user()->favoriteConcerts->contains($concert->id))
                            <button type="submit" class="btn btn-warning">
                                <i class="fa-solid fa-bookmark"></i> Usuń z ulubionych
                            </button>
                        @else
                            <button type="submit" class="btn btn-outline-warning">
                                <i class="fa-regular fa-bookmark"></i> Dodaj do ulubionych
                            </button>
                        @endif
                    </form>
                @endauth

                <div class="w-100 mb-5">
                    <h5 class="text-primary text-start">Mapa lokalizacji</h5>
                    <iframe width="100%" height="300"
                        src="https://www.google.com/maps?q={{ urlencode($concert->location->address) }}&output=embed"
                        style="border:0;" allowfullscreen loading="lazy"></iframe>
                </div>

                <hr class="w-100 mb-5" />

                <div class="w-100 text-start">
                    <h3 class="mb-4 text-primary">Opis koncertu</h3>
                    <p class="mb-5 text-muted fs-5">{{ $concert->description }}</p>

                    @if ($concert->ratings_count > 0)
                        <div class="mb-4">
                            <h5 class="text-primary">Oceny uczestników</h5>
                            <div class="d-flex align-items-center gap-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i
                                        class="fa{{ $i <= round($concert->ratings_avg) ? 's' : 'r' }} fa-star text-warning"></i>
                                @endfor
                                <span class="ms-2">({{ $count }} {{ $label }})</span>
                            </div>
                        </div>
                    @endif

                    @if ($concert->concert_date->isFuture())
                        <div class="my-4">
                            <h5 class="text-primary">Bilety</h5>
                            <p class="text-muted">
                                Cena:
                                <strong>{{ number_format(optional($concert->tickets->first())->price ?? 0, 2) }}
                                    zł</strong><br />
                                @if ($concert->available_tickets > 0)
                                    Dostępne bilety:
                                    <strong>{{ $concert->available_tickets }}</strong>
                                @else
                                    <div class="alert alert-warning text-center mt-2">
                                        Brak dostępnych biletów
                                    </div>
                                @endif
                            </p>

                            @if (auth()->check() && $concert->available_tickets > 0)
                                <form action="{{ route('reservations.store') }}" method="POST" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="concert_id" value="{{ $concert->id }}">

                                    <div class="mb-3">
                                        <label for="ticket_count" class="form-label">Ilość biletów</label>
                                        <input type="number" name="ticket_count"
                                            class="form-control @error('ticket_count') is-invalid @enderror"
                                            value="{{ old('ticket_count', 1) }}" min="1">
                                        @error('ticket_count')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fa-solid fa-ticket"></i> Zarezerwuj bilety
                                    </button>
                                </form>
                            @elseif (!auth()->check() && $concert->available_tickets > 0)
                                <p class="mt-3">
                                    Aby zarezerwować bilety, <a href="{{ route('login') }}">zaloguj się</a>.
                                </p>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-info my-4 text-center">
                            <i class="fa-solid fa-circle-check"></i> Ten koncert już się odbył — rezerwacja nie jest
                            możliwa.
                        </div>
                    @endif

                    @if ($concert->email)
                        <a href="mailto:{{ $concert->email }}"
                            class="btn btn-danger w-100 mb-3 d-flex align-items-center justify-content-center gap-2">
                            <i class="fa-solid fa-envelope"></i> Kontakt z organizatorem
                        </a>
                    @endif

                    @if ($concert->website)
                        <a href="{{ $concert->website }}" target="_blank"
                            class="btn btn-dark w-100 d-flex align-items-center justify-content-center gap-2">
                            <i class="fa-solid fa-globe"></i> Strona koncertu
                        </a>
                    @endif

                </div>
            </div>
            @if (auth()->check() && auth()->user()->role === 'admin')
                <div class="w-100 d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('concerts.edit', $concert->id) }}" class="btn btn-outline-primary">
                        <i class="fa-solid fa-pen-to-square"></i> Edytuj koncert
                    </a>
                    <form method="POST" action="{{ route('concerts.destroy', $concert->id) }}"
                        onsubmit="return confirm('Na pewno chcesz usunąć ten koncert?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fa-solid fa-trash-can"></i> Usuń koncert
                        </button>
                    </form>
                </div>
            @endif
        </x-card>
    </div>

    <div class="card shadow-sm p-5 mb-4">
        <h3 class="text-primary mb-4">Nadchodzące koncerty</h3>
        <div class="row g-4">
            @forelse ($upcomingConcerts as $upcomingConcert)
                <x-concert-card :concert="$upcomingConcert" />
            @empty
                <p class="text-muted">Brak nadchodzących koncertów.</p>
            @endforelse
        </div>
    </div>

    <section class="text-white text-center d-flex justify-content-center align-items-center"
        style="height: 600px; background: url('{{ asset('images/concert-bg.png') }}') center center / cover no-repeat fixed; position: relative;">
        <div
            class="bg-dark bg-opacity-50 w-100 h-100 d-flex justify-content-center align-items-center flex-column px-3">
            <h2 class="display-4 fw-bold">Muzyka łączy ludzi</h2>
            <p class="lead">Dołącz do nas na najbliższym koncercie i poczuj magię dźwięku</p>
        </div>
    </section>

    <style>
        .parallax-section {
            position: relative;
            background-image: url('{{ asset('images/concert-bg.png') }}');
            height: 600px;
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        .parallax-section .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(34, 34, 34, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 20px;
        }
    </style>

    @if ($concert->concert_date)
        <script>
            const eventDate = new Date("{{ $concert->concert_date }}").getTime();

            const countdown = setInterval(() => {
                const now = new Date().getTime();
                const distance = eventDate - now;

                if (distance < 0) {
                    clearInterval(countdown);
                    document.getElementById('countdown').innerHTML = "Koncert już się odbył";
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById('countdown').innerHTML =
                    `Do koncertu pozostało: ${days}d ${hours}h ${minutes}m ${seconds}s`;
            }, 1000);
        </script>
    @else
        <script>
            document.getElementById('countdown').innerHTML = "Data koncertu nie jest dostępna";
        </script>
    @endif
</x-layout>
