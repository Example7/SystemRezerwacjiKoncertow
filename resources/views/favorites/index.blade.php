<x-layout>
    <div class="container my-5">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mb-4">
            <i class="fa-solid fa-arrow-left"></i> Wróć
        </a>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-bookmark fa-2x text-primary"></i>
                <h2 class="fw-bold text-primary mb-0">Moje ulubione koncerty</h2>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($favorites->count())
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($favorites as $concert)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold text-primary">{{ $concert->title }}</h5>
                                <p class="card-text text-muted mb-2">
                                    Data: {{ \Carbon\Carbon::parse($concert->concert_date)->format('d.m.Y H:i') }}
                                </p>
                                <p class="card-text mb-4">
                                    Lokalizacja: {{ $concert->location->name ?? 'Brak lokalizacji' }}
                                </p>
                                <div class="mt-auto d-flex justify-content-between">
                                    <a href="{{ route('concerts.show', $concert) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="fa-solid fa-eye"></i> Zobacz
                                    </a>
                                    <form action="{{ route('favorites.toggle', $concert) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-outline-danger btn-sm">
                                            <i class="fa-solid fa-bookmark"></i> Usuń
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $favorites->links() }}
            </div>
        @else
            <div class="alert alert-info">Brak ulubionych koncertów.</div>
        @endif
    </div>
</x-layout>
