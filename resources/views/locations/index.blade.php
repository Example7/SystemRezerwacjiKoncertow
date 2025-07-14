<x-layout>
    <div class="container my-5">
        <a href="{{ route('concerts.manage') }}" class="btn btn-outline-secondary mb-4">
            <i class="fa-solid fa-arrow-left"></i> Wróć
        </a>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary mb-0">Wszystkie lokalizacje</h2>
            <a href="{{ route('locations.create') }}" class="btn btn-success shadow">
                <i class="fa-solid fa-plus"></i> Dodaj lokalizację
            </a>
        </div>
        @include('partials._search', ['placeholder' => 'Wyszukaj lokalizację...'])

        @if ($locations->count())
            <div class="row g-4">
                @foreach ($locations as $location)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card border-0 shadow position-relative overflow-hidden h-100 location-card">
                            <div class="card-body d-flex flex-column text-white">
                                <div class="position-absolute top-0 end-0 p-2">
                                    <span class="badge bg-light text-dark fw-bold">
                                        <i class="fa-solid fa-music"></i> {{ $location->concerts_count }}
                                    </span>
                                </div>

                                <div class="mb-4">
                                    <i class="fa-solid fa-location-dot fa-3x"></i>
                                </div>

                                <h5 class="fw-bold mb-2">{{ $location->name }}</h5>

                                <p class="mb-4">
                                    <i class="fa-solid fa-map-marker-alt me-1"></i>
                                    {{ $location->address }}
                                </p>

                                <div class="mt-auto d-flex gap-2">
                                    <a href="{{ route('locations.edit', $location) }}"
                                        class="btn btn-sm btn-light text-dark rounded-circle shadow-sm">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('locations.destroy', $location) }}" method="POST"
                                        onsubmit="return confirm('Na pewno chcesz usunąć tę lokalizację?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-light text-dark rounded-circle shadow-sm">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $locations->links() }}
            </div>
        @else
            <div class="alert alert-info text-center">
                Brak lokalizacji. <a href="{{ route('locations.create') }}">Dodaj nową</a>.
            </div>
        @endif
    </div>
</x-layout>
