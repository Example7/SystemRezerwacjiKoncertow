<x-layout>
    <div class="container my-5">
        <a href="{{ route('concerts.manage') }}" class="btn btn-outline-secondary mb-4">
            <i class="fa-solid fa-arrow-left"></i> Wróć
        </a>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-microphone fa-2x text-primary"></i>
                <h2 class="fw-bold text-primary mb-0">Artyści</h2>
            </div>
            <a href="{{ route('artists.create') }}" class="btn btn-success">
                <i class="fa-solid fa-plus"></i> Dodaj artystę
            </a>
        </div>
        @include('partials._search', ['placeholder' => 'Wyszukaj arystę...'])

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($artists->count())
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($artists as $artist)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-primary">{{ $artist->name }}</h5>
                                <p class="card-text text-muted mb-4">
                                    Gatunek: {{ $artist->genre ?? 'Brak danych' }}
                                </p>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('artists.edit', $artist) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="fa-solid fa-pen"></i> Edytuj
                                    </a>
                                    <form action="{{ route('artists.destroy', $artist) }}" method="POST"
                                        onsubmit="return confirm('Na pewno usunąć?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm">
                                            <i class="fa-solid fa-trash"></i> Usuń
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $artists->links() }}
            </div>
        @else
            <div class="alert alert-info">Brak artystów.</div>
        @endif
    </div>
</x-layout>
