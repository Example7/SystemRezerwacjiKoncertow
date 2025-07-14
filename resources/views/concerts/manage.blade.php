<x-layout>
    <div class="container my-5">
        <a href="{{ route('concerts.index') }}" class="btn btn-outline-secondary mb-4">
            <i class="fa-solid fa-arrow-left"></i> Wróć
        </a>

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h2 class="fw-bold text-primary mb-0">
                <i class="fa-solid fa-gear"></i> Zarządzaj koncertami
            </h2>

            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('concerts.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Nowy koncert
                </a>
                <a href="{{ route('locations.index') }}"
                    class="btn btn-outline-secondary d-flex align-items-center gap-2">
                    <i class="fa-solid fa-location-dot"></i> Lokacje
                </a>
                <a href="{{ route('artists.index') }}" class="btn btn-outline-success d-flex align-items-center gap-2">
                    <i class="fa-solid fa-microphone"></i> Artyści
                </a>
            </div>
        </div>

        @include('partials._search', ['placeholder' => 'Wyszukaj koncert...'])

        @if ($concerts->count())
            <div class="row g-4">
                @foreach ($concerts as $concert)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow border-0 rounded-4 overflow-hidden">
                            <div class="ratio ratio-16x9 bg-light"
                                style="background: url('{{ asset('images/concert-bg.png') }}') center/cover no-repeat;">
                            </div>

                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="card-title fw-bold mb-2 text-primary">
                                    <i class="fa-solid fa-music me-1"></i> {{ $concert->title }}
                                </h5>
                                <p class="text-muted mb-1">
                                    <i class="fa-regular fa-calendar me-1"></i>
                                    {{ \Carbon\Carbon::parse($concert->concert_date)->format('d.m.Y H:i') }}
                                </p>
                                <p class="text-muted mb-3">
                                    <i class="fa-solid fa-location-dot me-1"></i>
                                    {{ $concert->location->name ?? 'Brak lokalizacji' }}
                                </p>

                                <div class="mt-auto">
                                    @if ($concert->concert_date->isFuture())
                                        <a href="{{ route('concerts.edit', $concert->id) }}"
                                            class="btn btn-outline-primary w-100 mb-2 d-flex align-items-center justify-content-center gap-2">
                                            <i class="fa-solid fa-pen"></i> Edytuj koncert
                                        </a>
                                    @else
                                        <button
                                            class="btn btn-secondary w-100 mb-2 d-flex align-items-center justify-content-center gap-2"
                                            disabled>
                                            <i class="fa-solid fa-lock"></i> Koncert zakończony
                                        </button>
                                    @endif

                                    <form method="POST" action="{{ route('concerts.destroy', $concert->id) }}"
                                        onsubmit="return confirm('Na pewno chcesz usunąć ten koncert?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2">
                                            <i class="fa-solid fa-trash"></i> Usuń koncert
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info text-center">
                Nie masz jeszcze żadnych koncertów. Utwórz pierwszy!
            </div>
        @endif
    </div>
</x-layout>
